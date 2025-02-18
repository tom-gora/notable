<div>
    <section class="space-y-6">
        <header>
            <h2 class="text-accent-primary text-xl font-medium">
                {{ __('Delete Account') }}
            </h2>

            <p class="text-text-subtle mt-1 text-sm">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
            </p>
        </header>

        <x-mary-button :label="__('Delete Account')" @click="$wire.show_modal = true" class="btn-error" />

        <x-mary-modal :show="$errors->isNotEmpty()" box-class="bg-base-300" focusable name="confirm-user-deletion" persistent
            wire:model="show_modal">
            <x-mary-form class="p-6" wire:submit="deleteUser">

                <h2 class="text-text-primary text-lg font-medium">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-text-subtle mt-1 text-justify text-sm">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6 flex w-full justify-end">
                    <x-mary-password :label="__('Password')" autocomplete="off" class="base-input" clearable
                        error-class="form-error-custom" error-field="pass_error" id="password" inline required
                        type="password" wire:model="password" />
                </div>

                <div class="mt-6 flex justify-end gap-8">
                    <x-mary-button :label="__('Cancel')" @click="$wire.show_modal = false" class="btn-primary min-w-40" />

                    <x-mary-button :label="__('Delete Account')" class="btn-error min-w-40" type="submit" />
                </div>
            </x-mary-form>
        </x-mary-modal>
    </section>
</div>
