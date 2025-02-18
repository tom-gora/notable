<?php

namespace App\Notable\Forms;

use App\Helpers\NoteHelpers as NH;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteModal extends Component {
    public int $id;

    public string $title;

    public bool $del_modal = false;

    #[On('request-del-modal')]
    public function dispatchModal(int $id, string $title) : void {
        $this->id = $id;
        $this->title = $title;
        $this->del_modal = true;
    }

    public function deleteNote($id) : void {
        $deleted = NH::deleteNote($id);
        $this->del_modal = false;
        if (!$deleted) {
            return;
        }
        // HACK: needs separate event for deletion to handle ui state reset differently
        $this->dispatch('note-updated');
        $this->dispatch('note-deleted');
    }

    public function render() : View {
        return view('livewire.forms.delete-modal');
    }
}
