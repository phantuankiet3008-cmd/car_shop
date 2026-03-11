<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class DatCocController extends Controller
{
    public function datcoc($id){

    $id = (int)$id;

    $id_kh = session('user_id');

    
    $service = new User();

    // Lấy thông tin xe
    $xe = $service->lay_xe_mau($id);

    if(!$xe){
        return back()->with('error','Xe không tồn tại');
    }

    // Lấy khách hàng
    $khach = $service->lay_khach_hang($id_kh);

    // Đếm đơn chờ duyệt
    $don = $service->dem_don_cho_duyet($id);

    if($xe['So_Luong'] <= $don){
        return back()->with('error','Xe màu này đã hết lượt đặt cọc');
    }

    // ======================
    // TÍNH GIÁ
    // ======================

    $gia = $xe['Gia'];

    // Lấy ưu đãi giống trang chi tiết
    $uu_dai = $service->uu_dai_cua_xe($id);

    $max_giam = 0;

    foreach($uu_dai as $ud){

        $giam = 0;

        if($ud['Loai'] == 'phan_tram'){
            $giam = $gia * $ud['Gia_Tri'] / 100;
        }

        if($ud['Loai'] == 'tien'){
            $giam = $ud['Gia_Tri'];
        }

        if($giam > $max_giam){
            $max_giam = $giam;
        }
    }

    $tong = $gia - $max_giam;

    if($tong < 0){
        $tong = 0;
    }

    $tien_coc = $tong * 0.01;

    return view('user.layouts.Dat_coc',[
        'xe'=>$xe,
        'khach'=>$khach,
        'gia'=>$gia,
        'giam'=>$max_giam,
        'tong'=>$tong,
        'tien_coc'=>$tien_coc
    ]);
}
}