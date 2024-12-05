<?php

namespace App\Notable\Navs\NavComponents;

use App\Helpers\UI;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SidebarToggle extends Component {
    public bool $sidebarState;

    public function mount() : void {
        $this->sidebarState = UI::getSidebarState();
    }

    public function render() : View {
        return view('livewire.navs.nav-components.sidebar-toggle');
    }
}
