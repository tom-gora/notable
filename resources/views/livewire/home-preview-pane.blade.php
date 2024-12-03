<div id="notable-preview-pane"
    class="grid h-fit w-full place-items-center rounded-xl bg-base-200 px-2 pt-4 pb-8 overflow-hidden">
    @if ($isForm)
        <livewire:add-note-form />
    @elseif ($isPreview)
        <livewire:preview-render :viewed="$this->triggered_id" />
    @elseif ($isEditor)
        <div id="notif-wrapper"><x-mary-alert id="note-saved-alert" icon="o-exclamation-triangle"
                class="alert-success text-text-primary z-50 w-9/12 md:w-4/12 fixed right-4 md:right-16 translate-x-1/2 text-xs top-32 md:bottom-auto md:top-24 alert-slide-out-short">
                The note was saved successfully.
            </x-mary-alert></div>
        <livewire:editor :edited_id="$triggered_id" />
    @else
        <x-mary-button class="btn-primary" wire:click.prevent="showAddNoteForm">Add a note</x-mary-button>
        <x-auth-svg-01 />
    @endif

</div>
