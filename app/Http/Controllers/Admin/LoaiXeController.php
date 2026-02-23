<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class LoaiXeController extends Controller
{
    // Danh sách loại xe
    public function index()
    {
        $ql = new QL();

        return view('admin.layouts.index_AD', [
            'key' => 'loai_xe',
            'data' => [
                'danh_sach' => $ql->DS_Loai_Xe()
            ]
        ]);
    }

    // Form thêm
    public function create()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'Add_Loai_Xe'
        ]);
    }

    // Xử lý thêm
    public function store(Request $request)
    {
        $request->validate([
    'ten_loai' => 'required',
    'hinh_anh' => 'nullable|image'
]);

        $ql = new QL();

        $hinh_anh = '';
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $hinh_anh = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/anh_loai'), $hinh_anh);
        }

        $ql->Them_Loai_Xe(
            $request->ten_loai,
            $request->slug,
            $request->mo_ta,
            $hinh_anh,
            $request->trang_thai
        );

        return redirect('/trang_admin/loai_xe');
    }
    // Form sửa
public function edit($id)
{
    $ql = new QL();
    $loai_xe = $ql->Lay_Loai_Xe_Theo_ID($id);

    if (!$loai_xe) {
        abort(404);
    }

    return view('admin.layouts.index_AD', [
        'key' => 'Edit_Loai_Xe',
        'data' => [
            'loai_xe' => $loai_xe
        ]
    ]);
}
// Xử lý sửa
public function update(Request $request, $id)
{
    $ql = new QL();
    $loai_xe = $ql->Lay_Loai_Xe_Theo_ID($id);

    if (!$loai_xe) {
        abort(404);
    }

    $hinh_anh = $loai_xe['Hinh_Anh_Loai'];

    if ($request->hasFile('hinh_anh')) {
        $file = $request->file('hinh_anh');
        $hinh_anh = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/anh_loai'), $hinh_anh);
    }

    $ql->Cap_Nhat_Loai_Xe(
        $id,
        $request->ten_loai,
        $request->slug,
        $request->mo_ta,
        $hinh_anh,
        $request->trang_thai
    );

    return redirect('/trang_admin/loai_xe');
}
// Xử lý xóa
public function destroy($id)
{
    $ql = new QL();
    $loai_xe = $ql->Lay_Loai_Xe_Theo_ID($id);

    if (!$loai_xe) {
        abort(404);
    }

    $ql->Xoa_Loai_Xe($id);

    return redirect('/trang_admin/loai_xe');

}
}
