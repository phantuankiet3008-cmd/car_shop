<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class ThuongHieuXeController extends Controller
{
    // Danh sách thương hiệu xe
    public function index()
    {
        $ql = new QL();

        return view('admin.layouts.index_AD', [
    'key' => 'thuong_hieu',
    'data' => [
        'danh_sach' => $ql->DS_Thuong_Hieu_Xe()
    ]
]);

    }

    // Form thêm
    public function create()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'Add_Thuong_Hieu'
        ]);
    }

    // Xử lý thêm
    public function store(Request $request)
    {
        $request->validate([
    'ten_th' => 'required',
    'ma_th' => 'required',
    'hinh_anh' => 'nullable|image'
]);

        $ql = new QL();

        $hinh_anh = '';
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $hinh_anh = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/anh_logo'), $hinh_anh);
        }

        $ql->Them_Thuong_Hieu_Xe(
            $request->ten_th,
            $request->ma_th,
            $hinh_anh,
            $request->trang_thai
        );

        return redirect('/trang_admin/thuong_hieu');
    }
    // Form sửa
public function edit($id)
{
    $ql = new QL();
    $thuong_hieu = $ql->Lay_Thuong_Hieu_Xe_Theo_ID($id);

    if (!$thuong_hieu) {
        abort(404);
    }

    return view('admin.layouts.index_AD', [
        'key' => 'Edit_Thuong_Hieu',
        'data' => [
            'thuong_hieu' => $thuong_hieu
        ]
    ]);
}
// Xử lý sửa
public function update(Request $request, $id)
{
    $ql = new QL();
    $thuong_hieu = $ql->Lay_Thuong_Hieu_Xe_Theo_ID($id);

    if (!$thuong_hieu) {
        abort(404);
    }

    $hinh_anh = $thuong_hieu['Logo'];

    if ($request->hasFile('hinh_anh')) {
        $file = $request->file('hinh_anh');
        $hinh_anh = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/anh_logo'), $hinh_anh);
    }

    $ql->Cap_Nhat_Thuong_Hieu_Xe(
        $id,
        $request->ten_thuong_hieu,
        $request->ma_thuong_hieu,
        $hinh_anh,
        $request->trang_thai
    );

    return redirect('/trang_admin/thuong_hieu');
}
// Xử lý xóa
public function destroy($id)
{
    $ql = new QL();
    $thuong_hieu = $ql->Lay_Thuong_Hieu_Xe_Theo_ID($id);

    if (!$thuong_hieu) {
        abort(404);
    }

    $ql->Xoa_Thuong_Hieu_Xe($id);

    return redirect('/trang_admin/thuong_hieu');

}
}
