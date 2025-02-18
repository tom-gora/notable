<div class="bg-base-100 grid h-full w-full place-items-center">
    <div class="flex flex-col-reverse gap-4 pl-6 pr-2 pt-14 md:w-full md:flex-row md:pt-4" id="notable-main-dashboard">
        {{-- accordion listing --}}
        <livewire:core.home-listing-pane :hook="$hook" />
        {{-- add a note / preview --}}
        <livewire:core.home-preview-pane :hook="$hook" />
    </div>
</div>
