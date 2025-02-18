<?php

namespace App\Notable\Core;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class HomePreviewPane extends Component {
    public bool $isForm = false;

    public bool $isEditor = false;

    public bool $isPreview = false;

    public bool $notify = false;

    public ?int $triggered_id = null;

    public ?array $hook = null;

    public function showAddNoteForm() : void {
        $this->isForm = true;
        $this->isEditor = false;
        $this->isPreview = false;
    }

    public function mount() : void {
        if ($this->hook !== null && $this->hook['action'] === 'edit') {
            $this->showNoteEditor($this->hook['id']);
        } elseif ($this->hook !== null && $this->hook['action'] === 'view') {
            $this->showPreviewPane($this->hook['id']);
        }
    }

    /**
     * @param  mixed  $note_id
     */
    #[On('edit-note')]
    public function showNoteEditor($note_id) : void {
        $this->notify = false;
        $this->triggered_id = $note_id;
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = true;
    }

    /**
     * @param  mixed  $note_id
     */
    #[On('toggle-preview')]
    public function showPreviewPane($note_id) : void {
        $this->notify = false;
        $this->triggered_id = $note_id;
        $this->isForm = false;
        $this->isEditor = false;
        $this->isPreview = true;
    }

    #[On('form-go-back')]
    public function goBack() : void {
        $this->notify = false;
        $this->isEditor = false;
        $this->isPreview = false;
        $this->isForm = false;
    }

    #[On('close-editor')]
    public function noteUpdated() : void {
        $this->dispatch('editor-closed');
        $this->notify = false;
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = false;
    }

    #[On('close-preview'), On('note-deleted')]
    public function closePreview() : void {
        if ($this->isPreview) {
            $this->dispatch('preview-closed');
        }

        if ($this->isEditor) {
            $this->dispatch('editor-closed');
        }

        $this->notify = false;
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = false;
    }

    public function render() : View {
        return view('livewire.core.home-preview-pane');
    }
}
