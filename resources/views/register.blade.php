<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multistep - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/registration.js'])
</head>
<body>
    <div class="auth-container">
        <h1>Register</h1>
        <form method="POST" action="{{ route("register") }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="registration-step registration-step-1" data-step="1">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="{{ old("name") }}" class="form-control" id="name">
                </div>
                <button class="registration-step-button" data-step="1">Next</button>
            </div>
            <div class="registration-step registration-step-2 d-none" data-step="2">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ old("email") }}" class="form-control" id="email">
                </div>
                <button class="registration-step-button" data-step="2">Next</button>
            </div>
            <div class="registration-step registration-step-3 d-none" data-step="3">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="text" name="password" value="{{ old("password") }}" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="text" name="password_confirmation" value="{{ old("password_confirmation") }}" class="form-control" id="password_confirmation">
                </div>
                <button class="registration-step-button" data-step="3">Next</button>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
