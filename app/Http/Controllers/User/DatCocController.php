<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;
use App\Services\Product;
class DatCocController extends Controller
{
    public function datcoc(Request $request){
    $id = $request->id_xe_mau;

    $id_kh = session('user_id');

    $sp = new Product();
    $service = new User();
$checksoluong = $sp->kiemtraxedo($id);
    if($checksoluong && $checksoluong->num_rows <=0){
        return back()->with('error','màu xe bạn chọn này đã bán hết hãy chọn lại xe khác');
    }
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
        return back()->with('error','Xe màu này đã hết lượt đặt cọc vì đã có người đặt cọc');
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
    public function taoDon(Request $request)
{
    $id_kh = session('user_id');

    if(!$id_kh){
        return back()->with('error','Bạn chưa đăng nhập');
    }

    $service = new User();

    // 👉 gọi service xử lý hết
    $id_don = $service->tao_don_dat_coc(
        $id_kh,
        $request->id_xe_mau
    );

    if(!$id_don){
        return back()->with('error','Không thể tạo đơn');
    }

    // 👉 chuyển sang checkout
    return redirect()->route('checkout', $id_don);
}
    
}