<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('register');
    }

    /**
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        session_start();
        // Checks if all the session variables are set in order to prevent direct access to this route
        if (!isset($_SESSION['name'], $_SESSION['surname'], $_SESSION['username'], $_SESSION['birthday'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['password'])) {
            return redirect()->route('register');
        }

        $user = User::create([
            'name' => $_SESSION['name'],
            'surname' => $_SESSION['surname'],
            'username' => $_SESSION['username'],
            'birthday' => $_SESSION['birthday'],
            'email' => $_SESSION['email'],
            'country_code' => $_SESSION['country_code'],
            'phone' => $_SESSION['phone'],
            'password' => $_SESSION['password'],
        ]);
        // Unset all the session variables and destroy the session
        session_unset();
        session_destroy();
        event(new Registered($user));
        return redirect()->route('login');
    }

    public function validate1(): JsonResponse
    {
        session_start();
        try {
            $this->validate(request(), [
                'name' => 'required|min:2|alpha',
                'surname' => 'required|min:2|alpha',
                'username' => 'required|unique:users|min:8',
                'birthday' => 'required|date|before:today',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        $_SESSION['name'] = request('name');
        $_SESSION['surname'] = request('surname');
        $_SESSION['username'] = request('username');
        $_SESSION['birthday'] = request('birthday');
        $data = [
            'step' => 2,
        ];
        return \response()->json($data);
    }

    public function validate2(): JsonResponse
    {
        session_start();
        try {
            $this->validate(request(), [
                'email' => 'required|email:strict|unique:users',
                'country_code' => 'required',
                'phone' => 'required|unique:users|regex:/^[0-9]{8,15}$/',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        $_SESSION['email'] = request('email');
        $_SESSION['country_code'] = request('country_code');
        $_SESSION['phone'] = request('phone');
        $data = [
            'step' => 3,
        ];
        return \response()->json($data);
    }

    public function validate3()
    {
        session_start();
        try {
            $this->validate(request(), [
                'password' => 'required|confirmed|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', request('password'))) {
            $data = [
                'password' => ['The password must contain at least 1 uppercase, 1 lowercase, 1 number and 1 special character.'],
            ];
            return \response()->json($data, 422);
        }
        $_SESSION['password'] = password_hash(request('password'), PASSWORD_BCRYPT);
        $data = [
            'step' => 4,
        ];
        return \response()->json($data);
    }
}
