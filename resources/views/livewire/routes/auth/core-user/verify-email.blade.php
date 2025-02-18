<div class="grid h-screen place-items-center">
    <x-mary-card :title="__('Just one more step...')"
        class="bg-base-300 text-accent-secondary ml-8 mr-4 flex w-[60ch] -translate-y-24 flex-col gap-4 px-8 py-4 md:ml-4 md:-translate-y-48">
        <div class="max-w-[50ch]">
            <p class="text-text-subtle text-sm">
                {{ __('Please, verify your email address by clicking on the link we just sent you.') }}
            </p>
            <p class="text-text-subtle text-sm">
                {{ __('If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
            @if (session('status') == 'verification-link-sent')
                <p class="text-success mt-4 text-sm">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            @endif
        </div>
        <x-slot:figure>
            <x-svgs.email-verification-svg-01 />
        </x-slot:figure>
        <x-slot:actions>
            <div class="flex flex-col gap-4 md:flex-row">
                <x-mary-button :label="__('Resend the email')" class="btn-warning" wire:click="sendVerification" />
                <x-mary-button :label="__('Log out')" class="btn-primary" type="submit" wire:click="logout" />
            </div>
        </x-slot:actions>
    </x-mary-card>

</div>
