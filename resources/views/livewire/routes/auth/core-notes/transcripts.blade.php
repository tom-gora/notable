<div class="mx-auto flex h-fit w-11/12 flex-col gap-4 p-8 md:w-9/12">
    <livewire:forms.delete-modal />
    <h1 class="py-8 text-center">Your Note Transcripts</h1>
    <div class="columns-lg overflow-visible">
        @foreach ($this->notes as $note)
            <x-mary-card class="bg-base-200 mb-4 break-inside-avoid" key="fav_card_{{ $note->id }}" shadow
                title="{{ $note->title }}">
                <div class="text-text-subtle prose list-disc px-2 py-4">
                    {!! $note->html_content !!}
                </div>
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
