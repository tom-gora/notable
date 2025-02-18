<?php

namespace App\Notable\Forms;

use App\Helpers\MarkdownProcessor;
use App\Http\Controllers\ImageOptimisationController;
use App\Http\Controllers\ImageToMarkdownController;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddNoteForm extends Component {
    use WithFileUploads;

    protected static string $default_img = '/upload_note.svg';

    #[Rule('required|image|max:50000')]
    public $note_image;

    #[Rule('required|min:3|max:50')]
    public ?string $note_title = null;

    public ?string $note_img_url = null;

    // NOTE: helpers

    public function goBack() : void {
        $this->dispatch('form-go-back');
    }

    public function getDefaultImage() : string {
        return static::$default_img;
    }

    /**
     * @param  string  $image
     */
    private function imageToBase64($image) : string {
      return  base64_encode(file_get_contents($image));
    }

    #[On('tmp-cleanup')]
    public function tmpCleanup() : void {
        /* do not leave to livewire to periodically clean tmp files daily and keep it clogged.
        just Call it explicitly. to clean any file older than 5min on crud operations */
        /* yes wasted compute I know, but ok for a toy demo on a vps that I do not want clogged up */
        $lvr_tmp_dir = storage_path() . '/app/private/livewire-tmp';
        if (!File::isDirectory($lvr_tmp_dir)) {
            return;
        }
        $files = File::files($lvr_tmp_dir);

        foreach ($files as $f) {
            $touched = Carbon::createFromTimestamp(File::lastModified($f));

            $diffTime = now()->diffInMinutes($touched);

            if ($diffTime < -5) {
                File::delete($f);
            }
        }
    }

    // NOTE: make use of controllers
    private function processNote() : mixed {
        // handle trigger with empty file input
        if ($this->note_image == null) {
            $this->addError('image_error', 'Select image first.');

            return null;
        }
        $validated_title = $this->validateOnly('note_title');
        $validated_img = $this->validateOnly('note_image');

        // instantiate controller for image optimisation
        $optimiezer = new ImageOptimisationController;
        $optimized_img = $optimiezer->resize($validated_img['note_image']->getRealPath(), $validated_img['note_image']->getFilename());

        if ($optimized_img == null) {
            $this->addError('image_error', 'Oops, something went wrong with the image optimisation.');
            $this->dispatch('image_error');
            $this->tmpCleanup();

            return null;
        }

        // instantiate controller for calling api
        $transcriber = new ImageToMarkdownController;
        $b64 = $this->imageToBase64($optimized_img);

        $response_text = $transcriber->noteToText($b64);
        if ($response_text === null) {
            $this->addError('image_error', "Oops, Google couldn't decode the image at the moment.");
            $this->dispatch('image_error');

            return null;
        }
        $abs_strip = storage_path() . '/app/public/';
        $mdp = new MarkdownProcessor;

        $raw = $mdp->stripMdToPlain($response_text);

        $this->tmpCleanup();
        return [
            'img_url' => Storage::url(str_replace($abs_strip, '', $optimized_img)),
            'extracted_data' => $raw,
            'title' => $this->note_title,
            'markdown' => $response_text,
        ];
    }

    public function createNote() : void {
        $note_data = $this->processNote();
        if ($note_data == null) {
            return;
        }

        $note = new Note;
        $note->img_url = $note_data['img_url'];
        $note->extracted_data = $note_data['extracted_data'];
        $note->title = $note_data['title'];
        $note->markdown = $note_data['markdown'];
        $note->user_id = auth()->user()->id;

        $this->tmpCleanup();
        $this->reset();
        $note->save();
        $this->dispatch('note-updated');
    }

    // NOTE: Component lifecycle behaviours

    /**
     * @param  mixed  $stopPropagation
     * @param  mixed  $e
     */
    public function exception($e, $stopPropagation) : void {
        // custom errors on validation fail
        $failed = $e->validator->failed();
        if (!empty($failed) && Arr::has($failed, 'note_title')) {
            $this->addError('title_error', 'Title is required.');
        } elseif (!empty($failed) && Arr::has($failed, 'note_image')) {
            $this->addError('image_error', 'Invalid message format or size too large. ');
            // for js to react appropriately on client side
            $this->dispatch('image_error');
        } else {
            // default
            $this->addError('image_error', $e->getMessage());
        }
        $this->tmpCleanup();
    }

    public function render() : View {
        return view('livewire.forms.add-note-form');
    }
}
