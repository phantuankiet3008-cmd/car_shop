<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class ThuongHieuXeController extends Controller
{
    protected $ql;

    public function __construct()
    {
        $this->ql = new QL();
    }

    // Danh sách thương hiệu xe
    public function index()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'thuong_hieu',
            'data' => [
                'danh_sach' => $this->ql->DS_Thuong_Hieu_Xe()
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

    // Form sửa
    public function edit($id)
    {
        $thuong_hieu = $this->ql->Lay_Thuong_Hieu_Xe_Theo_ID($id);
        if (!$thuong_hieu) abort(404);

        return view('admin.layouts.index_AD', [
            'key' => 'Edit_Thuong_Hieu',
            'data' => [
                'thuong_hieu' => $thuong_hieu
            ]
        ]);
    }

    // Xử lý thêm
    public function store(Request $request)
    {
        $request->validate([
            'ten_th' => 'required',
            'ma_th' => 'required'
        ]);

        // Model QL sẽ tự xử lý upload lên Cloudinary từ $_FILES
        $this->ql->Them_Thuong_Hieu_Xe(
            $request->ten_th,
            $request->ma_th,
            $request->trang_thai,
            $_FILES 
        );

        return redirect('/trang_admin/thuong_hieu');
    }

    // Xử lý sửa
    public function update(Request $request, $id)
    {
        // Model tự check ảnh cũ để xóa và upload ảnh mới
        $this->ql->Cap_Nhat_Thuong_Hieu_Xe_V2(
            $id,
            $request->ten_thuong_hieu,
            $request->ma_thuong_hieu,
            $request->trang_thai,
            $_FILES
        );

        return redirect('/trang_admin/thuong_hieu');
    }

    // Xử lý xóa
    public function destroy($id)
    {
        // Model tự xóa ảnh trên Cloud trước khi xóa trong DB
        $this->ql->Xoa_Thuong_Hieu_Xe($id);

        return redirect('/trang_admin/thuong_hieu');
    }
}