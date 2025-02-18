<?php

namespace App\Notable\Navs\NavComponents;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('profile-updated')]
class TopbarGreeting extends Component {
    public ?string $greeting = null;

    public bool $welcome = false;

    /**
     * @param  mixed  $hour
     * @param  mixed  $client_hour
     */
    #[On('client-time')]
    public function setGreetingOnClientTime($client_hour) : void {
        if ($client_hour >= 1 && $client_hour < 12) {
            $this->greeting = 'Good Morning';
        } elseif ($client_hour >= 12 && $client_hour < 18) {
            $this->greeting = 'Good Afternoon';
        } elseif ($client_hour >= 18 && $client_hour <= 23) {
            $this->greeting = 'Good Evening';
        } elseif ($client_hour == 0) {
            $this->greeting = 'Time to Bed';
        } else {
            // generic default
            $this->greeting = 'Hello';
        }
    }

    #[Computed]
    public function name() : string {
        return strtok(auth()->user()->name, ' ');
    }

    public function render() : View {
        return view('livewire.navs.nav-components.topbar-greeting');
    }
}
