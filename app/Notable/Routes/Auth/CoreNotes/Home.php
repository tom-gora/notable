<?php

namespace App\Notable\Routes\Auth\CoreNotes;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Home extends Component {
    public ?array $hook = null;

    public function mount() : void {
        if (Session::has('hook')) {
            $h = Session::get('hook');
            $this->hook = $h;
            Session::remove('hook');
        }
    }

    public function render() : View {
        return view('livewire.routes.auth.core-notes.home');
    }
}
