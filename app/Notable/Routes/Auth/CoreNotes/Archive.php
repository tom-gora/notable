<?php

namespace App\Notable\Routes\Auth\CoreNotes;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Archive extends Component {
    public function render() : View {
        return view('livewire.routes.auth.core-notes.archive');
    }
}
