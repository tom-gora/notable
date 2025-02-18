@use(App\Helpers\UI)
<div class="{{ $this->edited === null ? 'h-fit w-full p-4' : '!h-0 !w-0 !p-0' }} bg-base-200 relative h-fit overflow-hidden rounded-xl transition-all duration-200 md:w-2/3"
    id="notable-listing-pane">

    <livewire:forms.delete-modal />
    {{-- notes list accordion --}}
    @if ($this->notes === null)
        <x-no-notes />
    @else
        <div class="w-full pb-4">
            <x-mary-input :label="__('Search your notes')" class="base-input" icon="o-funnel" inline
                wire:model.live.debounce.500ms="filter" />
        </div>
        <div class="max-h-[60vh] overflow-scroll scroll-smooth" id="notes-accordion-wrapper">
            <x-mary-accordion wire:model="group">
                @foreach ($this->notes as $note)
                    <x-mary-collapse :name="'group_' . $note->id" :open="$group === 'group_' . $note->id" :wire:key="'group_' . $note->id"
                        class="odd:bg-base-300 border-0 !pt-4">
                        <x-slot:heading :wire:click.prevent="'toggle(' . $note->id . ')'"
                            class="flex items-center gap-2 !pb-0 !pt-2" key="heading_{{ $note->id }}">
                            <x-mary-button :wire:click.prevent="'toggleFavourite(' . $note->id . ')'"
                                class="accordion-btn-fav z-50 -translate-y-1 md:translate-y-0"
                                key="favBtn_{{ $note->id }}" tooltip="{{ $note->is_favourite ? 'Remove' : 'Add' }}">
                                <div
                                    class="{{ $note->is_favourite ? 'solar--star-bold text-warning' : 'solar--star-outline text-subtle' }} iconify text-md z-40 -mt-5 flex w-5 justify-start">
                                </div>
                            </x-mary-button>
                            <div class="flex grow flex-row justify-between" key="heading_wrapper_{{ $note->id }}">
                                <div class="min-w-0 shrink overflow-clip overflow-ellipsis text-nowrap text-lg"
                                    key="title_{{ $note->id }}">
                                    {{ UI::textTruncToWord($note->title, 4) }}</div>
                                <div class="items-top z-10 flex w-fit -translate-y-4 pt-2 md:ms-auto md:-translate-y-2 md:pt-0"
                                    key="core_actions_wrapper_{{ $note->id }}">
                                    <x-mary-button
                                        class="{{ $this->viewed === $note->id ? 'accordion-btn-inactive' : 'accordion-btn-view' }}"
                                        key="viewBtn_{{ $note->id }}" tooltip="View"
                                        wire:attributes="{ 'disabled': '{{ $this->viewed === $note->id ? 'disabled' : '' }}' }"
                                        wire:click.prevent="viewNote({{ $note->id }})">

                                        <span class="solar--document-text-line-duotone iconify"
                                            key="view_icon_{{ $note->id }}"></span></x-mary-button>

                                </div>
                                <p class="collapse-hint text-text-subtle mt-2 hidden w-10 translate-x-2 pl-2 text-xs md:block"
                                    key="hint_{{ $note->id }}">
                                    More</p>
                            </div>
                        </x-slot:heading>
                        <x-slot:content class="-mt-2 flex items-center justify-between !pb-2"
                            key="content_{{ $note->id }}">
                            <p class="text-accent-secondary text-xs"><span
                                    class="text-accent-secondary-focus font-bold">Created
                                    at:</span>
                                {{ $note->created_at->isoFormat('D MMM YY HH:mm') }}</p>
                            <div class="-mr-2 flex">
                                <x-mary-button class="accordion-btn-edit"
                                    class="{{ $this->edited === $note->id ? 'accordion-btn-inactive' : 'accordion-btn-edit' }}"
                                    key="editBtn_{{ $note->id }}" tooltip="Edit"
                                    wire:attributes="{ 'disabled': '{{ $this->viewed === $note->id ? 'disabled' : '' }}' }"
                                    wire:click.prevent="editNote({{ $note->id }})">
                                    <span class="solar--pen-new-square-line-duotone iconify"
                                        key="edit_icon_{{ $note->id }}"></span></x-mary-button>

                                <x-mary-button class="accordion-btn-archive" key="archiveBtn_{{ $note->id }}"
                                    tooltip="Archive" wire:click.prevent="archiveNote({{ $note->id }})">
                                    <span class="solar--archive-down-line-duotone iconify"
                                        key="archive_icon_{{ $note->id }}"></span></x-mary-button>

                                <x-mary-button class="accordion-btn-delete" key="delBtn_{{ $note->id }}"
                                    tooltip="Delete"
                                    wire:click="$dispatch('request-del-modal', {id: '{{ $note->id }}', title: '{{ $note->title }}'})">
                                    {{-- wire:click.prevent="deleteNote({{ $note->id }})"> --}}
                                    <span class="solar--notification-lines-remove-line-duotone iconify"
                                        key="del_icon_{{ $note->id }}"></span></x-mary-button>
                            </div>
                        </x-slot:content>
                    </x-mary-collapse>
                @endforeach
            </x-mary-accordion>
        </div>
        @if ($filter === '')
            <div class="px-8 pt-4" id="notes-pagination">{{ $this->notes->links() }}</div>
        @endif
    @endif
</div>
