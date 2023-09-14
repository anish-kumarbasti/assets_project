<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('Backend.Page.Setting.User.create', compact('user'));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the provided current password matches the user's current password
        if (Hash::check($request->current_password, $user->password)) {
            // Update the user's password with the new hashed password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            // Redirect the user with a success message
            return redirect()->route('home')->with('status', 'Password changed successfully.');
        }

        // If the provided current password doesn't match, redirect back with an error message
        return redirect()->back()->withErrors(['current_password' => 'The provided current password does not match your password.']);
    }
    public function updateProfilePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    $user = Auth::user();

    if ($request->hasFile('photo')) {
        // Store and update the user's profile photo
        $photoPath = $request->file('photo')->store('profile_photos', 'public');
        $user->profile_photo = $photoPath;
        $user->save();
    }

    // Redirect back to the profile photo update page with a success message
    return redirect()->route('home')->with('status', 'Profile photo updated successfully.');
}
public function updateCoverPhoto(Request $request)
{
    $request->validate([
        'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    $user = Auth::user();

    if ($request->hasFile('cover_photo')) {
        // Store and update the user's cover photo
        $coverPhotoPath = $request->file('cover_photo')->store('cover_photos', 'public');
        $user->cover_photo = $coverPhotoPath;
        $user->save();
    }

    // Redirect back to the cover photo update page with a success message
    return redirect()->route('home')->with('status', 'Cover photo updated successfully.');
}

}
