document.addEventListener('DOMContentLoaded', () => {
    let firstForm = document.getElementById('registration-step-1');
    let secondForm = document.getElementById('registration-step-2');
    let thirdForm = document.getElementById('registration-step-3');

    let progressBarFills = document.querySelectorAll('.progress-bar-fill');

    const endForm = document.getElementById('submit-form');

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
                let keys = Object.keys(data);

                if (keys[0] !== 'step') {
                    document.getElementById(keys[0]).classList.add('is-invalid');
                    document.getElementById('personal-error').innerHTML = data[keys[0]];
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
                let keys = Object.keys(data);

                if (keys[0] !== 'step') {
                    document.getElementById(keys[0]).classList.add('is-invalid');
                    document.getElementById('contact-error').innerHTML = data[keys[0]];
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
                let keys = Object.keys(data);

                if (keys[0] !== 'step') {
                    document.getElementById(keys[0]).classList.add('is-invalid');
                    document.getElementById('password-error').innerHTML = data[keys[0]];
                }
                else {
                    endForm.submit();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });

    function loadStep2() {
        progressBarFills[1].classList.add('filled');
        submitForm1(firstForm, secondForm);
    }
    function loadStep3() {
        submitForm1(secondForm, thirdForm);
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

function submitForm1(form1, form2) {
    form1.style.animation = 'slide-out 0.5s forwards';

    form1.addEventListener('animationend', function() {
        form1.classList.add('d-none');
        form2.classList.remove('d-none');
        form2.style.animation = 'slide-in 0.5s forwards';
    });
}
