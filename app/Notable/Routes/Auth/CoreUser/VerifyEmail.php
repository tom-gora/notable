<?php

namespace App\Notable\Routes\Auth\CoreUser;

use App\Livewire\Actions\Logout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VerifyEmail extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification() : void {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout) : void {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render() : View {
        return view('livewire.routes.auth.core-user.verify-email');
    }
}
