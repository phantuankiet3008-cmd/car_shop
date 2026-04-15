<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class DonHang_Controller extends Controller
{
    protected $ql;

    public function __construct()
    {
        $this->ql = new QL();
    }

    // Danh sách đơn hàng có lọcpublic 
    function index(Request $request)
{
    $filters = [
        'keyword'        => $request->input('keyword'), // Sửa lại cho khớp với name="keyword" ở form lọc
        'payment_status' => $request->input('payment_status'),
        'trang_thai'     => $request->input('trang_thai'),
    ];

    return view('admin.layouts.index_AD', [
        'key' => 'don_hang', 
        'data' => [
            'list_don_hang' => $this->ql->DanhSach_DonHang($filters)
        ]
    ]);
}

    // Trang thêm đơn hàng
    public function create(){
   
    return view('admin.layouts.index_AD', [
        'key' => 'them_don_hang',
        'data' => [
            'ds_khach_hang'  => $this->ql->DanhSach_Khach_Hang(),
            'ds_loai'        => $this->ql->DS_Loai_Xe(),
            'ds_thuong_hieu' => $this->ql->DS_Thuong_Hieu_Xe(),
        ]
    ]);
}
        

    // Lưu đơn hàng mới
    public function store(Request $request)
{
    $tong_tien = $request->gia_goc - ($request->gia_giam ?? 0);
    
    // 1. Thêm đơn hàng
    $ok = $this->ql->Add_DonHang($request->all(), $tong_tien);

    if ($ok) {
        // 2. Nếu trạng thái là 'da_ky', thực hiện trừ kho
        if ($request->trang_thai == 'da_giao') {
            $this->ql->Tru_So_Luong_Xe($request->id_xe_mau);
        }
        return redirect('/trang_admin/don_hang')->with('success', 'Tạo đơn hàng thành công');
    }
    
    return back()->with('error', 'Thêm mới thất bại');
}
    

    // Trang sửa đơn hàng
    public function edit($id)
{
    // Lấy chi tiết đơn hàng (Service trả về fetch_assoc - mảng)
    $don_hang = $this->ql->Get_ChiTietDonHang($id);

    if (!$don_hang) {
        return redirect('/trang_admin/don_hang')->with('error', 'Đơn hàng không tồn tại');
    }

    return view('admin.layouts.index_AD', [
        'key' => 'Edit_Don_Hang',
        'data' => [
            'don_hang'      => $don_hang,
            'ds_khach_hang' => $this->ql->DanhSach_Khach_Hang(), // Lấy lại DS khách
            'ds_xe_mau'     => $this->ql->List_XeKemMau(),      // Lấy DS xe kèm màu để chọn lại
        ]
    ]);
}

    // Cập nhật đơn hàng
    public function update(Request $request, $id)
{
    // 1. Lấy thông tin đơn hàng hiện tại trước khi cập nhật để xem trạng thái cũ
    $don_hang_cu = $this->ql->Get_ChiTietDonHang($id);
    if (!$don_hang_cu) {
        return back()->with('error', 'Đơn hàng không tồn tại');
    }

    $tong_tien = $request->gia_goc - ($request->gia_giam ?? 0);
    
    // 2. Cập nhật thông tin đơn hàng
    $ok = $this->ql->Update_DonHang($id, $request->all(), $tong_tien);

    if ($ok) {
        // 3. Kiểm tra logic trừ kho:
        // Nếu trạng thái cũ KHÁC 'da_ky' và trạng thái mới LÀ 'da_ky'
        if ($don_hang_cu['Trang_Thai'] != 'da_giao' && $request->trang_thai == 'da_giao') {
            $this->ql->Tru_So_Luong_Xe($request->id_xe_mau);
        }
        
        return redirect('/trang_admin/don_hang')->with('success', 'Cập nhật đơn hàng thành công');
    }
    
    return back()->with('error', 'Cập nhật thất bại');
}

    // Xóa đơn hàng
    public function destroy($id)
    {
        $ok = $this->ql->Delete_DonHang($id);
        return redirect('/trang_admin/don_hang')->with($ok ? 'success' : 'error', $ok ? 'Đã xóa đơn hàng' : 'Xóa thất bại');
    }
    // 1. Lấy sản phẩm dựa trên Loại & Thương hiệu
public function getSanPhamByFilter(Request $request) {
    $filters = [
        'id_loai' => $request->id_loai,
        'id_thương_hieu' => $request->id_thuong_hieu
    ];
    $products = $this->ql->DanhSach_SanPham($filters); // Tận dụng hàm cũ của bạn
    
    $html = '<option value="">-- Chọn sản phẩm --</option>';
    foreach($products as $p) {
        $html .= "<option value='{$p['id_Xe']}'>{$p['Ten_Xe']}</option>";
    }
    return response()->json(['html' => $html]);
}

// 2. Lấy danh sách xe_mau (biến thể) dựa trên id_Xe
public function getMauBySanPham(Request $request) {
    $id_xe = $request->id_xe;
    $list_mau = $this->ql->Get_Mau_Theo_Xe($id_xe);
    
    $html = '<option value="">-- Chọn màu & phiên bản --</option>';
    foreach($list_mau as $m) {
        $gia_fmt = number_format($m['Gia']);
        $html .= "<option value='{$m['id_Xe_Mau']}' data-gia='{$m['Gia']}'>{$m['Ten_Mau']} ({$gia_fmt} VNĐ) - Kho: {$m['So_Luong']}</option>";
    }
    return response()->json(['html' => $html]);
}
}