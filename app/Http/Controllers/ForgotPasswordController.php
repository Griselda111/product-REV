<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    // STEP 1 - SEND RESET LINK
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar'
            ]);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $link = route('password.reset.form', $token);

        Mail::to($user->email)->send(
            new ResetPasswordMail($link)
        );

        return back()->with(
            'success',
            'Link reset password telah dikirim ke email.'
        );
    }

    // STEP 2 - SHOW RESET PASSWORD FORM
    public function showResetForm($token)
    {
        $data = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$data) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'token' => 'Link reset tidak valid atau kadaluarsa'
                ]);
        }

        // TOKEN EXPIRED 15 MENIT
        if (Carbon::parse($data->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('token', $token)
                ->delete();

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'token' => 'Link reset sudah kadaluarsa'
                ]);
        }

        return view('PassReset.resetpassword', [
            'token' => $token
        ]);
    }

    // STEP 3 - UPDATE PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $data = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$data) {
            return back()->withErrors([
                'token' => 'Token tidak valid'
            ]);
        }

        $user = User::where('email', $data->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $data->email)
            ->delete();

        $targetRoute = $user->role == 2 ? 'admin.login' : 'login';

        return redirect()
            ->route($targetRoute)
            ->with('success', 'Password berhasil direset.');
    }
}
