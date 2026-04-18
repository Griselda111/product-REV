<?php
namespace App\Http\Controllers;

use App\Services\OtpService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(Request $request)
    {
        if (!session()->has('otp_email')) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Invalid OTP resend flow']);
        }

        $email = session('otp_email');

        $otp = $this->otpService->generateOtp($email, 'email');
        $this->otpService->sendOtp($email, $otp, 'email');

        return back()->with('success', 'New OTP has been sent to your email.');
    }

    public function verifyOtpweb(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);
        // proteksi flow
        if (!session()->has('otp_email')) {
            return redirect()
                ->route('register')
                ->withErrors(['otp_code' => 'Invalid verification flow']);
        }

        $email = session('otp_email');

        $isValid = $this->otpService->validateOtp(
            $email,
            $request->otp_code,
            'email'
        );

        if (!$isValid) {
            return back()->withErrors([
                'otp_code' => 'Invalid or expired OTP'
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('register')
                ->withErrors(['otp_code' => 'User not found']);
        }

        // verifikasi user
        $user->is_verified = true;
        $user->save();

        // bersihkan session OTP
        session()->forget('otp_email');

        // ✅ REDIRECT KE LOGIN
        return redirect()
            ->route('login')
            ->with('success', 'OTP verified successfully. Please login.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        if (!session()->has('otp_email')) {
            return response()->json(['message' => 'Invalid verification flow'], 403);
        }

        $email = session('otp_email');

        $isValid = $this->otpService->validateOtp($email, $request->otp_code, 'email');

        if ($isValid) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->is_verified = true;
            $user->save();

            session()->forget('otp_email');

            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid or expired OTP'], 400);
    }
}