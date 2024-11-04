@use(App\Helpers\UI)


{{-- NOTE: src https://www.patrykgulas.com/hamburgers --}}
<button
    class="tham tham-e-arrow tham-w-6 fixed top-0 z-50 mx-4 mt-2 {{ UI::getSidebarState() ? 'tham-active' : '' }} p-6 rounded-lg hover:bg-base-100 focus-visible:bg-base-100"
    type="button" role="switch" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation"
    aria-controls="drawer-navigation">
    <div class="tham tham-e-arrow tham-w-6 hover:!opacity-100 focus-visible:!opacity-100">
        <div class="tham-box">
            <div
                class="tham-inner {{ UI::getSidebarState() ? 'bg-text-primary' : 'bg-accent-primary' }}  transition-all duration-100">
            </div>
        </div>
</button>
