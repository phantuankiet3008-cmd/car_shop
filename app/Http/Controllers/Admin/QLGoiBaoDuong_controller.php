<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class QLGoiBaoDuong_controller extends Controller
{

    // Danh sách gói bảo dưỡng
    function index(Request $request)
    {
        $service = new QL();

        $data = $service->danh_sach_goi();


    $service = new QL();

    $goibaoduong = $service->danh_sach_goi();

    return view('admin.layouts.index_AD', [
        'goibaoduong' => $goibaoduong,
        'key' => 'goi_bao_duong'
    ]);

    }

    // Thêm gói
    function them_goi(Request $request)
{
    $service = new QL();

    $service->them_goi(
        $request->ten_goi,
        $request->mo_ta,
        $request->gia
    );

    return redirect('/trang_admin/goibaoduong')
        ->with('success','Thêm gói bảo dưỡng thành công');
}

    // Xóa gói
    function xoa_goi($id)
{
    $service = new QL();

    $service->xoa_goi($id);

    return redirect('/trang_admin/goibaoduong')
        ->with('success','Xóa gói bảo dưỡng thành công');
}

}