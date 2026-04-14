<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;
 // Import Service upload

class SanPhamController extends Controller
{
    protected $ql;
   

    public function __construct()
    {
        $this->ql = new QL();
       
    }

    // Danh sách sản phẩm xe
   public function index(Request $request)
{
    // Lấy dữ liệu lọc từ URL
    $filters = [
        'ten'         => $request->input('search_ten'),
        'id_loai'     => $request->input('search_loai'),
        'id_thương_hieu' => $request->input('search_thuong_hieu'),
    ];

    return view('admin.layouts.index_AD', [
        'key' => 'san_pham',
        'data' => [
            // Truyền mảng filters vào Model
            'danh_sach'      => $this->ql->DanhSach_SanPham($filters), 
            'ds_loai'        => $this->ql->DS_Loai_Xe(),
            'ds_thuong_hieu' => $this->ql->DS_Thuong_Hieu_Xe()
        ]
    ]);
}

    public function create()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'Add_San_Pham',
            'data' => [
                'ds_loai'        => $this->ql->DS_Loai_Xe(),
                'ds_thuong_hieu' => $this->ql->DS_Thuong_Hieu_Xe(),
                'ds_mau'         => $this->ql->List_MauXe(),
            ]
        ]);
    }

    public function store(Request $request)
{
    // Validate cơ bản
    $request->validate(['ten_xe' => 'required', 'loai_xe' => 'required']);

    // Chỉ cần gọi 1 dòng, Model sẽ tự lo việc upload ảnh lên Cloud
    $this->ql->Add_SanPham(
        $request->ten_xe,
        $request->mo_ta,
        $request->all(),
        $_FILES // Truyền nguyên cục files sang Model
    );

    return redirect('/trang_admin/san_pham');
}

    public function edit($id)
    {
        $xe = $this->ql->Get_ChiTietXe($id);
        if (!$xe) {
            return redirect('/trang_admin/san_pham')->with('error', 'Sản phẩm không tồn tại');
        }

        return view('admin.layouts.index_AD', [
            'key' => 'Edit_San_Pham',
            'data' => [
                'xe' => $xe,
                'list_anh_mau' => $this->ql->Get_AnhTheoMau($id),
                'ds_mau' => $this->ql->Get_Mau_Theo_Xe($id),
                'List_Loai' => $this->ql->DS_Loai_Xe(),
                'List_ThuongHieu' => $this->ql->DS_Thuong_Hieu_Xe(),
                'ds_mau_xe'         => $this->ql->List_MauXe(),
            ]
        ]);
    }

   public function update(Request $request, $id)
{
    // Không cần truyền $_FILES nữa vì ảnh đã lên Cloud từ lúc ở trình duyệt
    $ok = $this->ql->Update_SanPham($id, $request->all()); 

    if ($ok) {
        return redirect('/trang_admin/san_pham')->with('success', 'Cập nhật thành công');
    }
    return back()->with('error', 'Có lỗi xảy ra');
}

    public function destroy($id)
    {
        $ok = $this->ql->Delete_SanPham($id);
        if ($ok) {
            return redirect('/trang_admin/san_pham')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect('/trang_admin/san_pham')->with('error', 'Xóa sản phẩm thất bại');
    }

    public function destroyMau($id)
    {
        $ok = $this->ql->Delete_MauXe($id);
        if ($ok) {
            return redirect()->back()->with('success', 'Xóa màu xe thành công');
        }
        return redirect()->back()->with('error', 'Xóa màu xe thất bại');
    }
}