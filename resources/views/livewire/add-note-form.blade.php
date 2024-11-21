<div class="max-w-8/12 md:max-w-full h-full relative flex flex-col items-center justify-center">
    <div wire:loading class="z-50 absolute w-[110%] h-[110%] bg-none backdrop-blur-[2px] -m-4">
        <x-mary-loading
            class="text-info absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 loading-lg loading-spinner" />
    </div>
    <x-mary-header size="text-sm" class="forced-text-center forced-text-color !mb-4 border-b border-b-text-subtle"
        title="Click to upload an image or a scan of a note:" />
    <x-mary-form id="image-uploader" wire:submit="processNote"
        class="w-10/12 h-full flex flex-col justify-center items-center">
        <x-mary-file wire:model="note_image" accept="image/png, image/jpeg, image/jpg, image/webp"
            class="flex flex-col items-center justify-center m-2" crop-after-change error-class="form-error-custom"
            error-field="image_error" change-text="Select image" crop-save-text="OK" crop-title-text="Crop the image">
            <img id="note-img-preview" src="{{ $note_img_url ?? $this->getDefaultImage() }}" class="w-40 rounded-lg" />
        </x-mary-file>
        <x-mary-input wire:model="note_title" minlength="3" maxlength="50" label="Note title..." inline clearable
            error-field="title_error" class="w-[60vw] md:w-min base-input" error-class="form-error-custom" />
        <div class="flex gap-8 justify-center w-full border-t-text-subtle border-t pt-4">
            <x-mary-button wire:click.prevent="createNote" class="btn-secondary" label="Save Note" type="submit"
                spinner="createNote" />
            <x-mary-button wire:click="goBack" class="btn-primary" label="Go Back" />
        </div>
    </x-mary-form>
</div>
@script
    <script>
        const cropDialog = document.querySelector("dialog[x-ref='maryCrop']");
        const cropDialogCancelBtn = cropDialog.querySelector("button:first-of-type");
        const imgPreview = document.querySelector("#note-img-preview");
        $wire.on('image_error', () => {
            cropDialog.close();
            imgPreview.setAttribute("src", "/upload_note.svg")
        });

        $wire.on('note-updated', () => {
            imgPreview.setAttribute("src", "/upload_note.svg")
        });

        // if cropping cancelled, clean up
        cropDialogCancelBtn.addEventListener("click", () => {
            $wire.dispatch("tmp-cleanup");
        });
    </script>
@endscript
