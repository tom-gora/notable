<?php

namespace App\Notable;

use Livewire\Component;

class SidebarLink extends Component {
    public string $icon;
    public string $href;
    public bool $current;
    public string $offset;
    public bool $sidebarState;
    public string $title;

    public function mount(string $title, string $icon, string $href, bool $current, string $offset, bool $sidebarState) {
        $this->icon = $icon;
        $this->href = $href;
        $this->current = $current;
        $this->offset = $offset;
        $this->sidebarState = $sidebarState;
        $this->title = $title;
    }
    public function render() {
        return view('livewire.sidebar-link');
    }
}
