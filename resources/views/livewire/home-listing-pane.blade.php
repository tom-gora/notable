@use(Illuminate\Support\Str)
<div id="notable-listing-pane"
    class="relative h-fit w-full rounded-xl bg-base-200 p-4 overflow-hidden transition-all duration-150">
    {{-- notes list accordion --}}
    @if ($this->notes === null)
        <x-no-notes />
    @else
        <div wire:loading class="z-50 absolute w-[110%] h-[110%] bg-none backdrop-blur-[2px] -m-4">
            <x-mary-loading
                class="text-info absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 loading-lg loading-spinner" />
        </div>
        <div id="notes-accordion-wrapper" class="max-h-[60vh] overflow-scroll scroll-smooth">
            <x-mary-accordion>
                @foreach ($this->notes as $note)
                    <x-mary-collapse wire:key="{{ 'note_' . $note->id }}" name="{{ 'note_' . $note->id }}"
                        class="border-0 odd:bg-base-300">
                        <x-slot:heading class="flex flex-col gap-2 md:flex-row items-center">
                            <div class="w-max grow">{{ $note['title'] }}</div>
                            <div class="flex md:w-min gap-4 justify-end w-full">
                                <livewire:accordion-button :key="'view_btn_' . $note->id" :method="'viewNote(' . $note->id . ')'"
                                    icon="solar--eye-scan-line-duotone" base_clr_class="text-neural"
                                    focus_clr_class="text-surface-strong" />
                                <livewire:accordion-button :key="'edit_btn_' . $note->id" :method="'editNote(' . $note->id . ')'"
                                    icon="solar--pen-new-square-line-duotone"
                                    base_clr_class="text-accent-secondary-focus" focus_clr_class="text-info" />
                                <livewire:accordion-button :key="'delete_btn_' . $note->id" :method="'deleteNote(' . $note->id . ')'"
                                    icon="solar--notification-lines-remove-line-duotone"
                                    base_clr_class="text-accent-primary" focus_clr_class="text-error" />
                            </div>
                        </x-slot:heading>
                        <x-slot:content>
                            <div class="my-2 h-40 w-full bg-cover bg-top bg-no-repeat"
                                style="background-image: url('{{ $note['img_url'] }}')">
                            </div>
                            <div class="prose">
                                <span>
                                    <p class="font-bold">Raw markdown preview: </p>
                                    <p class="text-sm text-text-subtle">{{ Str::limit($note['markdown'], 100, '...') }}
                                    </p>
                                </span>
                            </div>
                        </x-slot:content>
                    </x-mary-collapse>
                @endforeach
            </x-mary-accordion>
        </div>
    @endif
</div>
