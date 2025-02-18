export default function () {
    // set the component to listen to LW event to execute
    // when server confirmed saving fire up the func
    Livewire.on("note-saved", () => {
        const alert = document.querySelector("#note-saved-alert");
        alert.classList.remove("hidden");
        alert.classList.add("animate-slide-out-short");
        setTimeout(() => {
            alert.classList.add("hidden");
            alert.classList.remove("animate-slide-out-short");
        }, 2200);
    });
}
