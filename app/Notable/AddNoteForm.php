<?php

namespace App\Notable;

use App\Http\Controllers\ImageToMarkdownController;
use App\Models\Note;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Controllers\ImageOptimisationController;

class AddNoteForm extends Component {
    use WithFileUploads;

    protected static string $default_img = '/upload_note.svg';

    #[Rule('required|image|max:50000')]
    public $note_image;

    #[Rule('required|min:3|max:50')]
    public string|null $note_title = null;

    public string|null $note_img_url = null;

    // NOTE: helpers


    public function goBack() : void {
        $this->dispatch('form-go-back');
    }

    public function getDefaultImage() : string {
        return static::$default_img;
    }
    /**
     * @param string $image
     */
    private function imageToBase64($image) : string {
        return base64_encode(file_get_contents($image));
    }

    #[On("tmp-cleanup")]
    public function tmpCleanup() : void {
        if (!$this->note_img_url) {
            return;
        }
        $tmp = storage_path() . "/app/public/tmp/";
        $extreme_wipeout = Storage::allFiles($tmp);
        Storage::delete($extreme_wipeout);
    }

    // NOTE: make use of controller
    private function processNote() : mixed {

        // handle trigger with empty file input
        if ($this->note_image == null) {
            $this->addError('image_error', "Select image first.");
            return null;
        }
        $validated_title = $this->validateOnly("note_title");
        $validated_img = $this->validateOnly("note_image");

        // instantiate controller for image optimisation
        $optimiezer = new ImageOptimisationController();
        $optimized_img = $optimiezer->resize($validated_img["note_image"]->getRealPath(), $validated_img["note_image"]->getFilename());

        if ($optimized_img == null) {
            $this->addError('image_error', "Oops, something went wrong with the image optimisation.");
            $this->dispatch('image_error');
            $this->tmpCleanup();
            return null;
        }
        $this->tmpCleanup();

        // instantiate controller for calling api
        $transcriber = new ImageToMarkdownController();
        /*dd("have we got here?");*/
        $b64 = $this->imageToBase64($optimized_img);

        $response_text = $transcriber->noteToText($b64);
        if ($response_text === null) {
            $this->addError('image_error', "Oops, Google couldn't decode the image at the moment.");
            $this->dispatch('image_error');
            return null;
        }
        $abs_strip = storage_path() . "/app/public/";
        return [
            "img_url" => Storage::url(str_replace($abs_strip, "", $optimized_img)),
            "extracted_data" => $response_text,
            "title" => $this->note_title,
        ];
    }

    public function createNote() : void {
        $note_data = $this->processNote();
        if ($note_data == null) {
            return;
        }

        $note = new Note();
        $note->img_url = $note_data["img_url"];
        $note->extracted_data = $note_data["extracted_data"];
        $note->title = $note_data["title"];
        $note->markdown = $note_data["extracted_data"];
        $note->user_id = auth()->user()->id;

        $this->tmpCleanup();
        $this->reset();
        $note->save();
        sleep(1);
        $this->dispatch("note-updated");
    }



    //NOTE: Component lifecycle behaviours

    /**
     * @param mixed $stopPropagation
     * @param mixed $e
     */
    public function exception($e, $stopPropagation) : void {
        // custom errors on validation fail
        $failed = $e->validator->failed();
        if (!empty($failed) && Arr::has($failed, "note_title")) {
            $this->addError('title_error', "Title is required.");
        } elseif (!empty($failed) && Arr::has($failed, "note_image")) {
            $this->addError('image_error', "Invalid message format or size too large. ");
            // for js to react appropriately on client side
            $this->dispatch('image_error');
        }
        $this->tmpCleanup();
    }

    public function render() : View {
        return view('livewire.add-note-form');
    }

}
