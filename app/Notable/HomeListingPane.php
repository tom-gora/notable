<?php

namespace App\Notable;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Note;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[On("note-updated")]
class HomeListingPane extends Component {
    use WithPagination;

    public string $filter = "";
    public ?string $group = null;

    public function toggle(string $group) {
        $this->group = $this->group === $group ? null : $group;
    }

    /*public function recomputeAfterChange() : void {*/
    /*    unset($this->notes);*/
    /*}*/

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
            $this->dispatch("note-updated");
        }
    }

    public function editNote($id) : void {
        $this->dispatch("edit-note", note_id: $id);
    }


    public function viewNote($id) : void {
        $this->dispatch("toggle-preview", note_id: $id);
    }


    public function getNotes() : mixed {
        // fetch with query builder
        if ($this->filter === "") {
            return Note::where("user_id", auth()->user()->id)->paginate(3);
        } elseif (strlen($this->filter) > 0) {
            return  Note::where("user_id", auth()->user()->id)
                ->where(function ($query) {
                    $query->where("title", "like", "%" . $this->filter . "%")
                          ->orWhere("markdown", "like", "%" . $this->filter . "%");
                })->get();

        } return null;
    }

    public function render() : View {
        return view('livewire.home-listing-pane', [
            'notes' => $this->getNotes()
        ]);
    }

}
