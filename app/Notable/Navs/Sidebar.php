<?php

namespace App\Notable\Navs;

use App\Helpers\UI;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Sidebar extends Component {
    public array $links = [];

    public bool $sidebarState;

    /**
     * @param  mixed  $url
     */
    public function isCurrent($url) : bool {
        return UI::isCurrent($url);
    }

    public function mount() : void {
        $this->links = UI::$SIDEBAR_LINKS;
        $this->sidebarState = UI::getSidebarState();
        /*dd($this->sidebarState);*/
    }

    public function render() : View {
        return view('livewire.navs.sidebar');
    }
}
