<?php

namespace App\Notable;

use Livewire\Component;
use App\Helpers\UI ;

class Sidebar extends Component {
    public array $links = [];
    public bool $sidebarState;

    public function isCurrent($url) : bool {
        return UI::isCurrent($url);
    }

    public function mount() {
        $this->links = UI::$SIDEBAR_LINKS;
        $this->sidebarState = UI::getSidebarState();
    }

    public function render() {
        return view('livewire.sidebar');
    }
}
