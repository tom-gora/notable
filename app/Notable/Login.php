<?php

namespace App\Notable;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login() : void {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: false);
    }

    public function render() {
        return view('livewire.login');
    }
}
