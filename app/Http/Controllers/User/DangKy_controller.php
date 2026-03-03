<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class DangKy_controller extends Controller {
    public function showRegister()
    {
        return view('user.layouts.DangKy');
    }

    public function dangky(Request $request)
{
    if (!session('xac_minh_otp')) {
        return back()->with('error', 'Vui lòng xác minh OTP trước');
    }

    // Validate dữ liệu
    $request->validate([
        'HoTen' => 'required',
        'DiaChi'=> 'required',
        'SDT' => 'required',
        'email' => 'required|email',
        'MatKhau' => 'required|min:6'
    ]);

    $service = new User();

    $result = $service->dang_ky(
        $request->HoTen,
        $request->DiaChi,
        $request->SDT,
        $request->email,
        $request->MatKhau
    );

    if (!$result) {
        return back()->with('error', 'Số điện thoại đã tồn tại');
    }

    session()->forget('xac_minh_otp');

    return redirect('/car_shop/dangnhap')
            ->with('success', 'Đăng ký thành công');
}}