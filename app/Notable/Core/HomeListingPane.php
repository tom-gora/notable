<?php

namespace App\Notable\Core;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
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
        $n = auth()->user()->notes()->find($id);
        if (!$n) {
            return;
        }
        $deleted = $n->delete();
        if (!$deleted) {
            return;
        }
        //TODO: needs separate event for deletion to handle ui state reset differently
        $this->dispatch('note-updated');
        $this->dispatch('note-deleted');
        $this->edited = null;
        $this->viewed = null;
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

    #[Computed]
    public function notes() : ?object {
        // query based off model relationship now
        $query = auth()->user()->notes();
        /*filtering logic*/
        if ($this->filter === '') {
            return $query->latest('created_at')->paginate(5);
        } elseif (strlen($this->filter) > 0) {
            return $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->filter . '%')
                    ->orWhere('markdown', 'like', '%' . $this->filter . '%');
            })->get();
        }
        // if no filter AND no notes added yet
        // this will conditionally cause placeholder to render
        return null;
    }

    public function render() : View {
        return view('livewire.core.home-listing-pane');
    }
}
