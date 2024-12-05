<?php

namespace App\Notable\Routes\Guest;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink() : void {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email_error', __($status));

            return;
        }

        $this->reset('email');

        session()->put('status', __($status));
    }

    public function render() : View {
        return view('livewire.routes.guest.forgot-password');
    }
}
