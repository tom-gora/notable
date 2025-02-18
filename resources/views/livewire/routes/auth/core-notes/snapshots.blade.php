@use(App\Helpers\UI)
<div class="mx-auto flex h-fit w-11/12 w-fit flex-col gap-4 p-8 md:w-9/12" id="fav-wrapper">
    <livewire:forms.delete-modal />
    <h1 class="py-8 text-center">Your Note Snapshots List</h1>
    <div class="columns-xs overflow-visible">
        @foreach ($this->notes as $note)
            <x-mary-card class="bg-base-200 isolate mb-4 break-inside-avoid" key="fav_card_{{ $note->id }}" shadow>
                <x-slot:figure class="relative z-10 overflow-visible">
                    <div class="bg-base-300 absolute inset-0 z-10 opacity-10"></div>
                    <div class="snapshot-title bg-base-200 absolute -bottom-2 right-4 z-20 rounded-t-md px-4 pt-1">
                        {{ UI::textTruncToWord($note->title, 5) }}</div>
                    <img alt="Image for note {{ $note->title }}" class="h-full w-full rounded-t-md bg-blend-darken"
                        src="{{ $note->img_url }}" />
                </x-slot:figure>
                <x-slot:actions class="-z-10 flex w-full">
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
