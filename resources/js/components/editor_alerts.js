// alert helpers
const initAlerts = (baseAlert, templateAlert, notifWrapper) => {
    baseAlert = templateAlert.cloneNode(true);
    // remove the initial alert. Effectively it was just
    // a markup template for the sctipt to clone
    templateAlert.remove();
    // append new node that js will be able to keep track of
    // without potential null errors
    notifWrapper.appendChild(baseAlert);
    return baseAlert;
};

const cycleAlerts = (toDelete, baseAlert, notifWrapper) => {
    // if any lingering alert or user clicks like crazy
    // remove what is marked to remove in the first place
    // doing fresh lookup for whatever amount of old notifs
    // that might be present in the DOM
    toDelete = document.querySelectorAll(".alert-to-delete");
    if (toDelete.length > 0) {
        console.log("cleaning up old alerts");
        toDelete.forEach((el) => {
            el.remove();
        });
    }

    // select and show node object currently present in the runtime
    const currentAlert = document.querySelector("#note-saved-alert");
    currentAlert.classList.remove("hidden");
    // strip the id to not have duplicate instances
    currentAlert.removeAttribute("id");

    // start its slide out animation
    requestAnimationFrame(() => {
        currentAlert.classList.add("animate-slide-out-short");
    });
    // Insert the new alert and clean up the old one
    notifWrapper.appendChild(baseAlert);
    // by marking the old alert for deletion
    currentAlert.classList.add("alert-to-delete");
    // Remove old alerts after the animation duration
    // even if user stops triggering this function re-run
    setTimeout(() => {
        toDelete = document.querySelectorAll(".alert-to-delete");
        toDelete.forEach((el) => {
            console.log("cleaning up post-animation");
            el.remove();
        });
    }, 3000);
};

export default function ($wire) {
    const notifWrapper = document.querySelector("#notif-wrapper");
    const templateAlert = document.querySelector("#note-saved-alert");
    templateAlert.classList.add("hidden");

    let baseAlert, toDelete;

    baseAlert = initAlerts(baseAlert, templateAlert, notifWrapper);

    // set the component to listen to LW event to execute
    // when server confirmed saving fire up the func
    $wire.on("note-saved", (e) => {
        if (e.showAlert === true) {
            cycleAlerts(toDelete, baseAlert, notifWrapper);
        }
    });
}
