<div id="notable-preview-pane"
    class="grid h-fit w-full place-items-center rounded-xl bg-base-200 px-2 py-4 overflow-hidden">
    @if ($isForm)
        <livewire:add-note-form />
    @elseif ($isPreview)
        <livewire:preview-render />
    @elseif ($isEditor)
        <div id="notif-wrapper"><x-mary-alert id="note-saved-alert" icon="o-exclamation-triangle"
                class="alert-success text-text-primary z-50 w-9/12 md:w-4/12 fixed right-4 md:right-16 translate-x-1/2 text-xs top-32 md:bottom-auto md:top-24 alert-slide-out-short">
                The note was saved successfully.
            </x-mary-alert></div>
        <livewire:editor :edited_id="$triggered_id" />
    @else
        <x-mary-button class="btn-primary" wire:click="showAddNoteForm">Add a note</x-mary-button>
        <x-auth-svg-01 />
    @endif

    {{-- HACK: REGARDING JS BELOW. Had to put comment here because blade was freaking out and crashing
    trying to parse JS comments in JS block that happen to contain some special chars.
    Yup. Templating language for the templating language. Amazing.... :/
    pass data via two-step event. first toggle the preview pane state and here
                 start observing to actively actually wait for dom state to be changed by @if directive
                 and ONLY after #html-target has been detected in dom send next stage event from here to
                 trigger note retrieval and processing on the server that eventually updates state and
                 shows the note. Damn this crap been a nightmare to hack around XD --}}

    <script>
        document.addEventListener('livewire:initialized', () => {
            const previewPane = document.querySelector("#notable-preview-pane");
            const listPane = document.querySelector("#notable-listing-pane");
            const parser = new DOMParser();

            Livewire.on("edit-note", (e) => {
                listPane.classList.add("!w-0", "!p-0");
            });

            Livewire.on("toggle-preview", (e) => {
                const parser = new DOMParser();
                const observer = new MutationObserver((mutationsList, observer) => {
                    for (const mutation of mutationsList) {
                        if (mutation.type === 'childList') {
                            const htmlTarget = document.querySelector("#html-target");
                            if (htmlTarget !== null) {
                                fetch(`/api/internal/rendered`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/text',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        },
                                        body: e.note_id
                                    })
                                    .then(response => response.text())
                                    .then(html => {
                                        const parsedHtml = parser.parseFromString(html,
                                            'text/html');
                                        const content = parsedHtml.body.innerHTML;
                                        htmlTarget.innerHTML = content;
                                    })
                                    .catch(error => console.error(error));
                                observer
                                    .disconnect(); // Disconnect the observer after the target is found
                                break;
                            }
                        }
                    }
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });

            Livewire.on("close-editor", () => {
                listPane.classList.remove("!w-0", "!p-0");
                listPane.classList.add("w-full", "p-4");
            });
        });
    </script>
</div>
