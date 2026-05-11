<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Rate limiting — max 3 attempts per hour per email
        $key = 'password-reset:' . $request->email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error',
                'Too many reset attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.'
            );
        }
        RateLimiter::hit($key, 3600);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $user     = User::where('email', $request->email)->first();
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        try {
            Mail::to($user->email)
                ->send(new PasswordResetMail($resetUrl, $user->name));

            return back()->with('success',
                'A password reset link has been sent to ' . $request->email .
                '. Please check your inbox and spam folder. The link expires in 60 minutes.'
            );
        } catch (\Exception $e) {
            Log::error('Password reset email failed: ' . $e->getMessage());

            DB::table('password_reset_tokens')
              ->where('email', $request->email)
              ->delete();

            return back()->with('error',
                'Failed to send reset email. Please try again later.'
            );
        }
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.forgot')
                             ->with('error', 'Invalid reset link.');
        }

        $resetRecord = DB::table('password_reset_tokens')
                         ->where('email', $email)
                         ->first();

        if (!$resetRecord) {
            return redirect()->route('password.forgot')
                             ->with('error', 'Invalid or expired reset link. Please request a new one.');
        }

        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.forgot')
                             ->with('error', 'This reset link has expired. Please request a new one.');
        }

        if (!Hash::check($token, $resetRecord->token)) {
            return redirect()->route('password.forgot')
                             ->with('error', 'Invalid reset link. Please request a new one.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
                         ->where('email', $request->email)
                         ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Invalid or expired reset link.');
        }

        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')
              ->where('email', $request->email)
              ->delete();
            return redirect()->route('password.forgot')
                             ->with('error', 'This reset link has expired. Please request a new one.');
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Invalid reset link. Please request a new one.');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')
          ->where('email', $request->email)
          ->delete();

        RateLimiter::clear('password-reset:' . $request->email);

        return redirect()->route('login')
                         ->with('success', 'Password reset successfully! You can now login with your new password.');
    }
}