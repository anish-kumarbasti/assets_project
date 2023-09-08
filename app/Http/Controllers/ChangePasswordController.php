<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function changePassword(){
        $user=User::all();
        return view('Backend.Page.Seting.User.create',compact('user'));
    }

    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('photo')) {
            // Delete the old profile photo, if it exists
            if ($user->profile_photo) {
                // Assuming 'profile_photos' is the disk where profile photos are stored
                // You may need to change the disk name to match your configuration
                User::disk('profile_photos')->delete($user->profile_photo);
            }

            // Store the new profile photo
            $profilePhotoPath = $request->file('photo')->store('profile_photos', 'public');

            // Update the user's profile_photo attribute with the new path
            $user->update([
                'profile_photo' => $profilePhotoPath,
            ]);
        }

        return redirect()->route('password.change')->with('success', 'Profile photo updated successfully.');
    }
}
