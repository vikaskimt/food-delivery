<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(protected OtpService $otpService) {}

    // POST /api/auth/send-otp  { phone }
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'min:10', 'max:15'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->otpService->generateAndSend($request->phone);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    // POST /api/auth/verify-otp  { phone, code }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (! $this->otpService->verify($request->phone, $request->code)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            ['phone_verified_at' => now()]
        );

        if (! $user->phone_verified_at) {
            $user->update(['phone_verified_at' => now()]);
        }

        $token = $user->createToken('customer-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    // GET /api/me
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // POST /api/auth/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
