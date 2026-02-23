<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class UuDaiController extends Controller
{
    // Danh sách ưu đãi
function index()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'uu_dai',
        'data' => [
            // ÉP về array
            'danh_sach' => $ql->DanhSach_Uu_Dai()
        ]
    ]);
}
function create()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'Add_Uu_Dai'
        
    ]);
}
function store(Request $request)
{
    $ql = new QL();

    // Validate dữ liệu
    $request->validate([
    'ten' => 'required|string|max:255',
    'loai' => 'required|in:phan_tram,tien_mat',
    'gia_tri' => 'required|numeric|min:0',
    'ngay_bd' => 'required|date',
    'ngay_kt' => 'required|date|after_or_equal:ngay_bd',
    'trang_thai' => 'required|in:0,1'
]);

$ql->Add_Uu_Dai(
    $request->ten,
    $request->loai,
    $request->gia_tri,
    $request->ngay_bd,
    $request->ngay_kt,
    $request->trang_thai
);


    return redirect('/trang_admin/uu_dai');
}
function destroy($id)
{
    $ql = new QL();
    $ql->Delete_Uu_Dai($id);
    return redirect('/trang_admin/uu_dai');
}
function indexXeUuDai()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'chitiet_uu_dai',
        'data' => [
            // ÉP về array
            'danh_sach' => $ql->DanhSach_Xe_Uu_Dai()
        ]
    ]);

}
function createXeUuDai()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'Add_Chi_Tiet_Uu_Dai',
        'data' => [
            'danh_sach_xe' => $ql->ten_sanpham(),
            'danh_sach_uudai' => $ql->DanhSach_Uu_Dai()
        ]
    ]);
}
function storeXeUuDai(Request $request)
{
    $ql = new QL();

    // Validate dữ liệu
    $request->validate([
    'id_xe' => 'required|integer',
    'id_uu_dai' => 'required|integer'
]);
$ql->Add_Xe_Uu_Dai($request->id_xe, $request->id_uu_dai);
    return redirect('/trang_admin/xe_uu_dai');
}
function destroyXeUuDai($id_xe, $id_uudai)
{
    $ql = new QL();
    $ql->Delete_Xe_Uu_Dai($id_xe, $id_uudai);
    return redirect('/trang_admin/xe_uu_dai');
}
}