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
            return redirect('/login');
        }

        $userService = new User();
        $khachhang = $userService->laykhachhangtheoid($SDT);

        if (!$khachhang) {
            abort(404, 'Không tìm thấy khách hàng');
        }

        return view('profile', compact('khachhang'));
    }

    public function update(Request $request)
    {
        $SDT = session('SDT');

        if (empty($SDT)) {
            return redirect('/login');
        }

        $userService = new User();
        $khachhang = $userService->laykhachhangtheoid($SDT);

        $id_khachhang = $khachhang['id_Khach_Hang'];

        $avatar = $khachhang['Avatar'];

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatar = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('upload/avatar'), $avatar);
        }

        $res = $userService->capnhat_thong_tin_khach_hang(
            $id_khachhang,
            $request->TenKH,
            $request->Email,
            $request->DiaChi,
            $khachhang['So_Dien_Thoai'],
            $avatar,
            null
        );

        if ($res) {
            return redirect()->route('profile')
                ->with('msg', 'Cập nhật thành công!');
        }

        return back()->with('msg', 'Cập nhật thất bại!');
    }
}