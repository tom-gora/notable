<div class="bg-base-200 grid h-fit w-full place-items-center overflow-hidden rounded-xl px-2 pb-8 pt-4"
    id="notable-preview-pane">
    @if ($isForm)
        <livewire:forms.add-note-form />
    @elseif ($isPreview)
        <livewire:core.preview-render :viewed="$this->triggered_id" />
    @elseif ($isEditor)
        <div id="notif-wrapper"><x-mary-alert
                class="alert-success text-text-primary alert-slide-out-short fixed right-4 top-32 z-50 w-9/12 translate-x-1/2 text-xs md:bottom-auto md:right-16 md:top-24 md:w-4/12"
                icon="o-exclamation-triangle" id="note-saved-alert">
                {{ __('The note was saved successfully.') }}
            </x-mary-alert></div>
        <livewire:core.editor :edited_id="$triggered_id" />
    @else
        <x-mary-button class="btn-primary" wire:click.prevent="showAddNoteForm">{{ __('Add a new note') }}</x-mary-button>
        <x-svgs.auth-svg-01 />
    @endif

</div>