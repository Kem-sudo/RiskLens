<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    private int $tokenExpiryMinutes = 60;

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('Email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'No account found for that email address.');
        }

        $plainToken = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->Email],
            [
                'token' => Hash::make($plainToken),
                'created_at' => now(),
            ]
        );

        $resetLink = route('password.reset.form', [
            'token' => $plainToken,
            'email' => $user->Email,
        ]);

        try {
            Mail::raw(
                "Hello {$user->Name},\n\nClick this link to reset your password:\n{$resetLink}\n\nThis link expires in {$this->tokenExpiryMinutes} minutes.\n\nIf you did not request this, ignore this message.",
                function ($message) use ($user) {
                    $message->to($user->Email)->subject('RiskLens Password Reset');
                }
            );

            return back()->with('success', 'Password reset link has been sent to your email.');
        } catch (\Throwable $e) {
            return back()
                ->with('success', 'Password reset link generated. Copy it below.')
                ->with('reset_link', $resetLink);
        }
    }

    public function showResetForm(Request $request, string $token)
    {
        $email = (string) $request->query('email', '');
        if (!$this->isValidToken($email, $token)) {
            return redirect()->route('password.request')->with('error', 'Invalid or expired reset link.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!$this->isValidToken($request->email, $request->token)) {
            return redirect()->route('password.request')->with('error', 'Invalid or expired reset link.');
        }

        $user = User::where('Email', $request->email)->first();
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'No account found for that email address.');
        }

        $user->update([
            'Password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully. You can now login.');
    }

    private function isValidToken(string $email, string $token): bool
    {
        if ($email === '' || $token === '') {
            return false;
        }

        $row = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (!$row) {
            return false;
        }

        if (!Hash::check($token, $row->token)) {
            return false;
        }

        return now()->diffInMinutes($row->created_at) <= $this->tokenExpiryMinutes;
    }
}
