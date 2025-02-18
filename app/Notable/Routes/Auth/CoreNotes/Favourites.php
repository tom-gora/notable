<?php

namespace App\Notable\Routes\Auth\CoreNotes;

use App\Helpers\NoteHelpers as NH;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('note-deleted')]
class Favourites extends Component {
    /**
     * @param  mixed  $id
     */
    public function toggleFavourite(string $id) : void {
        NH::toggleNoteFavourite($id);
    }

    public function viewNote($id) : void {
        Session::flash('hook', ['action' => 'view', 'id' => $id]);
        $this->redirectRoute('home', navigate: true);
    }

    public function editNote($id) : void {
        Session::flash('hook', ['action' => 'edit', 'id' => $id]);
        $this->redirectRoute('home', navigate: true);
    }

    public function archiveNote(string $id) : void {
        NH::archiveNote($id);
    }

    #[Computed(persist: false, cache: false)]
    public function notes() : ?object {
        // query based off model relationship now
        $notes = auth()->user()->notes()->latest('created_at')->where('is_favourite', true)->where('is_archived', false);

        if (!$notes) {
            return null;
        }
        return $notes->get();
    }

    public function render() : View {
        return view('livewire.routes.auth.core-notes.favourites');
    }
}
