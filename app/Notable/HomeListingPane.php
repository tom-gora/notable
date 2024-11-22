<?php

namespace App\Notable;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Note;
use Livewire\Attributes\On;

class HomeListingPane extends Component {
    #[On("note-updated")]
    public function recomputeAfterChange() {
        unset($this->post);
    }

    #[Computed]
    private function notes() : null|Collection {
        $n = Note::all()->where("user_id", auth()->user()->id);
        if ($n->isEmpty()) {
            return null;
        }
        return $n;
    }


    public function render() : View {
        return view('livewire.home-listing-pane');
    }
}
