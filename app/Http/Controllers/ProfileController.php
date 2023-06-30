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
            'password_new' => 'required|confirmed|min:8',
            'password_new_confirmation' => 'required'
        ]);

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password_old])) {
            return redirect()->route('profile')->withErrors(['password_old' => 'Old password is incorrect']);
        }
        if ($request->password_old == $request->password_new) {
            return redirect()->route('profile')->withErrors(['password_new' => 'New password cannot be the same as old password']);
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', $request->password_new)) {
            return redirect()->route('profile')->withErrors(['password_new' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character']);
        }
        $user = Auth::user();
        $user->password = bcrypt($request->password_new);
        $user->save();
        return redirect()->route('profile')->with('password-success', 'Password changed successfully');
    }
    public function changeImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=1000,max_height=1000|dimensions:min_width=100,min_height=100|dimensions:ratio=1/1'
        ]);
        $user = Auth::user();
        $imageName = $user->id . '.' . $request->image->extension();
        if($user->image != "") {
            if (file_exists(public_path('images/' . $user->image))) {
                unlink(public_path('images/' . $user->image));
            }
        }
        $request->image->move(public_path('images'), $imageName);
        $user->image = $imageName;
        $user->save();
        session()->put('user', $user);
        return redirect()->route('profile')->with('image-success', 'Image changed successfully');
    }

}
