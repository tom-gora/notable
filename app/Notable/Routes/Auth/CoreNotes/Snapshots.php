<?php

namespace App\Notable\Routes\Auth\CoreNotes;

use App\Helpers\NoteHelpers as NH;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('note-deleted')]
class Snapshots extends Component {
    /**
     * @param  mixed  $id
     */
    public function viewNote($id) : void {
        Session::flash('hook', ['action' => 'view', 'id' => $id]);
        $this->redirectRoute('home', navigate: true);
    }

    /**
     * @param  mixed  $id
     */
    public function editNote($id) : void {
        Session::flash('hook', ['action' => 'edit', 'id' => $id]);
        $this->redirectRoute('home', navigate: true);
    }

    public function archiveNote(string $id) : void {
        NH::archiveNote($id);
    }

    /**
     * @param  mixed  $id
     */
    public function deleteNote($id) : void {
        $deleted = NH::deleteNote($id);
        if (!$deleted) {
            return;
        }
        // HACK: needs separate event for deletion to handle ui state reset differently
        $this->dispatch('note-updated');
        $this->dispatch('note-deleted');
    }

    #[Computed(persist: false, cache: false)]
    public function notes() : ?object {
        // query based off model relationship now
        $notes = auth()->user()->notes()->latest('created_at')->where('is_archived', false)->get();

        if (!$notes) {
            return null;
        }
        return $notes;
    }

    public function render() : View {
        return view('livewire.routes.auth.core-notes.snapshots');
    }
}
