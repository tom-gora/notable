export default function () {
    // TODO: also undo any previously toggled labels back to original state when new one is toggled
    // DONE implementation -> rudimental AF. The mary lib uses ghost radio input to bind state and toggles classes, playing animations
    // but fails to uncheck the radios when next one gets checked. So I need to do the manual work for them.
    // I hate it as it is a horrible nested expression russian doll but it is what it is I guess
    const collapseGroupsRadios = document.querySelectorAll(
        '.collapse input[type="radio"]',
    );
    collapseGroupsRadios.forEach((radio) => {
        const siblingHint = radio.parentElement.querySelector(".collapse-hint");
        radio.addEventListener("change", function () {
            if (this.checked) {
                collapseGroupsRadios.forEach((otherRadio) => {
                    if (otherRadio !== this) {
                        otherRadio.checked = false;
                        const otherHint =
                            otherRadio.parentElement.querySelector(
                                ".collapse-hint",
                            );
                        if (otherHint) {
                            otherHint.innerText = "More";
                        }
                    }
                });
                siblingHint.innerText = "Less";
            } else {
                siblingHint.innerText = "More";
            }
        });
    });
}
