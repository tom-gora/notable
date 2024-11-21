<?php

namespace App\Notable;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class HomePreviewPane extends Component {
    public bool $isForm = false;
    public bool $isEditor = false;
    public bool $isPreview = false;

    public bool $notify = false;

    public string $test_string = 'test';
    public ?int $triggered_id = null;

    public function showAddNoteForm() : void {
        $this->isForm = true;
    }
    /**
     * @param int $note_id
     */
    #[On("edit-note")]
    public function showNoteEditor($note_id) : void {
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = true;
        $this->triggered_id = $note_id;
    }

    #[On("toggle-preview")]
    public function showPreviewPane() : void {
        $this->isForm = false;
        $this->isEditor = false;
        $this->isPreview = true;
    }

    #[On("form-go-back")]
    public function goBack() : void {
        $this->isEditor = false;
        $this->isPreview = false;
        $this->isForm = false;
    }

    #[On("close-editor")]
    public function noteUpdated() : void {
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = false;
    }

    #[On("close-preview")]
    public function closePreview() : void {
        $this->isPreview = false;
        $this->isForm = false;
        $this->isEditor = false;
    }

    public function render() : View {
        return view('livewire.home-preview-pane');
    }
}
