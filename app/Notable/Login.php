<?php

namespace App\Notable;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

    public function exception($e, $stopPropagation) : void {
        // custom errors on validation fail
        $credentials = [
                    'email' => $this->form->email,
                    'password' => $this->form->password,
                ];
        if (Auth::attempt($credentials) === false) {
            $this->addError('pass_error', "Details don't match any registered user.");
            return;
        }

        $failed = $e->validator->failed();
        if (!empty($failed) && Arr::has($failed, "form.email") || $credentials->email == null) {
            $this->addError('email_error', "Valid email is required.");
            return;
        } elseif (!empty($failed) && Arr::has($failed, "form.password") || $credentials->password == null) {
            $this->addError('pass_error', "Valid password is required.");
            return;
        }
    }

    public function render() {
        return view('livewire.login');
    }
}
