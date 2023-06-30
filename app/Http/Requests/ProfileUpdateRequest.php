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
            'name' => 'required|min:2|alpha',
            'surname' => 'required|min:2|alpha',
            'username' => ['required', Rule::unique('users')->ignore($user->id)],
            'birthday' => 'required|date|before:today',
            'email' => ['required', 'email:strict', Rule::unique('users')->ignore($user->id)],
            'country_code' => 'required',
            'phone' => ['required', 'regex:/^[0-9]{8,15}$/', Rule::unique('users')->ignore($user->id)],
        ];
    }
}
