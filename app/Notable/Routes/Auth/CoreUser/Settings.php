<?php

namespace App\Notable\Routes\Auth\CoreUser;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Settings extends Component {
    public function render() : View {
        return view('livewire.routes.auth.core-user.settings');
    }
}