<?php

namespace App\Notable\Core;

use App\Helpers\NoteHelpers as NH;
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

    public ?array $hook = null;

    public function mount() : void {
        if ($this->hook !== null && $this->hook['action'] === 'edit') {
            $this->editNote($this->hook['id']);
        } elseif ($this->hook !== null && $this->hook['action'] === 'view') {
            $this->viewNote($this->hook['id']);
        }
    }

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

    public function toggleFavourite(string $id) : void {
        NH::toggleNoteFavourite($id);
    }

    public function archiveNote(string $id) : void {
        NH::archiveNote($id);
    }

    #[On('note-deleted')]
    public function onDelete() : void {
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
        $query = auth()->user()->notes()->where('is_archived', false);
        /* filtering logic */
        if ($this->filter === '') {
            return $query->latest('created_at')->paginate(8);
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
