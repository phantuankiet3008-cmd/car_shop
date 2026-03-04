<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class lichlaythuController extends Controller
{
public function index(Request $request)
{
    $ql = new QL();

    $ngay = $request->ngay;
    $idXe = $request->id_xe;
    $trangThai = $request->trang_thai;
    $tenKhach = $request->ten_khach;

    $danhSach = $ql->DanhSach_LaiThu($ngay, $idXe, $trangThai, $tenKhach);

    return view('admin.layouts.index_AD', [
        'key' => 'lai_thu',
        'data' => [
            'danh_sach' => $danhSach
        ]
    ]);
}
public function capNhatTrangThai($id, $trangThai)
{
    $ql = new QL();
    $ql->CapNhatTrangThai_LaiThu($id, $trangThai);

    return redirect('/trang_admin/lai_thu')
        ->with('success', 'Cập nhật trạng thái thành công!');
}
public function xoa($id)
{
    $ql = new QL();
    $ql->Xoa_LaiThu($id);

    return redirect('/trang_admin/lai_thu')
        ->with('success', 'Xóa lịch thành công!');
}

}