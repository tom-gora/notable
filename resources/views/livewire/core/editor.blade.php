<div class="relative flex max-h-[75vh] flex-col items-center gap-4 overflow-scroll scroll-smooth px-36 pb-4">
    <div id="notif-wrapper"><x-mary-alert
            class="alert-success text-text-primary animate-slide-out-short absolute right-4 top-32 z-50 hidden w-9/12 translate-x-1/2 text-xs md:bottom-auto md:right-16 md:top-24 md:w-4/12"
            icon="o-exclamation-triangle" id="note-saved-alert">
            {{ __('The note was saved successfully.') }}
        </x-mary-alert></div>

    <div class="sticky right-0 top-4 z-50 ms-auto flex w-fit translate-x-32 flex-col gap-4 px-8">
        <x-mary-button :label="__('Save')" class="btn-secondary w-full" id="save-btn" spinner="save"
            wire:click="save(true)" />
        <x-mary-button :label="__('Close')" class="btn-primary w-full" spinner="closeEditor" wire:click="closeEditor" />
    </div>
    <div class="flex w-full -translate-y-24 flex-col items-center gap-4" id="editor-wrapper">
        <x-mary-markdown :config="$this->getMdeConfig()" label='"{!! $title !!}"' wire:model="markdown" />
    </div>

    @script
        <script>
            const templateAlert = document.querySelector("#note-saved-alert");
            templateAlert.classList.add("hidden");
            const notifWrapper = document.querySelector("#notif-wrapper");
            const saveBtn = document.querySelector("#save-btn");

            let baseAlert, currentAlert, nextAlert;
            const initAlerts = () => {
                //HACK:
                // on init hide this node using js for class injection
                // b/c for some reason it fails if I hardcode it in markup (?)
                // prep a next as a copy already hidden and store for now in the runtime only
                baseAlert = templateAlert.cloneNode(true);
                // remove the initial one. Effectively it was just a markup template to get content shown
                templateAlert.remove();
                notifWrapper.appendChild(baseAlert);
            }
            initAlerts();

            const cycleAlerts = () => {
                // if any lingering alert or user clicks like crazy remove what is marked to remove
                // doing fresh lookup for whatever amount of old notifs that might be present
                const toDelete = document.querySelectorAll(".alert-to-delete")
                toDelete.forEach(el => {
                    el.remove();
                });

                // select and show currently present in the dom alert node
                currentAlert = document.querySelector("#note-saved-alert");
                currentAlert.classList.remove("hidden");
                // again strip the id to not have duplicate instances
                currentAlert.removeAttribute("id");

                // start its slide out animation
                requestAnimationFrame(() => {
                    currentAlert.classList.add("animate-slide-out-short");
                });

                // Insert the new alert and clean up the old one
                notifWrapper.appendChild(baseAlert);

                // Mark old alert for deletion
                currentAlert.classList.add("alert-to-delete");

                // Remove old alerts after the animation duration even if user stops triggering this function
                setTimeout(() => {
                    toDelete.forEach(el => {
                        el.remove();
                    });
                }, 3000);
            }

            // when server confirmed saving fire up the func
            $wire.on("note-saved", (e) => {
                if (e.showAlert === true) {
                    cycleAlerts();
                }
            });
        </script>
    @endscript

</div>
