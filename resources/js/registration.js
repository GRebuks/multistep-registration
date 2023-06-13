document.addEventListener('DOMContentLoaded', () => {
    let firstForm = document.getElementById('registration-step-1');
    let secondForm = document.getElementById('registration-step-2');
    let thirdForm = document.getElementById('registration-step-3');

    let progressBarFills = document.querySelectorAll('.progress-bar-fill');

    firstForm.addEventListener('submit', (event) => {
        disableFormButton(firstForm);
        event.preventDefault();

        fetch(postStep1, {
            method: 'POST',
            body: new FormData(firstForm),
        })
            .then(response => response.json())
            .then((data) => {
                enableFormButton(firstForm);
                if (data.email) {
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('email-error').innerHTML = data.email;
                }
                if (data.step === 2) {
                    loadStep2();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });

    secondForm.addEventListener('submit', (event) => {
        event.preventDefault();

        fetch(postStep2, {
            method: 'POST',
            body: new FormData(secondForm),
        })
            .then(response => response.json())
            .then((data) => {
                if (data.name) {
                    document.getElementById('name').classList.add('is-invalid');
                    document.getElementById('username-error').innerHTML = data.name;
                }
                if (data.step === 3) {
                    loadStep3();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });

    thirdForm.addEventListener('submit', (event) => {
        event.preventDefault();

        fetch(postStep3, {
            method: 'POST',
            body: new FormData(thirdForm),
        })
            .then(response => response.json())
            .then((data) => {
                if (data.password) {
                    document.getElementById('password').classList.add('is-invalid');
                    document.getElementById('password_confirmation').classList.add('is-invalid');
                    document.getElementById('password-error').innerHTML = data.password;
                }
                if (data.step === 4) {
                    loadStep2();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });

    function loadStep2() {
        firstForm.classList.add('d-none');
        secondForm.classList.remove('d-none');
        progressBarFills[1].classList.add('filled');
    }
    function loadStep3() {
        secondForm.classList.add('d-none');
        thirdForm.classList.remove('d-none');
        progressBarFills[2].classList.add('filled');
    }
});

function enableFormButton(form) {
    form.querySelectorAll('button')[0].classList.remove('disabled');
    form.querySelectorAll('button')[0].removeAttribute('disabled');
}

function disableFormButton(form) {
    form.querySelectorAll('button')[0].classList.add('disabled');
    form.querySelectorAll('button')[0].setAttribute('disabled', 'disabled');
}
