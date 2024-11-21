<?php

namespace App\Notable;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteUserForm extends Component {
    public string $password = '';
    public bool $show_modal = false;

    public function dispatchModal() : void {
        $this->dispatch('open-modal', 'confirm-user-deletion');
    }

    public function exception($e, $stopPropagation) : void {
        dd($e);
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

    public function render() {
        return view('livewire.delete-user-form');
    }
}
