<?php

namespace App\Notable\Core;

use App\Models\Note;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[On('note-updated'), On('editor-closed'), On('note-deleted')]
class HomeListingPane extends Component {
    use WithPagination;

    public string $filter = '';

    public ?string $group = null;

    public ?int $viewed = null;

    public ?int $edited = null;

    #[On('preview-closed')]
    public function unsetViewed() : void {
        $this->viewed = null;
    }

    #[On('editor-closed')]
    public function unsetEdited() : void {
        $this->group = null;
        $this->edited = null;
        $this->viewed = null;
    }

    public function toggle(string $group) : void {
        $this->group = $this->group === $group ? null : $group;
    }

    /**
     * @param  mixed  $id
     */
    public function deleteNote($id) : void {
        $n = Note::find($id);
        if (!$n) {
            return;
        }

        $allowed = $n->user_id == auth()->user()->id;
        if (!$allowed) {
            return;
        }
        $deleted = $n->delete();
        if ($deleted) {
            //TODO: needs separate event for deletion to handle ui state reset differently
            $this->dispatch('note-updated');
            $this->dispatch('note-deleted');
            $this->edited = null;
            $this->viewed = null;
        }
    }

    /**
     * @param  mixed  $id
     */
    public function editNote($id) : void {
        $this->dispatch('edit-note', note_id: $id);
        $this->edited = $id;
        $this->viewed = null;
    }

    /**
     * @param  mixed  $id
     */
    public function viewNote($id) : void {
        $this->dispatch('toggle-preview', note_id: $id);
        $this->viewed = $id;
        $this->edited = null;
    }

    public function getNotes() : mixed {
        // simplified using relationships at last
        $query = auth()->user()->notes();

        if ($this->filter !== '') {
            $query->where(
                function ($query) {
                    $query
                        ->where('title', 'like', '%' . $this->filter . '%')
                        ->orWhere('markdown', 'like', '%' . $this->filter . '%');
                }
            );
        }
        $results = $query->paginate(5);
        return $results->isEmpty() ? null : $results;
    }

    public function render() : View {
        return view('livewire.core.home-listing-pane', ['notes' => $this->getNotes()]);
    }
}
