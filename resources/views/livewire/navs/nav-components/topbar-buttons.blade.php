<div
    class="auth-controls relative z-50 flex w-full scale-90 flex-col items-end justify-end gap-2 px-2 pt-2 md:mt-0 md:scale-100 md:flex-row md:items-center md:gap-4 md:px-8">
    @auth
        <x-mary-dropdown class="btn-secondary" icon="o-user" no-x-anchor right>
            <x-mary-menu-item :title="__('Your profile')" link="/profile" wire:navigate />
            <x-mary-menu-item :title="__('Log out')" wire:click="logout" />
        </x-mary-dropdown>
    @else
        <div class="flex translate-y-2 gap-4">
            <x-mary-button :label="__('Log in')" class="btn-secondary w-24" link="{{ route('login') }}" wire:navigate.hover />
            @if (Route::has('register'))
                <x-mary-button :label="__('Sign up')" class="btn-secondary w-24" link="{{ route('register') }}"
                    wire:navigate.hover />
            @endif
        </div>
    @endauth
</div>
