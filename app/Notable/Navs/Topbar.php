<?php

namespace App\Notable\Navs;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Topbar extends Component {
    public function render() : View {
        return view('livewire.navs.topbar');
    }
}
