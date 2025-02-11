<?php

namespace App\Notable\Forms;

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
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    public function render() : View {
        return view('livewire.forms.delete-user-form');
    }
}
