<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User;

class donhangController extends Controller
{
    public function donCuaToi()
    {
        $user = new User();

        $idKhach = session('user_id');

        if (!$idKhach) {
            return redirect('car_shop/dangnhap')
                ->with('error', 'Vui lòng đăng nhập.');
        }

        $donHang = $user->don_hang_cua_toi($idKhach);

        return view('user.layouts.donhangcuaban', [
            'don_hang' => $donHang
        ]);
    }
}