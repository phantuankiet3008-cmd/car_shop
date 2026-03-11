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
            return redirect('/car_shop/dangnhap');
        }

        $User = new User();   

        $khachhang = $User->laykhachhangtheosdt($SDT);

        if (!$khachhang) {
            abort(404, 'Không tìm thấy khách hàng');
        }

        return view('user.layouts.trangcanhan', compact('khachhang'));
    }
}