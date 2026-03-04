<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;


class DangNhap_controller extends Controller {

    public function showLogin()
    {
        return view('user.layouts.DangNhap');
    }

    public function dangnhap(Request $request)
{
    $request->validate([
        'SDT' => 'required',
        'MatKhau' => 'required'
    ]);

    $service = new User();

    $user = $service->dangnhap(
        $request->SDT,
        $request->MatKhau
    );

    if ($user) {
            session([
    'user_id' => $user->id_Khach_Hang,
    'user_name' => $user->Ho_Ten,
    'SDT' => $user->So_Dien_Thoai
]);

        return redirect('/user/car_shop/trangcanhan');
    }

    return back()->with('error', 'Sai số điện thoại hoặc mật khẩu');
}}