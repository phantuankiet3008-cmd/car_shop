<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class otp_controller extends Controller
{
    // Gửi OTP
    public function guiotp(Request $request){
    $request->validate([
        'phone' => 'required'
    ]);

    $otp = rand(100000, 999999);

    session([
        'otp' => $otp,
        'otp_expire' => now()->addMinutes(5)
    ]);

    // Gọi API giả lập SMS
    $response = Http::post(
        'http://localhost/do_an_cntt_nhom_10/api/api_sms/gia_lap_sms_api.php',
        [
            "phone" => $request->phone,
            "message" => "Ma OTP cua ban la $otp"
        ]
    );

    return response()->json([
        "status" => "success",
        "message" => "OTP đã được gửi thành công",
        "otp" => $otp // để test, sau này xoá
    ]);
}
    

    // Xác minh OTP
    public function xacminhotp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if (!session('otp')) {
            return response()->json(["message" => "Chưa gửi OTP"], 400);
        }

        if (now()->gt(session('otp_expire'))) {
            return response()->json(["message" => "OTP hết hạn"], 400);
        }

        if ($request->otp == session('otp')) {

            session()->forget(['otp', 'otp_expire']);
            session(['xac_minh_otp' => true]);

            return response()->json(["message" => "Xác minh thành công"]);
        }

        return response()->json(["message" => "OTP sai"], 400);
    }
}