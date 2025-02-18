<?php

namespace App\Notable\Navs\NavComponents;

use App\Helpers\UI;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SidebarThemeToggle extends Component {
    public string $theme = '';

    public bool $sidebarState = false;

    public function mount() : void {
        $this->theme = UI::getTheme();
        $this->sidebarState = UI::getSidebarState();
    }

    public function render() : View {
        return view('livewire.navs.nav-components.sidebar-theme-toggle');
    }
}
