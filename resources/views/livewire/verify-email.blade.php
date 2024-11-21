<div class="h-screen grid place-items-center">

    <x-mary-card title="Just one more step..."
        class="px-8 py-4 ml-8 md:ml-4 mr-4 max-w-screen-sm bg-base-300 flex flex-col gap-4 -translate-y-24 md:-translate-y-48">
        <p class="text-text-subtle text-sm">
            {{ __('Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
        @if (session('status') == 'verification-link-sent')
            <p class="text-info">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </p>
        @endif
        <x-slot:figure>
            <x-email-verification-svg-01 />
        </x-slot:figure>
        <x-slot:actions>
            <div class="flex flex-col md:flex-row gap-4">
                <x-mary-button label="{{ __('Resend Verification Email') }}" class="btn-secondary"
                    wire:click="sendVerification" />
                <x-mary-button label="{{ __('Log Out') }}" wire:click="logout" type="submit" class="btn-primary" />
            </div>
        </x-slot:actions>
    </x-mary-card>

</div>
