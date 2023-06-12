document.addEventListener("DOMContentLoaded", function(event) {
    const REGISTRATION_STEPS = document.querySelectorAll('.registration-step');
    const REGISTRATION_STEPS_BUTTONS = document.querySelectorAll('.registration-step-button');
    REGISTRATION_STEPS_BUTTONS.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const step = button.dataset.step;
            //q: how does button.dataset.step work?
            //a: https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes
            REGISTRATION_STEPS.forEach((stepElement) => {
                stepElement.classList.add('d-none');
            });
            document.querySelector(`.registration-step-${parseInt(step)+1}`).classList.remove('d-none');
        });
    });
});
