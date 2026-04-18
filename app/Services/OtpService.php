<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OtpService
{
    public function generateOtp($identifier, $type = 'email')
    {
        $otp = random_int(100000, 999999); // Lebih aman dibandingkan rand()
        $expiresAt = now()->addMinutes(5);

        DB::table('otp_codes')->updateOrInsert(
            [$type => $identifier],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );
        return $otp;
    }

    public function sendOtp($identifier, $otp, $type = 'email')
    {
        if ($type === 'email') {
            \Log::info("Sending OTP to $identifier: $otp");
            Mail::to($identifier)->send(new \App\Mail\OtpMail($otp));
        }
    }

    public function validateOtp($identifier, $otp, $type = 'email')
    {
        $record = DB::table('otp_codes')
            ->where($type, $identifier)
            ->where('otp', $otp)
            ->where('expires_at', '>', now())
            ->first();
        if ($record) {
            DB::table('otp_codes')->where('id', $record->id)->delete(); // Hapus OTP setelah validasi
            return true;
        }
        return false;
    }
}