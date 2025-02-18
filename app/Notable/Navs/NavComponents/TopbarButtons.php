<?php

namespace App\Notable\Navs\NavComponents;

use App\Notable\Actions as A;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TopbarButtons extends Component {
    public function logout(A\Logout $logout) : void {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render() : View {
        return view('livewire.navs.nav-components.topbar-buttons');
    }
}
