<div class="flex flex-col items-center gap-4 w-full">

    <div id="editor-wrapper" class="flex flex-col items-center gap-4 w-full">
        <x-mary-markdown wire:model="markdown" :config="$this->getMdeConfig()" label=" '{{ $title }}'" />
    </div>
    <div class="flex gap-8 justify-end w-full px-8">
        <x-mary-button id="save-btn" wire:click="save(true)" label="Save note" class="btn-secondary w-fit"
            spinner="save" />
        <x-mary-button wire:click="closeEditor" label="Close" class="btn-primary w-fit" spinner="closeEditor" />
    </div>

    @script
        <script>
            const notifWrapper = document.querySelector("#notif-wrapper");
            const saveBtn = document.querySelector("#save-btn");

            const editorTitle = document.querySelector("#editor-wrapper label");
            const prependedSpan = document.createElement("span");
            prependedSpan.innerText = "Editing note";
            prependedSpan.classList.add("text-text-primary");
            editorTitle.prepend(prependedSpan);

            let baseAlert, currentAlert, nextAlert;
            const initAlerts = () => {
                const templateAlert = document.querySelector("#note-saved-alert");
                //HACK:
                // on init hide this node using js for class injection
                // b/c for some reason it fails if I hardcode it in markup (?)
                templateAlert.classList.add("hidden");
                // prep a next as a copy already hidden and store for now in the runtime only
                baseAlert = templateAlert.cloneNode(true);
                // remove the initial one. Effectively it was just a markup template to get content shown
                templateAlert.remove();
                notifWrapper.appendChild(baseAlert);
            }

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
                    currentAlert.classList.add("alert-slide-out-short");
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

            initAlerts();
        </script>
    @endscript
</div>