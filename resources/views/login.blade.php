<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Multistep - Login</title>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container" id="registrationContainer">
            <h1>Login</h1>
            <a href="{{ route('register') }}" class="auth-redirect">Register</a>
            <div class="form-content">
                <form method="POST" action="{{ route('login') }}" class="registration-step">
                    @csrf
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
                    <div class="form-input-field">
                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="username" class="auth-label">Username</label>
                                <input type="text" name="username" id="username" class="auth-input">
                                @if($errors->has('username'))
                                    @foreach ($errors->get('username') as $error)
                                        <p class="error">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-input-group">
                            <div class="form-input">
                                <label for="password" class="auth-label">Password</label>
                                <input type="password" name="password" id="password" class="auth-input">
                                @if($errors->has('password'))
                                    @foreach ($errors->get('password') as $error)
                                        <p class="error">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>


                    </div>
                    <button type="submit">Next</button>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
