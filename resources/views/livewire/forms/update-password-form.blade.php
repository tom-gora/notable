<section>
    <header>
        <h2 class="text-accent-secondary text-xl font-medium">
            {{ __('Update Your Password') }}
        </h2>
        <p class="text-text-subtle mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form class="mt-6 space-y-6" wire:submit="updatePassword">

        <x-mary-password :label="__('Current Password')" autocomplete="current-password" class="base-input" clearable inline required
            type="password" wire:model="current_password" />
        <x-mary-password :label="__('New Password')" autocomplete="new-password" class="base-input" clearable inline required
            type="password" wire:model="password" />
        <x-mary-password :label="__('Confirm New Password')" autocomplete="new-password" class="base-input" clearable inline required
            type="password" wire:model="password_confirmation" />

        <x-mary-button class="btn-secondary" label="{{ __('Save') }}" type="submit" />
        <!--TODO: Replace with something from mary-->
        <x-action-message class="me-3" on="password-updated">
            {{ __('Saved.') }}
        </x-action-message>
    </form>
</section>
