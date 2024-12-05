<div class="grid h-screen w-screen place-items-center pr-4 md:pr-0">
    @if (session()->has('status'))
        <x-mary-alert
            class="alert-success text-text-primary animate-slide-out absolute right-4 top-32 z-50 w-9/12 translate-x-1/2 !pb-0 text-xs md:bottom-auto md:right-16 md:top-24 md:w-4/12"
            icon="o-exclamation-triangle">
            {{ session('status') }}
        </x-mary-alert>
    @endif
    <x-mary-form
        class="bg-base-300 mx-auto ml-8 flex w-9/12 -translate-y-1/2 flex-col gap-2 rounded-xl p-8 md:ml-auto md:w-fit"
        wire:submit="sendPasswordResetLink">
        <div class="text-text-subtle max-w-sm pb-8 text-sm">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        <!-- Email Address -->
        <div class="flex flex-col gap-4">
            <x-mary-input :label="__('Email')" autofocus class="base-input" clearable error-class="form-error-custom"
                error-field="email_error" id="email" inline required type="email" wire:model="email" />
            <div class="mt-4 flex items-center justify-end">
                <x-mary-button :label="__('Send Link')" Password Reset class="btn-secondary" type="submit" />
            </div>
    </x-mary-form>
</div>
