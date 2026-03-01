<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QuenMK_controller extends Controller{

public function capNhatMK(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('So_Dien_Thoai', $request->phone)->first();

    if (!$user) {
        return back()->with('error', 'Không tìm thấy tài khoản');
    }

    $user->Mat_Khau = Hash::make($request->password);
    $user->save();

    session()->forget('xac_minh_otp');

    return redirect()->route('login.form')
        ->with('success', 'Cập nhật mật khẩu thành công');
}

function formCapNhatMK(Request $request)
{
    if (!session('xac_minh_otp')) {
        return redirect()->route('forgot.form');
    }

    return view('user.layouts.CapNhatMK', [
        'phone' => $request->phone
    ]);
}
}