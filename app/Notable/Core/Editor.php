<?php

namespace App\Notable\Core;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Editor extends Component {
    public ?int $edited_id;

    public string $markdown = '';

    public string $title = '';

    protected array $mde_config = [
        'spellchecker' => true,
        'toolbar' => [
            'undo',
            'redo',
            '|',
            'heading-1',
            'heading-2',
            'heading-3',
            '|',
            'bold',
            'italic',
            'strikethrough',
            'quote',
            '|',
            'unordered-list',
            'ordered-list',
            '|',
            'preview'],
        'maxheight' => '200px',
        'autofocus' => true,
        'uploadImage' => false,
        'sideBySideFullscreen' => true,
    ];

    public function getMdeConfig() : array {
        return $this->mde_config;
    }

    /**
     * @param  mixed  $note_id
     */
    #[On('edit-note')]
    public function setNoteId($note_id) : void {
        $this->edited_id = $note_id;
        $this->initNote();
    }

    public function initNote() : void {
        $n = auth()->user()->notes()->find($this->edited_id);
        $this->markdown = $n->markdown;
        $this->title = $n->title;
    }

    public function save(bool $withAlert) : void {
        $n = auth()->user()->notes()->find($this->edited_id);
        if (!$n) {
            return;
        }
        $n->markdown = $this->markdown;
        $success = $n->save();
        if (!$success) {
            return;
        }
        $this->dispatch('note-saved', showAlert: $withAlert);
    }

    public function closeEditor() : void {
        $this->dispatch('close-editor');
    }

    public function render() : View {
        $this->initNote();
        return view('livewire.core.editor');
    }
}
