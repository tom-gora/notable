<?php

namespace App\Notable;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

#[On("toggle-preview")]
class PreviewRender extends Component {
    public function closePreview() : void {
        $this->dispatch('close-preview');
    }
    public function render() : View {
        return view('livewire.preview-render');
    }
}
