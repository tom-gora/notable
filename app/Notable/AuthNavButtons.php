<?php

namespace App\Notable;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class AuthNavButtons extends Component {
    public function logout(Logout $logout) : void {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render() {
        return view('livewire.auth-nav-buttons');
    }
}
