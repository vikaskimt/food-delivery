<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public function generateAndSend(string $phone): Otp
    {
        $code = (string) random_int(
            (int) str_pad('1', config('services.otp.length', 4), '0'),
            (int) str_pad('9', config('services.otp.length', 4), '9')
        );

        // Invalidate previous unused OTPs for this phone
        Otp::where('phone', $phone)->where('is_used', false)->update(['is_used' => true]);

        $otp = Otp::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes(config('services.otp.expiry_minutes', 5)),
        ]);

        $this->send($phone, $code);

        return $otp;
    }

    protected function send(string $phone, string $code): void
    {
        $provider = config('services.sms.provider', 'log');

        // Swap this out per provider (Twilio / MSG91 / Fast2SMS) — keep the
        // rest of the app decoupled from the SMS vendor.
        match ($provider) {
            'log' => Log::info("OTP for {$phone}: {$code}"),
            default => Log::info("[{$provider}] OTP for {$phone}: {$code}"),
        };
    }

    public function verify(string $phone, string $code): bool
    {
        $otp = Otp::where('phone', $phone)
            ->where('code', $code)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (! $otp || $otp->isExpired()) {
            return false;
        }

        $otp->update(['is_used' => true]);

        return true;
    }
}
