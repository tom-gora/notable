<?php

namespace App\Notable\Core;

use App\Models\Note;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('toggle-preview')]
class PreviewRender extends Component {
    public bool $isSnapshot = false;

    public int $viewed;

    public function toggleSnapshot() : void {
        $this->isSnapshot = !$this->isSnapshot;
    }

    /**
     * @param  mixed  $note_id
     */
    #[On('toggle-preview')]
    public function updateViewed($note_id) : void {
        $this->viewed = $note_id;
    }

    /**
     * @return array<string,mixed>
     */
    #[Computed]
    public function data() : array {
        $n = Note::find($this->viewed);
        return [
            'html' => Str::of($n->markdown)->markdown(),
            'title' => $n->title,
            'snapshot' => $n->img_url,
        ];
    }

    public function closePreview() : void {
        $this->dispatch('close-preview');
    }

    public function render() : View {
        return view('livewire.core.preview-render');
    }
}
