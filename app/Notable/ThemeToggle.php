<?php

namespace App\Notable;

use App\Helpers\UI;
use Livewire\Component;

class ThemeToggle extends Component {
    public string $theme = "";
    public bool $sidebarState = false;

    public function mount() {
        $this->theme = UI::getTheme();
        $this->sidebarState = UI::getSidebarState();
    }
    public function render() {
        return view('livewire.theme-toggle');
    }
}
