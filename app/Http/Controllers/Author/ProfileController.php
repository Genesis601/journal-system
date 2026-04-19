<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('author.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'institution' => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'bio'         => 'nullable|string|max:1000',
            'password'    => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'institution' => $request->institution,
            'country'     => $request->country,
            'phone'       => $request->phone,
            'bio'         => $request->bio,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('author.profile.edit')
                         ->with('success', 'Profile updated successfully!');
    }
}