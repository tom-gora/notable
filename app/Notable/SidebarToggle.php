<?php

namespace App\Notable;

use App\Helpers\UI ;
use Livewire\Component;

class SidebarToggle extends Component {
    public bool $sidebarState;
    public function mount() {
        $this->sidebarState = UI::getSidebarState();
    }
    public function render() {
        return view('livewire.sidebar-toggle');
    }
}
