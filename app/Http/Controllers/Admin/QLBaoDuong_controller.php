<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class QLBaoDuong_controller extends Controller
{
    // Danh sách
    function index(Request $request)
    {
        $service = new QL();

        $data = $service->danh_sach_lich($request);

        return view('admin.layouts.index_AD', [
            'data' => $data,
            'key' => 'bao_duong'
        ]);
    }

    // Trang sửa
    function edit($id)
    {
        $ql = new QL();

        $baoduong = $ql->Get_ChiTietbaoduong($id);
        $ds_goi   = $ql->Get_All_GoiBaoDuong(); 

        if (!$baoduong) {
            return redirect('/trang_admin/baoduong')
                ->with('error', 'Lịch bảo dưỡng không tồn tại');
        }

        return view('admin.layouts.index_AD', [
            'key' => 'edit_bao_duong',
            'data' => [
                'baoduong' => $baoduong,
                'ds_goi'   => $ds_goi 
            ]
        ]);
    }

    // Cập nhật
    function update(Request $request, $id)
    {
        $ql = new QL();

        $request->validate([
            'id_goi' => 'required|integer',
            'ngay_bao_duong' => 'required|date',
            'trang_thai' => 'required',
            'ghi_chu' => 'nullable|string'
        ]);

        $data = [
            'id_goi' => $request->id_goi,
            'ngay_bao_duong' => $request->ngay_bao_duong,
            'trang_thai' => $request->trang_thai,
            'ghi_chu' => $request->ghi_chu
        ];

        $ok = $ql->Update_baoduong($id, $data);

        if ($ok) {
            return redirect('/trang_admin/baoduong')
                ->with('success', 'Cập nhật lịch bảo dưỡng thành công');
        }

        return back()->with('error', 'Có lỗi khi cập nhật');
    }

    // Xóa
    function destroy($id)
    {
        $ql = new QL();

        $ok = $ql->Delete_BaoDuong($id);

        if ($ok) {
            return redirect('/trang_admin/baoduong')
                ->with('success', 'Xóa lịch bảo dưỡng thành công');
        }

        return redirect('/trang_admin/baoduong')
            ->with('error', 'Xóa lịch bảo dưỡng thất bại');
    }
}