<div class="flex h-full grow w-full flex-col items-center pl-4 md:pl-8 pr-2 md:pr-4">
    <div id="notable-main-dashboard"
        class="flex pt-14 md:pt-4 w-[96%] md:w-full h-max grow flex-col-reverse gap-4 md:flex-row">
        {{-- accordion listing --}}
        <livewire:home-listing-pane />
        {{-- add a note / preview --}}
        <livewire:home-preview-pane />
    </div>
</div>
