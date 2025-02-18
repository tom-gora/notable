<?php

namespace App\Notable\Forms;

use App\Helpers\BackgroundTaskRunner;
use App\Notable\Actions\Logout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteUserForm extends Component {
    public string $password = '';

    public bool $show_modal = false;

    public function dispatchModal() : void {
        $this->dispatch('open-modal', 'confirm-user-deletion');
    }

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout) : void {
        $BTR = new BackgroundTaskRunner;
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $notes = Auth::user()->notes()->get();

        if ($notes) {
            foreach ($notes as $n) {
                $BTR->imageCleanupHook($n);
            }
        }

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    public function render() : View {
        return view('livewire.forms.delete-user-form');
    }
}
