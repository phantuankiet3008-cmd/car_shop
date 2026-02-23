<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class SanPhamController extends Controller
{
    // Danh sách sản phẩm xe
function index()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'san_pham',
        'data' => [
            // ÉP về array
            'danh_sach' => $ql->DanhSach_SanPham()
        ]
    ]);
}

public function create()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'Add_San_Pham',
        'data' => [
            'ds_loai'        => $ql->DS_Loai_Xe(),
            'ds_thuong_hieu' => $ql->DS_Thuong_Hieu_Xe(),
            'ds_mau'         => $ql->List_MauXe(),
        ]
    ]);
}
public function store(Request $request)
{
    $request->validate([
        'ten_xe' => 'required',
        'mo_ta' => 'required',
        'loai_xe' => 'required',
        'thuong_hieu' => 'required',
        'anh_dai_dien' => 'required|image'
    ]);

    $ql = new QL();

    // ❌ KHÔNG move file ở đây
    $anh_dai_dien = time().'_'.$request->file('anh_dai_dien')->getClientOriginalName();

    $anh_3d = null;
    if ($request->hasFile('anh_3d')) {
        $anh_3d = time().'_'.$request->file('anh_3d')->getClientOriginalName();
    }

    $ql->Add_SanPham(
        $request->ten_xe,
        $request->mo_ta,
        $anh_dai_dien,
        $anh_3d,
        $request->all(),
        $_FILES
    );

    return redirect('/trang_admin/san_pham');
}
public function edit($id)
{
    $ql = new QL();

    $xe = $ql->Get_ChiTietXe($id);
    if (!$xe) {
        return redirect('/trang_admin/san_pham')
            ->with('error', 'Sản phẩm không tồn tại');
    }

    return view('admin.layouts.index_AD', [
        'key' => 'Edit_San_Pham',
        'data' => [
            'xe' => $xe,
            'list_anh_mau' => $ql->Get_AnhTheoMau($id),
            'ds_mau' => $ql->Get_Mau_Theo_Xe($id),
            'List_Loai' => $ql->DS_Loai_Xe(),
            'List_ThuongHieu' => $ql->DS_Thuong_Hieu_Xe(),
        ]
    ]);
}
public function update(Request $request, $id)
{
    $ql = new QL();

    $ok = $ql->Update_SanPham($id, $request->all(), $_FILES);

    if ($ok) {
        return redirect('/trang_admin/san_pham')
            ->with('success', 'Cập nhật sản phẩm thành công');
    }

    return back()->with('error', 'Có lỗi khi cập nhật');
}

public function destroy($id)
{
    $ql = new QL();

    $ok = $ql->Delete_SanPham($id); // hàm xóa cũ của bạn

    if ($ok) {
        return redirect('/trang_admin/san_pham')
            ->with('success', 'Xóa sản phẩm thành công');
    }

    return redirect('/trang_admin/san_pham')
        ->with('error', 'Xóa sản phẩm thất bại');
}


}
