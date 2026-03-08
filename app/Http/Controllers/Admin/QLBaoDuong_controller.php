<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class QLBaoDuong_controller extends Controller
{

    // Danh sách lịch bảo dưỡng
    function index(Request $request)
    {
        $service = new QL();

        $data = $service->danh_sach_lich($request);

        return view('admin.layouts.index_AD', [
            'data' => $data,
            'key' => 'bao_duong'
        ]);
    }

    // Trang sửa bảo dưỡng
    function edit($id)
    {
        $ql = new QL();

        $baoduong = $ql->Get_ChiTietbaoduong($id);

        if (!$baoduong) {
            return redirect('/trang_admin/baoduong')
                ->with('error', 'Lịch bảo dưỡng không tồn tại');
        }

        return view('admin.layouts.index_AD', [
            'key' => 'Edit_Bao_Duong',
            'data' => [
                'baoduong' => $baoduong
            ]
        ]);
    }

    // Cập nhật bảo dưỡng
    function update(Request $request, $id)
    {
        $ql = new QL();

        $ok = $ql->Update_baoduong($id, $request->all(), $_FILES);

        if ($ok) {
            return redirect('/trang_admin/baoduong')
                ->with('success', 'Cập nhật lịch bảo dưỡng thành công');
        }

        return back()->with('error', 'Có lỗi khi cập nhật');
    }

    // Xóa lịch bảo dưỡng
    function destroy($id)
    {
        $ql = new QL();

        $ok = $ql->Delete_BaoDuong($id); // sửa lại đúng hàm

        if ($ok) {
            return redirect('/trang_admin/baoduong')
                ->with('success', 'Xóa lịch bảo dưỡng thành công');
        }

        return redirect('/trang_admin/baoduong')
            ->with('error', 'Xóa lịch bảo dưỡng thất bại');
    }

    
}