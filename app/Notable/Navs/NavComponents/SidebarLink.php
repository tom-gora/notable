<?php

namespace App\Notable\Navs\NavComponents;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class SidebarLink extends Component {
    public string $icon;

    public string $href;

    public bool $current;

    public string $offset;

    public bool $sidebarState;

    public string $title;

    public function mount(string $title, string $icon, string $href, bool $current, string $offset, bool $sidebarState) : void {
        $this->icon = $icon;
        $this->href = $href;
        $this->current = $current;
        $this->offset = $offset;
        $this->sidebarState = $sidebarState;
        $this->title = $title;
    }

    public function render() : View {
        return view('livewire.navs.nav-components.sidebar-link');
    }
}
