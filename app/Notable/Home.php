<?php

namespace App\Notable;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Home extends Component {
    /**
     * @return View
     */
    public function render() : View {
        return view('livewire.home');
    }
}
