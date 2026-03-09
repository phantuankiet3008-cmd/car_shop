<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class profileController extends Controller
{
    public function index()
    {
        $SDT = session('SDT');

        if (empty($SDT)) {
            return redirect('/car_shop/dangnhap');
        }

        $userService = new User();
        $khachhang = $userService->laykhachhangtheosdt($SDT);

        if (!$khachhang) {
            abort(404, 'Không tìm thấy khách hàng');
        }

        return view('user.layouts.profile', compact('khachhang'));
    }

    public function update(Request $request)
    {
        $SDT = session('SDT');

        if (empty($SDT)) {
            return redirect('/car_shop/dangnhap');
        }

        $userService = new User();
        $khachhang = $userService->laykhachhangtheosdt($SDT);

        if (!$khachhang) {
            return back()->with('msg', 'Không tìm thấy khách hàng');
        }

       $id_khachhang = $khachhang['id_Khach_Hang'];

// ===== GIỮ AVATAR CŨ =====
$avatar = $khachhang['Avatar'] ?? null;

// ===== UPLOAD AVATAR MỚI =====
if ($request->hasFile('avatar')) {

    $file = $request->file('avatar');

    $avatar = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('upload/avatar'), $avatar);
}

// ===== CẬP NHẬT DATABASE =====
$res = $userService->capnhat_thong_tin_khach_hang(
    $id_khachhang,
    $request->TenKH ?? $khachhang['Ho_Ten'],
    $request->Email ?? $khachhang['Email'],
    $request->DiaChi ?? $khachhang['Dia_Chi'],
    $khachhang['So_Dien_Thoai'],
    $avatar
);

        if ($res) {
            return redirect()->route('profile')->with('msg', 'Cập nhật thành công!');
        }

        return back()->with('msg', 'Cập nhật thất bại!');
    }
}