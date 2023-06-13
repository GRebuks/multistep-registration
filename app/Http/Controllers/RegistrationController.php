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
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        $user = User::create(request(['name', 'email', 'password']));
        event(new Registered($user));
        return redirect()->route('login');
    }

    public function validate1(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'email' => 'required|email',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        $_SESSION['email'] = request('email');
        $data = [
            'step' => 2,
        ];
        return \response()->json($data);
    }

    public function validate2(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'name' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        $_SESSION['name'] = request('name');
        $data = [
            'step' => 3,
        ];
        return \response()->json($data);
    }

    public function validate3(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'password' => 'required|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        $_SESSION['password'] = password_hash(request('password'), PASSWORD_BCRYPT);
        $data = [
            'step' => 4,
        ];
        return \response()->json($data);
    }
}
