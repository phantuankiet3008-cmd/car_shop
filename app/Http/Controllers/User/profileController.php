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

        $User = new User();
        $khachhang = $User->laykhachhangtheosdt($SDT);

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

        $User = new User();
        $khachhang = $User->laykhachhangtheosdt($SDT);

        $id_khachhang = $khachhang['id_Khach_Hang'];
        $Avatar = $khachhang['avatar'];

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $Avatar = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('upload/avatar'), $Avatar);
        }

        $res = $User->capnhat_thong_tin_khach_hang(
            $id_khachhang,
            $request->TenKH,
            $request->Email,
            $request->DiaChi,
            $khachhang['So_Dien_Thoai'],
            $Avatar,
            null
        );

        if ($res) {
            return redirect()->route('profile')
                ->with('msg', 'Cập nhật thành công!');
        }

        return back()->with('msg', 'Cập nhật thất bại!');
    }
}