<?php

namespace App\Notable;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Note;
use Livewire\Attributes\On;

class AccordionButton extends Component {
    public string $icon;
    public string $base_clr_class;
    public string $focus_clr_class;
    public string $method;
    /**
     * @param int $id
     */
    public function deleteNote($id) : void {
        $n = Note::find($id);
        if (!$n) {
            $this->dispatch('note-not-found');
            return;
        }

        $allowed = $n->user_id == auth()->user()->id;
        if (!$allowed) {
            $this->dispatch('operation-not-allowed');
            return;
        }
        $deleted = $n->delete();
        if ($deleted) {
            $this->dispatch("note-updated");
        }


    }
    /**
     * @param int $id
     */
    public function editNote($id) : void {
        $this->dispatch("edit-note", note_id: $id);
    }
    /**
     * @param int $id
     */
    public function viewNote($id) : void {
        $this->dispatch("toggle-preview", note_id: $id);
    }

    #[On("note-updated")]
    public function render() : View {
        return view('livewire.accordion-button');
    }
}
