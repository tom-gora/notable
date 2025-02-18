<?php

namespace App\Notable\Routes\Guest;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component {
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register() : void {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: false);
    }

    /**
     * @param  mixed  $e
     * @param  mixed  $stopPropagation
     */
    public function exception($e, $stopPropagation) : void {
        $failed = $e->validator->failed();
        if (!empty($failed) && Arr::has($failed, 'password') && Arr::has($failed, 'password.Confirmed')) {
            $this->addError('pass_error', 'Passwords must match.');
        } elseif (!empty($failed) && Arr::has($failed, 'email') && !empty($failed['email']['Unique'])) {
            $this->addError('email_error', 'Email already taken.');
        } elseif (!empty($failed) && Arr::has($failed, 'email') && Arr::has($failed, 'email.Lowercase')) {
            $this->addError('email_error', 'Email must be lowercase.');
        }
    }

    public function render() : View {
        return view('livewire.routes.guest.register');
    }
}
