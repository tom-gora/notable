@use(Illuminate\Support\Str)
<div id="notable-listing-pane"
    class="relative h-fit w-full md:w-2/3 rounded-xl bg-base-200 p-4 overflow-hidden transition-all duration-150">
    {{-- notes list accordion --}}
    @if ($this->notes === null)
        <x-no-notes />
    @else
        {{-- <div wire:loading class="z-50 absolute w-[110%] h-[110%] bg-none backdrop-blur-[2px] -m-4">
            <x-mary-loading
                class="text-info absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 loading-lg loading-spinner" />
        </div> --}}
        <div class="w-full pb-4"><x-mary-input icon="o-funnel" class="base-input" label="Search your notes"
                wire:model.live.debounce.500ms="filter" inline />
        </div>
        <div id="notes-accordion-wrapper" class="max-h-[60vh] overflow-scroll scroll-smooth">
            <x-mary-accordion wire:model="group">
                @foreach ($this->notes as $note)
                    <x-mary-collapse :name="'group_' . $note->id" :open="$group === 'group_' . $note->id" :wire:key="'group_' . $note->id"
                        class="border-0 odd:bg-base-300 !pt-4">
                        <x-slot:heading :wire:click="'toggle(' . $note->id . ')'" key="heading_{{ $note->id }}"
                            class="flex gap-2 items-center !pb-0 !pt-2">
                            <div key="heading_wrapper_{{ $note->id }}"
                                class="flex flex-col md:flex-row justify-around grow">
                                <div key="title_{{ $note->id }}" class="grow text-lg">{{ $note->title }}</div>
                                <div key="core_actions_wrapper_{{ $note->id }}"
                                    class="flex items-top gap-2 w-fit pt-2 md:pt-0 -translate-y-2">
                                    <x-mary-button tooltip="View" key="viewBtn_{{ $note->id }}"
                                        wire:click.prevent="viewNote({{ $note->id }})" class="accordion-btn-view">
                                        <span key="view_icon_{{ $note->id }}"
                                            class="solar--eye-scan-line-duotone iconify "></span></x-mary-button>
                                    <x-mary-button tooltip="Delete" key="delBtn_{{ $note->id }}"
                                        wire:click.prevent="deleteNote({{ $note->id }})"
                                        class="accordion-btn-delete">
                                        <span key="del_icon_{{ $note->id }}"
                                            class="solar--notification-lines-remove-line-duotone iconify"></span></x-mary-button>
                                </div>
                                <p key="hint_{{ $note->id }}"
                                    class="collapse-hint pl-2 translate-x-2 text-xs mt-2 text-text-subtle w-10">
                                    More</p>
                            </div>
                        </x-slot:heading>
                        <x-slot:content key="content_{{ $note->id }}" class="!pb-4 -my-4">
                            <x-mary-button tooltip="Edit" key="editBtn_{{ $note->id }}"
                                wire:click.prevent="editNote({{ $note->id }})" class="accordion-btn-edit">
                                <span key="edit_icon_{{ $note->id }}"
                                    class="solar--pen-new-square-line-duotone iconify "></span></x-mary-button>
                        </x-slot:content>
                    </x-mary-collapse>
                @endforeach
            </x-mary-accordion>
        </div>
        @if ($filter === '')
            <div class="pt-4 px-8" id="notes-pagination">{{ $this->notes->links() }}</div>
        @endif
        <script>
            const collapseGroupsRaadios = document.querySelectorAll('.collapse input[type="radio"]');
            collapseGroupsRaadios.forEach(radio => {
                const siblingHint = radio.parentElement.querySelector('.collapse-hint');
                radio.addEventListener('change', function() {
                    this.checked ? siblingHint.innerText = 'Less' : siblingHint.innerText = 'More';
                });
            });
        </script>
    @endif
</div>
