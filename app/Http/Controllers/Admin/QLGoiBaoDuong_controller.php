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


    // Sửa gói
    function edit($id)
    {
        $service = new QL();
        $goi = $service->lay_goi_id($id);

        return view('admin.layouts.index_AD', [
            'goi' => $goi,
            'key' => 'edit_goi_bao_duong'
        ]);
    }

    // Cập nhật
    function update(Request $request, $id)
    {
        $service = new QL();

        $service->update_goi(
            $id,
            $request->ten_goi,
            $request->mo_ta,
            $request->gia
        );

        return redirect('/trang_admin/goibaoduong')
            ->with('success','Cập nhật thành công');
    }




    // Xóa gói
 public function xoa_goi($id)
{
    $service = new QL(); // Khởi tạo service

    // Gọi hàm thực hiện xóa (đã đổi tên để tránh trùng lặp gây đệ quy)
    $ket_qua = $service->thuc_hien_xoa($id);

    if (!$ket_qua) {
        return redirect()->back()->with('error', 'Có xe đang sử dụng gói này, không thể xóa!');
    }

    return redirect('/trang_admin/goibaoduong')
        ->with('success', 'Xóa gói bảo dưỡng thành công');
}

}