<?php

namespace App\Notable\Routes\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Welcome extends Component {
    public function render() : View {
        return view('livewire.routes.guest.welcome');
    }
}
