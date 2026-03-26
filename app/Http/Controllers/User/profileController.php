<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class profileController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new User();
    }

    public function index()
    {
        $SDT = session('SDT');

        if (empty($SDT)) {
            return redirect('/car_shop/dangnhap');
        }

        $khachhang = $this->userService->laykhachhangtheosdt($SDT);

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

        $khachhang = $this->userService->laykhachhangtheosdt($SDT);

        if (!$khachhang) {
            return back()->with('msg', 'Không tìm thấy khách hàng');
        }

        // Gửi toàn bộ dữ liệu và file ($_FILES) sang Model xử lý
        $res = $this->userService->capnhat_thong_tin_khach_hang(
            $khachhang['id_Khach_Hang'],
            $request->TenKH ?? $khachhang['Ho_Ten'],
            $request->Email ?? $khachhang['Email'],
            $request->DiaChi ?? $khachhang['Dia_Chi'],
            $khachhang['So_Dien_Thoai'],
            $_FILES // Model sẽ tự check key 'avatar' trong mảng này
        );

        if ($res) {
            return redirect()->route('profile')->with('msg', 'Cập nhật thành công!');
        }

        return back()->with('msg', 'Cập nhật thất bại!');
    }
}