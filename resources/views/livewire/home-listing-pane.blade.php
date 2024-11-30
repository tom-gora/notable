@use(Illuminate\Support\Str)
<div id="notable-listing-pane"
    class="relative h-fit w-full md:w-2/3 rounded-xl bg-base-200 p-4 overflow-hidden transition-all duration-150">
    {{-- notes list accordion --}}
    @if ($notes === null)
        <x-no-notes />
    @else
        <div wire:loading class="z-50 absolute w-[110%] h-[110%] bg-none backdrop-blur-[2px] -m-4">
            <x-mary-loading
                class="text-info absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 loading-lg loading-spinner" />
        </div>
        <div class="w-full pb-4"><x-mary-input icon="o-funnel" class="base-input" label="Search your notes"
                wire:model.live.debounce.500ms="filter" inline />
        </div>
        <div id="notes-accordion-wrapper" class="max-h-[60vh] overflow-scroll scroll-smooth">
            <x-mary-accordion wire:model="group">
                @foreach ($notes as $note)
                    <x-mary-collapse :name="'group_' . $note->id" :open="$group === 'group_' . $note->id" :wire:key="'group_' . $note->id"
                        class="border-0 odd:bg-base-300">
                        <x-slot:heading :wire:click="'toggle(' . $note->id . ')'" key="heading_{{ $note->id }}"
                            class="flex gap-2 items-center">
                            <div key="heading_wrapper_{{ $note->id }}"
                                class="flex flex-col md:flex-row justify-around grow">
                                <div key="title_{{ $note->id }}" class="grow text-lg">{{ $note->title }}</div>
                                <div key="buttons_wrapper_{{ $note->id }}" class="flex gap-2 w-fit pt-2 md:pt-0">
                                    <button key="viewBtn_{{ $note->id }}"
                                        wire:click.prevent="viewNote({{ $note->id }})"
                                        class="z-10 justify-self-end !bg-transparent !outline-0 !border-0 focus:!ring-0 group">
                                        <span key="view_icon_{{ $note->id }}"
                                            class="solar--eye-scan-line-duotone text-surface iconify text-2xl group-focus-visible:text-surface-strong group-focus:text-surface-strong group-hover:text-surface-strong group-focus-visible:scale-[1.1] group-hover:scale-[1.1] origin-center"></span></button>
                                    <button key="editBtn_{{ $note->id }}"
                                        wire:click.prevent="editNote({{ $note->id }})"
                                        class="z-10 justify-self-end !bg-transparent !outline-0 !border-0 focus:!ring-0 group">
                                        <span key="edit_icon_{{ $note->id }}"
                                            class="solar--pen-new-square-line-duotone text-accent-secondary-focus iconify text-2xl group-focus-visible:text-info group-focus:text-info group-hover:text-info group-focus-visible:scale-[1.1] group-hover:scale-[1.1] origin-center"></span></button>
                                    <button key="delBtn_{{ $note->id }}"
                                        wire:click.prevent="deleteNote({{ $note->id }})"
                                        class="z-10 justify-self-end !bg-transparent !outline-0 !border-0 focus:!ring-0 group">
                                        <span key="del_icon_{{ $note->id }}"
                                            class="solar--notification-lines-remove-line-duotone text-accent-primary iconify text-2xl group-focus-visible:text-error group-focus:text-error group-hover:text-error group-focus-visible:scale-[1.1] group-hover:scale-[1.1] origin-center"></span></button>
                                </div>
                            </div>
                        </x-slot:heading>
                        <x-slot:content key="content_{{ $note->id }}">
                            <div key="img_preview_{{ $note->id }}"
                                class="my-2 h-40 w-full bg-cover bg-top bg-no-repeat"
                                style="background-image: url('{{ $note['img_url'] }}')">
                            </div>
                            <span key="trunc_txt_span_{{ $note->id }}">
                                <p key="title_txt_{{ $note->id }}" class="font-bold">Content preview: </p>
                                <p key="trunc_txt_{{ $note->id }}" class="text-sm text-text-subtle">
                                    {{ Str::limit($note['extracted_data'], 200, '...') }}
                                </p>
                            </span>
                        </x-slot:content>
                    </x-mary-collapse>
                @endforeach
            </x-mary-accordion>
        </div>
        @if ($filter === '')
            <div class="pt-4 px-8" id="notes-pagination">{{ $notes->links() }}</div>
        @endif
    @endif
</div>
