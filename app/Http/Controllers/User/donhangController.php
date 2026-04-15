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
    function thanhtoanlai ($id){
        $service = new User();
        $don = $service->lay_don($id);
        $id_kh = session('user_id');
        if(!$don){
            return redirect()->back()->with('error','Đơn hàng không tồn tại');
        }

        if($don->id_Khach_Hang != $id_kh){
            abort(403);
        }
        $xe = $service->lay_xe_mau($don->id_Xe_Mau);
        $khach = $service->lay_khach_hang($id_kh);

        return view('user.layouts.Checkout', compact('don','xe','khach'));
    
    }
}