<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class KhachHangController extends Controller
{
    // Danh sách khách hàng
function index()
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'khach_hang',
        'data' => [
            // ÉP về array
            'danh_sach' => $ql->DanhSach_Khach_Hang()
        ]
    ]);
}
function search($keyword)
{
    $ql = new QL();

    return view('admin.layouts.index_AD', [
        'key' => 'khach_hang',
        'data' => [
            // ÉP về array
            'danh_sach' => $ql->TimKiem_Khach_Hang($keyword)
        ]
    ]);
}
function create (){
    
    return view('admin.layouts.index_AD', [
        'key' => 'add_kh',
       
        
    ]);
}
public function store(Request $request)
{
    $ql = new QL();

    // Validate dữ liệu
    $request->validate([
        'Ho_Ten' => 'required|string|max:255',
        'Email' => 'required|email',
        'So_Dien_Thoai' => 'nullable|string|max:20',
        'Dia_Chi' => 'nullable|string|max:255',
        'Mat_Khau' => 'required|min:6',
        'Trang_Thai' => 'required|in:0,1'
    ]);

    

    $res = $ql->Add_Khach_Hang(
        $request->Ho_Ten,
        $request->Email,
        $request->So_Dien_Thoai,
        $request->Dia_Chi,
        $request->Mat_Khau,
        $request->Trang_Thai    
    );

    if ($res === true) {
        return redirect('/trang_admin/khach_hang')
                ->with('success', 'Thêm khách hàng thành công!');
    } else {
        return back()
                ->with('error', 'Lỗi: ' . $res)
                ->withInput();
    }
}
function edit($id){
    $ql = new QL();
    $kh = $ql->ChiTiet_Khach_Hang($id);
    return view('admin.layouts.index_AD', [
        'key' => 'update_kh',
        'data' => [
            'khach_hang' => $kh
        ]
    ]);

}
function update(Request $request, $id){
    $ql = new QL();

    // Validate dữ liệu
    $request->validate([
        'Ho_Ten' => 'required|string|max:255',
        'Email' => 'required|email',
        'So_Dien_Thoai' => 'nullable|string|max:20',
        'Mat_Khau' => 'nullable|min:6',
        'Dia_Chi' => 'nullable|string|max:255',
        'Trang_Thai' => 'required|in:0,1'
    ]);

    $res = $ql->Update_Khach_Hang(
        $id,
        $request->Ho_Ten,
        $request->Email,
        $request->So_Dien_Thoai,
        $request->Mat_Khau,
        $request->Dia_Chi,
        $request->Trang_Thai    
    );

    if ($res === true) {
        return redirect('/trang_admin/khach_hang')
                ->with('success', 'Cập nhật khách hàng thành công!');
    } else {
        return back()
                ->with('error', 'Lỗi: ' . $res)
                ->withInput();
    }
}
function destroy($id){
    $ql = new QL();
    $res = $ql->Delete_Khach_Hang($id);

    if ($res === true) {
        return redirect('/trang_admin/khach_hang')
                ->with('success', 'Xoá khách hàng thành công!');
    } else {
        return back()
                ->with('error', 'Lỗi: ' . $res);
    }
}
}