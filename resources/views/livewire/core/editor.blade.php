<div class="relative flex flex-col items-center gap-4 overflow-scroll scroll-smooth px-0 pb-4 md:max-h-[75vh] md:px-36">
    <div id="notif-wrapper"><x-mary-alert
            class="alert-success text-text-primary absolute right-4 top-32 z-50 hidden w-9/12 translate-x-1/2 text-xs md:bottom-auto md:right-16 md:top-24 md:w-4/12"
            icon="o-exclamation-triangle" id="note-saved-alert">
            {{ __('The note was saved successfully.') }}
        </x-mary-alert></div>

    <div class="sticky right-0 top-8 z-50 ms-auto flex w-fit translate-x-32 flex-col gap-4 px-8">
        <x-mary-button :label="__('Save')" class="btn-secondary w-full" id="save-btn" spinner="save"
            wire:click="save(true)" />
        <x-mary-button :label="__('Close')" class="btn-primary w-full" spinner="closeEditor" wire:click="closeEditor" />
    </div>
    <div class="flex w-full -translate-y-24 flex-col items-center gap-4" id="editor-wrapper">
        <x-mary-markdown :config="$this->getMdeConfig()" label='"{!! $title !!}"' wire:model="markdown" />
    </div>
</div>
