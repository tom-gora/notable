<div class="{{ $this->edited === null ? 'h-fit w-full p-4' : '!h-0 !w-0 !p-0' }} bg-base-200 relative h-fit overflow-hidden rounded-xl transition-all duration-150 md:w-2/3"
    id="notable-listing-pane">
    {{-- notes list accordion --}}
    @if ($notes === null)
        <x-no-notes />
    @else
        <div class="w-full pb-4">
            <x-mary-input :label="__('Search your notes')" class="base-input" icon="o-funnel" inline
                wire:model.live.debounce.500ms="filter" />
        </div>
        <div class="max-h-[60vh] overflow-scroll scroll-smooth" id="notes-accordion-wrapper">
            <x-mary-accordion wire:model="group">
                @foreach ($notes as $note)
                    <x-mary-collapse :name="'group_' . $note->id" :open="$group === 'group_' . $note->id" :wire:key="'group_' . $note->id"
                        class="odd:bg-base-300 border-0 !pt-4">
                        <x-slot:heading :wire:click.prevent="'toggle(' . $note->id . ')'"
                            class="flex items-center gap-2 !pb-0 !pt-2" key="heading_{{ $note->id }}">
                            <div class="flex grow flex-col justify-between md:flex-row"
                                key="heading_wrapper_{{ $note->id }}">
                                <div class="max-w-[22ch] grow overflow-clip overflow-ellipsis text-nowrap text-lg"
                                    key="title_{{ $note->id }}">
                                    {{ $note->title }}</div>
                                <div class="items-top z-10 ms-auto flex w-fit -translate-y-2 pt-2 md:pt-0"
                                    key="core_actions_wrapper_{{ $note->id }}">
                                    <x-mary-button
                                        class="{{ $this->viewed === $note->id ? 'accordion-btn-inactive' : 'accordion-btn-view' }}"
                                        key="viewBtn_{{ $note->id }}" tooltip="View"
                                        wire:attributes="{ 'disabled': '{{ $this->viewed === $note->id ? 'disabled' : '' }}' }"
                                        wire:click.prevent="viewNote({{ $note->id }})">

                                        <span class="solar--document-text-line-duotone iconify"
                                            key="view_icon_{{ $note->id }}"></span></x-mary-button>

                                    <x-mary-button class="accordion-btn-delete" key="delBtn_{{ $note->id }}"
                                        tooltip="Delete" wire:click.prevent="deleteNote({{ $note->id }})">
                                        <span class="solar--notification-lines-remove-line-duotone iconify"
                                            key="del_icon_{{ $note->id }}"></span></x-mary-button>

                                </div>
                                <p class="collapse-hint text-text-subtle mt-2 w-10 translate-x-2 pl-2 text-xs"
                                    key="hint_{{ $note->id }}">
                                    More</p>
                            </div>
                        </x-slot:heading>
                        <x-slot:content class="-mt-2 !pb-0" key="content_{{ $note->id }}">
                            <x-mary-button class="accordion-btn-edit"
                                class="{{ $this->edited === $note->id ? 'accordion-btn-inactive' : 'accordion-btn-edit' }}"
                                key="editBtn_{{ $note->id }}" tooltip="Edit"
                                wire:attributes="{ 'disabled': '{{ $this->viewed === $note->id ? 'disabled' : '' }}' }"
                                wire:click.prevent="editNote({{ $note->id }})">
                                <span class="solar--pen-new-square-line-duotone iconify"
                                    key="edit_icon_{{ $note->id }}"></span></x-mary-button>

                            <x-mary-button class="accordion-btn-fav" key="favBtn_{{ $note->id }}"
                                tooltip="Add to favourites" wire:click.prevent="favNote({{ $note->id }})">
                                <span class="solar--stars-minimalistic-line-duotone iconify"
                                    key="fav_icon_{{ $note->id }}"></span></x-mary-button>

                            <x-mary-button class="accordion-btn-collection" key="collectionBtn_{{ $note->id }}"
                                tooltip="Add to collection" wire:click.prevent="collectionNote({{ $note->id }})">
                                <span class="solar--widget-add-line-duotone iconify"
                                    key="collection_icon_{{ $note->id }}"></span></x-mary-button>

                            <x-mary-button class="accordion-btn-archive" key="archiveBtn_{{ $note->id }}"
                                tooltip="Archive" wire:click.prevent="archiveNote({{ $note->id }})">
                                <span class="solar--archive-down-line-duotone iconify"
                                    key="archive_icon_{{ $note->id }}"></span></x-mary-button>
                        </x-slot:content>
                    </x-mary-collapse>
                @endforeach
            </x-mary-accordion>
        </div>
        @if ($filter === '')
            <div class="px-8 pt-4" id="notes-pagination">{{ $notes->links() }}</div>
        @endif
        <script>
            // TODO: also undo any previously toggled labels back to original state when new one is toggled
            // DONE implementation -> rudimental AF. The mary lib uses ghost radio input to bind state and toggles classes, playing animations
            // but fails to uncheck the radios when next one gets checked. So I need to do the manual work for them.
            // I hate it as it is a horrible nested expression russian doll but it is what it is I guess
            const collapseGroupsRadios = document.querySelectorAll('.collapse input[type="radio"]');
            collapseGroupsRadios.forEach(radio => {
                const siblingHint = radio.parentElement.querySelector('.collapse-hint');
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        collapseGroupsRadios.forEach(otherRadio => {
                            if (otherRadio !== this) {
                                otherRadio.checked = false;
                                const otherHint = otherRadio.parentElement.querySelector(
                                    '.collapse-hint');
                                if (otherHint) {
                                    otherHint.innerText = 'More';
                                }
                            }
                        });
                        siblingHint.innerText = 'Less';
                    } else {
                        siblingHint.innerText = 'More';
                    }
                });
            });
        </script>
    @endif
</div>