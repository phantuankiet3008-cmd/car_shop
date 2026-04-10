<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class BaoDuong_controller extends Controller
{
    function trang_baoduong()
    {
        $service = new User();
        $idkhachhang = session('user_id');

        $listxekhach = $service->lay_xe_khach($idkhachhang);

        $goi = $service->chongoi_baoduong();

        return view('user.layouts.BaoDuong', [
            'ds_xe' => $listxekhach,
            'goi_bao_duong' => $goi
        ]);
    }



function datlich_BaoDuong(Request $request)
{
    // 1. Validate dữ liệu
    $request->validate([
        'id_xe' => 'required', // Tên đúng theo thuộc tính 'name' trong Blade
        'id_goi' => 'required',
        'ngay_bao_duong' => 'required|date'
    ]);

    $service = new User();

    // 2. Kiểm tra số lượng lịch trong ngày
    $soLuong = $service->dem_lich_trong_ngay($request->ngay_bao_duong);

    if ($soLuong >= 10) { 
        return back()->with('error', 'Ngày này đã hết slot, vui lòng chọn ngày khác.');
    }

    // 3. Gọi Service để lưu (Lưu ý: dùng $request->id_xe thay vì id_Xe_Mau)
    $result = $service->datlich_BaoDuong(
        session('user_id'),
        $request->id_xe,      // SỬA TẠI ĐÂY: Lấy đúng name="id_xe" từ form
        $request->id_goi,
        $request->ngay_bao_duong,
        $request->ghi_chu ?? '' // Tránh gửi null vào db
    );

    if($result) {
        return back()->with('success', 'Đặt lịch bảo dưỡng thành công!');
    } else {
        return back()->with('error', 'Có lỗi xảy ra trong quá trình lưu dữ liệu.');
    }
}



function lichbaoduongcuatoi()
{
    $service = new User();
    $idkhachhang = session('user_id');

    $data = $service->lay_lich_bao_duong($idkhachhang);

    return view('user.layouts.LichBaoDuong', [
        'danh_sach' => $data
    ]);
}

function huyBaoDuong($id)
{
    $service = new User();
    $userId = session('user_id');

    $result = $service->huy_lich_bao_duong($id, $userId);

    if ($result) {
        return back()->with('success', 'Hủy lịch thành công!');
    } else {
        return back()->with('error', 'Không thể hủy lịch.');
    }
}
    }