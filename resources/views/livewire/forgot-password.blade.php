<div class="h-screen w-screen grid place-items-center pr-4 md:pr-0">
    @if (session()->has('status'))
        <x-mary-alert icon="o-exclamation-triangle"
            class="alert-success text-text-primary z-50 !pb-0 w-9/12 md:w-4/12 absolute right-4 md:right-16 translate-x-1/2 text-xs top-32 md:bottom-auto md:top-24 alert-slide-out">
            {{ session('status') }}
        </x-mary-alert>
    @endif
    <x-mary-form wire:submit="sendPasswordResetLink"
        class="w-9/12 ml-8 md:ml-auto -translate-y-1/2 rounded-xl bg-base-300 p-8 mx-auto md:w-fit flex flex-col gap-2">
        <div class="text-sm text-text-subtle max-w-sm pb-8">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        <!-- Email Address -->
        <div class="flex flex-col gap-4">
            <x-mary-input wire:model="email" id="email" :label="__('Email')" type="email" inline clearable
                error-field="email_error" class="base-input" error-class="form-error-custom" autofocus required />


            <div class="mt-4 flex items-center justify-end">
                <x-mary-button class="btn-secondary" type="submit">
                    {{ __('Email Password Reset Link') }}
                </x-mary-button>
            </div>
    </x-mary-form>
</div>
