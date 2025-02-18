    <div class="max-w-8/12 relative flex h-full flex-col items-center justify-center pt-4 md:max-w-full">
        <div class="absolute z-50 -m-4 h-[110%] w-[110%] bg-none backdrop-blur-[2px]" wire:loading>
            <x-mary-loading
                class="text-info loading-lg loading-spinner absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" />
        </div>
        <x-mary-header :title="__('Click to upload an image or a scan of a note:')"
            class="border-b-text-subtle flex justify-center border-b pb-4 [&>div]:block [&>div]:w-fit [&>div]:px-4"
            size="text-sm" />
        <x-mary-form class="flex h-full w-10/12 flex-col items-center justify-center" id="image-uploader"
            wire:submit.prevent="processNote">
            <x-mary-file :change-text="__('Select image')" :crop-save-text="__('OK')" :crop-title-text="__('Crop the image')"
                accept="image/png, image/jpeg, image/jpg, image/webp"
                class="m-2 flex flex-col items-center justify-center" crop-after-change error-class="form-error-custom"
                error-field="image_error" wire:model="note_image">
                <img class="w-40 rounded-lg" id="note-img-preview"
                    src="{{ $note_img_url ?? $this->getDefaultImage() }}" />
            </x-mary-file>
            <x-mary-input :label="__('Note title...')" class="base-input w-[60vw] md:w-min" clearable
                error-class="form-error-custom" error-field="title_error" inline maxlength="50" minlength="3"
                wire:model="note_title" />
            <div class="border-t-text-subtle flex w-full justify-center gap-8 border-t pt-4">
                <x-mary-button :label="__('Save Note')" class="btn-secondary" spinner="createNote" type="submit"
                    wire:click.prevent="createNote" />
                <x-mary-button :label="__('Go Back')" class="btn-primary" wire:click.prevent="goBack" />
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
