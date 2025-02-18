@use(App\Helpers\UI)
<div class="mx-auto flex h-fit w-11/12 flex-col gap-4 p-8 md:w-9/12" id="fav-wrapper">
    <livewire:forms.delete-modal />
    <h1 class="py-8 text-center">Your Favourites List</h1>
    <div class="columns-xs overflow-visible">
        @foreach ($this->notes as $note)
            <x-mary-card class="bg-base-200 mb-4 break-inside-avoid" key="fav_card_{{ $note->id }}" shadow
                title="{{ $note->title }}">
                <x-slot:menu>
                    <x-mary-button :wire:click.prevent="'toggleFavourite(' . $note->id . ')'"
                        class="accordion-btn-fav z-50 flex items-start" key="favBtn_{{ $note->id }}"
                        tooltip="{{ $note->is_favourite ? 'Remove' : 'Add' }}">
                        <div
                            class="{{ $note->is_favourite ? 'solar--star-bold text-warning' : 'solar--star-outline text-subtle' }} iconify z-40 flex w-8 justify-start text-xl">
                        </div>
                    </x-mary-button>
                </x-slot:menu>
                <p class="text-text-subtle px-2 py-4 text-justify text-sm">
                    {{ UI::textTruncToWord($note->extracted_data, 50) }}
                </p>
                <x-slot:actions class="flex w-full">
                    <x-mary-button class="accordion-btn" key="editBtn_{{ $note->id }}" tooltip="Edit"
                        wire:click.prevent="editNote({{ $note->id }})">
                        <span class="solar--pen-new-square-line-duotone iconify"
                            key="edit_icon_{{ $note->id }}"></span></x-mary-button>

                    <x-mary-button class="accordion-btn" key="archiveBtn_{{ $note->id }}" tooltip="Archive"
                        wire:click.prevent="archiveNote({{ $note->id }})">
                        <span class="solar--archive-down-line-duotone iconify"
                            key="archive_icon_{{ $note->id }}"></span></x-mary-button>

                    <x-mary-button class="accordion-btn-view" key="viewBtn_{{ $note->id }}" tooltip="View"
                        wire:click.prevent="viewNote({{ $note->id }})">
                        <span class="solar--document-text-line-duotone iconify"
                            key="view_icon_{{ $note->id }}"></span></x-mary-button>

                    <x-mary-button class="accordion-btn-delete" key="delBtn_{{ $note->id }}" tooltip="Delete"
                        wire:click="$dispatch('request-del-modal', {id: '{{ $note->id }}', title: '{{ $note->title }}'})">
                        <span class="solar--notification-lines-remove-line-duotone iconify"
                            key="del_icon_{{ $note->id }}"></span></x-mary-button>

                </x-slot:actions>
            </x-mary-card>
        @endforeach
    </div>
</div>
