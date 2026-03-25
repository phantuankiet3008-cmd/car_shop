<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class LoaiXeController extends Controller
{
    protected $ql;

    public function __construct()
    {
        $this->ql = new QL();
    }
public function index()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'loai_xe',
            'data' => [
                'danh_sach' => $this->ql->DS_Loai_Xe()
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

    // Form sửa
    public function edit($id)
    {
        $loai_xe = $this->ql->Lay_Loai_Xe_Theo_ID($id);

        if (!$loai_xe) abort(404);

        return view('admin.layouts.index_AD', [
            'key' => 'Edit_Loai_Xe',
            'data' => [
                'loai_xe' => $loai_xe
            ]
        ]);
    }
    // Xử lý thêm
    public function store(Request $request)
    {
        $request->validate([
            'ten_loai' => 'required'
        ]);

        // Truyền thẳng $_FILES sang Model, Model tự lo upload
        $this->ql->Them_Loai_Xe(
            $request->ten_loai,
            $request->slug,
            $request->mo_ta,
            $request->trang_thai,
            $_FILES // Model sẽ tự check key 'hinh_anh' trong này
        );

        return redirect('/trang_admin/loai_xe');
    }

    // Xử lý sửa
    public function update(Request $request, $id)
    {
        $this->ql->Cap_Nhat_Loai_Xe(
            $id,
            $request->ten_loai,
            $request->slug,
            $request->mo_ta,
            $request->trang_thai,
            $_FILES // Model tự so sánh ảnh cũ/mới
        );

        return redirect('/trang_admin/loai_xe');
    }

    // Xử lý xóa
    public function destroy($id)
    {
        // Model tự xóa ảnh trên Cloud rồi mới xóa DB
        $this->ql->Xoa_Loai_Xe($id);

        return redirect('/trang_admin/loai_xe');
    }
    
    // ... các hàm index, create, edit giữ nguyên ...
}