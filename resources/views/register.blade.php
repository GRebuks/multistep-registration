<?php
if (session_status() != PHP_SESSION_NONE) {
    session_destroy();
}
session_start();
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multistep - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/registration.js','node_modules/better-dateinput-polyfill/dist/better-dateinput-polyfill.js'])
    <meta name="dateinput-polyfill-media" content="screen">
    <meta name="dateinput-polyfill-format" content='{"day":"numeric","month":"numeric","year":"numeric"}'>
</head>
<body class="antialiased">
    <div class="auth-wrapper">
        <div class="auth-container" id="registrationContainer">
            <h1 class="text-3xl font-bold">Registration</h1>
            <a href="{{ route('login') }}" class="auth-redirect text-2xl">Login</a>
            <div class="progress-bar">
                <div class="progress-bar-fill-1 progress-bar-fill filled">
                    <h2>1</h2>
                </div>
                <div class="progress-bar-fill-2 progress-bar-fill">
                    <h2>2</h2>
                </div>
                <div class="progress-bar-fill-3 progress-bar-fill">
                    <h2>3</h2>
                </div>
            </div>
            <div class="form-content">
                <form method="POST" id="registration-step-1" action="{{ route('register.postStep1') }}" class="registration-step form">
                    <h2 class="text-xl">Personal information</h2>
                    <p id="personal-error" class="error"></p>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-input-field">
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="name" class="auth-label">Name</label>
                                <input type="text" name="name" id="name" class="auth-input">
                            </div>

                            <div class="form-input">
                                <label for="surname" class="auth-label">Surname</label>
                                <input type="text" name="surname" id="surname" class="auth-input">
                            </div>
                        </div>
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="username" class="auth-label">Username</label>
                                <input type="text" name="username" id="username" class="auth-input">
                            </div>
                        </div>
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="birthday" class="auth-label">Birthday</label>
                                <input type="date" name="birthday" id="birthday" class="auth-input" data-format='{"day":"numeric","month":"numeric","year":"numeric"}' placeholder="dd/mm/yyyy">
                            </div>
                        </div>

                    </div>
                    <button type="submit">Next</button>
                </form>

                <form method="POST" id="registration-step-2" action="{{ route('register.postStep2') }}" class="d-none registration-step form">
                    <h2 class="text-xl">Contact information</h2>
                    <p id="contact-error" class="error"></p>
                    <div class="form-input-field">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="email" class="auth-label">E-mail</label>
                                <input type="text" name="email" id="email" class="auth-input">
                            </div>
                        </div>
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="phone" class="auth-label">Phone number</label>
                                <x-country-code></x-country-code>
                            </div>
                        </div>

                    </div>
                    <button type="submit">Next</button>
                </form>

                <form method="POST" id="registration-step-3" action="{{ route('register.postStep3') }}" class="d-none registration-step form">
                    <h2 class="text-xl">Password</h2>
                    <p id="password-error" class="error"></p>
                    <div class="form-input-field">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="password" class="auth-label">Password</label>
                                <input type="password" name="password" id="password" class="auth-input">
                            </div>
                        </div>

                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="password_confirmation" class="auth-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input">
                            </div>
                        </div>
                            </div>
                    <button type="submit">Submit</button>
                </form>
                <form method="POST" action="{{ route('register') }}" id="submit-form">
                    @csrf
                </form>
            </div>
            <script>
                let postStep1 = "{{ route('register.postStep1') }}";
                let postStep2 = "{{ route('register.postStep2') }}";
                let postStep3 = "{{ route('register.postStep3') }}";
            </script>
        </div>
    </div>
</body>
</html>
