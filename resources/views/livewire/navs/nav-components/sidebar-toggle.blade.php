<div>
    <button aria-controls="drawer-navigation"
        class="tham tham-e-arrow tham-w-6 {{ $sidebarState ? 'tham-active' : '' }} hover:bg-base-100 focus-visible:bg-base-100 fixed top-0 z-50 mx-4 mt-2 rounded-lg p-6"
        data-drawer-show="drawer-navigation" data-drawer-target="drawer-navigation" role="switch" type="button">
        <div class="tham tham-e-arrow tham-w-6 hover:!opacity-100 focus-visible:!opacity-100">
            <div class="tham-box">
                <div
                    class="tham-inner {{ $sidebarState ? 'bg-text-primary' : 'bg-accent-primary' }} transition-all duration-100">
                </div>
            </div>
        </div>
    </button>
</div>
