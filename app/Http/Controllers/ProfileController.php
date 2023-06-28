<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate($request->rules());
        $user->fill($request->validated());
        $user->save();
        session()->put('user', $user);

        return redirect()->route('profile')->with('profile-success', 'Profile updated successfully');
    }

    public function destroy(): RedirectResponse
    {
        $user = Auth::user();
        $user->delete();
        return redirect()->route('logout');
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password_old' => 'required',
            'password_new' => 'required|confirmed',
            'password_new_confirmation' => 'required'
        ]);

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password_old])) {
            return redirect()->route('profile')->withErrors(['password_old' => 'Old password is incorrect']);
        }
        if ($request->password_old == $request->password_new) {
            return redirect()->route('profile')->withErrors(['password_new' => 'New password cannot be the same as old password']);
        }
        $user = Auth::user();
        $user->password = bcrypt($request->password_new);
        $user->save();
        return redirect()->route('profile')->with('password-success', 'Password changed successfully');
    }

}
