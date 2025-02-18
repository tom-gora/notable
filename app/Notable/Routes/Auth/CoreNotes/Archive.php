<?php

namespace App\Notable\Routes\Auth\CoreNotes;

use App\Helpers\NoteHelpers as NH;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Archive extends Component {
    #[Computed(persist: false, cache: false)]
    public function notes() : ?object {
        // query based off model relationship now
        $notes = auth()->user()->notes()->latest('created_at')->where('is_archived', true);

        if (!$notes) {
            return null;
        }
        return $notes->get();
    }

    public function unarchiveNote($id) : void {
        NH::unarchiveNote($id);
    }

    public function render() : View {
        return view('livewire.routes.auth.core-notes.archive');
    }
}
