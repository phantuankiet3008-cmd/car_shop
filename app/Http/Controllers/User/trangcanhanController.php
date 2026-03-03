<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User;

class trangcanhanController extends Controller
{
    public function index()
    {
        $SDT = session('SDT');

        if (empty($SDT)) {
            return redirect('/login');
        }

        $user = new User();   

        $khachhang = $user->laykhachhangtheoid($SDT);

        if (!$khachhang) {
            abort(404, 'Không tìm thấy khách hàng');
        }

        return view('thanhvien', compact('khachhang'));
    }
}