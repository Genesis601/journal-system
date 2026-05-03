<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SimplePasswordResetController extends Controller
{
    public function show()
    {
        return view('auth.forgot-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // Only authors can self-reset
        // Editors and Admins must contact super admin
        if ($user->hasRole('super_admin') || $user->hasRole('editor')) {
            return back()->with('error',
                'Editors and Admins cannot self-reset passwords. Please contact the Super Admin.'
            );
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
                         ->with('success', 'Password reset successfully! You can now login.');
    }
}