<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class QuenMK_controller extends Controller
{
    public function CapNhatMK(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $service = new User();

        $user = $service->update_mk(
            $request->phone,
            $request->password
        );

        if ($user) {

            session()->forget('xac_minh_otp');

            return redirect()->route('dangnhap')
                ->with('success', 'Cập nhật mật khẩu thành công');
        }

        return back()->with('error', 'Không tìm thấy tài khoản');
    }

    public function formCapNhatMK(Request $request)
    {
        if (!session('xac_minh_otp')) {
            return redirect()->route('quenmk');
        }

        return view('user.layouts.CapNhatMK', [
            'phone' => $request->phone
        ]);
    }
}