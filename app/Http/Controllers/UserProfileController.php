<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'description' => $request->input('description'),
            'gender' => $request->input('gender'),
            'profile_picture' => $request->input('profile_picture'),
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
}
