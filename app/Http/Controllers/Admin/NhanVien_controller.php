<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class NhanVien_controller extends Controller
{
    protected $ql;

    public function __construct()
    {
        $this->ql = new QL();
    }

function index(Request $request)
    {
        $filters = [
            'ten'     => $request->input('search_ten'),
            'role_id' => $request->input('search_role'),
        ];
    
        return view('admin.layouts.index_AD', [
            'key' => 'nhan_vien',
            'data' => [
                'danh_sach' => $this->ql->DanhSach_Nhan_Vien($filters),
            ],
            'filters' => $filters
        ]);
    }

    // Thêm
    function create()
    {
        return view('admin.layouts.index_AD', [
            'key' => 'add_nhan_vien'
        ]);
    }

    function store(Request $request)
{
    $request->validate([
        'Ho_Ten' => 'required',
        'UserName' => 'required',
        'Email' => 'required|email',
        'MatKhau' => 'required',
        'role_id' => 'required'
    ]);

    $this->ql->Them_Nhan_Vien($request);

    return redirect('/trang_admin/nhan_vien')
           ->with('success', 'Thêm nhân viên thành công');
}

    // Sửa
function edit($id)
{
    return view('admin.layouts.index_AD', [
        'key' => 'edit_nhan_vien',
        'data' => [
            'nhan_vien' => $this->ql->ChiTiet_Nhan_Vien($id)
        ]
    ]);
}

function update(Request $request, $id)
{
    $request->validate([
        'Ho_Ten' => 'required',
        'UserName' => 'required',
        'Email' => 'required|email',
        'role_id' => 'required'
    ]);

    $this->ql->CapNhat_Nhan_Vien($request, $id);

    return redirect('/trang_admin/nhan_vien')
           ->with('success', 'Cập nhật nhân viên thành công');
}


    // Xóa
function destroy($id)
{
    $this->ql->Xoa_Nhan_Vien($id);

    return redirect('/trang_admin/nhan_vien')
           ->with('success', 'Xóa nhân viên thành công');
}
}