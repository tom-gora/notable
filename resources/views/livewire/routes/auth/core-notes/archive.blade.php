@use(App\Helpers\UI)
<div class="bg-base-100 mx-auto flex w-11/12 max-w-4xl flex-col gap-4 p-8">
    <livewire:forms.delete-modal />
    <h1 class="py-8 text-center">Your Archived Notes</h1>
    @foreach ($this->notes as $note)
        <div class="archive-item-wrapper flex w-full">
            <div
                class="archive-item-icon bg-base-300 text-info flex flex-col items-center justify-center rounded-l-md px-4 py-2">
                <x-mary-icon class="w-8" name="o-calendar" />
                <span class="text-xs">{{ $note->created_at->isoFormat('D MMM YY') }}</span>
                <span class="text-xs">{{ $note->created_at->isoFormat('HH:mm') }}</span>
            </div>
            <x-mary-list-item :item="$note" class="bg-base-300 min-w-4xl rounded-r-md px-4 py-2" no-hover
                no-separator>
                <x-slot:value>
                    {{ $note->title }}
                </x-slot:value>
                <x-slot:sub-value class="text-text-subtle">
                    {{ UI::textTruncToWord($note->extracted_data, 10) }}
                </x-slot:sub-value>

                <p>Created at: {{ $note->created_at->isoFormat('D MMM YY HH:mm') }}</p>
                <x-slot:actions class="border-base-100 border-l pl-4">
                    <x-mary-button class="accordion-btn-archive" key="unarchiveBtn_{{ $note->id }}"
                        tooltip="Return from Archive" wire:click.prevent="unarchiveNote({{ $note->id }})">
                        <span class="solar--archive-up-line-duotone iconify"
                            key="archive_icon_{{ $note->id }}"></span></x-mary-button>
                    <x-mary-button class="accordion-btn-delete" key="delBtn_{{ $note->id }}" tooltip="Delete"
                        wire:click="$dispatch('request-del-modal', {id: '{{ $note->id }}', title: '{{ $note->title }}'})">
                        <span class="solar--notification-lines-remove-line-duotone iconify"
                            key="del_icon_{{ $note->id }}"></span></x-mary-button>
                </x-slot:actions>
            </x-mary-list-item>
        </div>
    @endforeach
</div>
