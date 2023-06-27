<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = Auth::user();
        return [
            'name' => 'required',
            'surname' => 'required',
            'username' => ['required', Rule::unique('users')->ignore($user->id)],
            'birthday' => 'required|date|before:today',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ];
    }
}
