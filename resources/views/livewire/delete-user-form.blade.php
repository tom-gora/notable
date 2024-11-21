<div>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-text-primary">
                {{ __('Delete Account') }}
            </h2>

            <p class="mt-1 text-sm text-text-subtle">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
            </p>
        </header>

        <x-mary-button @click="$wire.show_modal = true" class="btn-error">
            {{ __('Delete Account') }}
        </x-mary-button>

        <x-mary-modal wire:model="show_modal" persistent name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable
            box-class="bg-base-300">
            <x-mary-form wire:submit="deleteUser" class="p-6">

                <h2 class="text-lg font-medium text-text-primary">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-text-subtle text-justify">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6 flex justify-end w-full">
                    <x-mary-password wire:model="password" id="password" :label="__('Password')" type="password" inline
                        clearable error-field="pass_error" class="base-input" error-class="form-error-custom" required
                        autocomplete="off" />
                </div>

                <div class="mt-6 flex gap-8 justify-end">
                    <x-mary-button label="{{ __('Cancel') }}" class="min-w-40 btn-primary"
                        @click="$wire.show_modal = false" />

                    <x-mary-button label="{{ __('Delete Account') }}" class="min-w-40 btn-error" type="submit" />
                </div>
            </x-mary-form>
        </x-mary-modal>
    </section>
</div>
