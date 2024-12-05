<?php

namespace App\Notable\Routes\Guest;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ResetPassword extends Component {
    #[Locked]
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token) : void {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword() : void {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::put('status', __($status));

        $this->redirectRoute('login', navigate: true);
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
        return view('livewire.routes.guest.reset-password');
    }
}
