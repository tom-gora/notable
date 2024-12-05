<section>
    <header>
        <h2 class="text-accent-secondary text-xl font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-text-subtle mt-1 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form class="mt-6 space-y-6" wire:submit="updateProfileInformation">
        <x-mary-input :label="__('Name')" autocomplete="name" autofocus class="base-input" clearable inline required
            type="text" wire:model="name" />
        <x-mary-input :label="__('Email')" autocomplete="username" class="base-input" clearable inline required
            type="email" wire:model="email" />
        <div>
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div class="flex flex-col items-start justify-between gap-4">
                    <p class="text-info text-sm">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <x-mary-button :label="__('Resend the email')" class="btn-warning" wire:click.prevent="sendVerification" />

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-2 text-sm font-medium">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-mary-button :label="__('Save')" class="btn-secondary" type="submit" />

            <!--TODO: Replace with something from mary-->
            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
