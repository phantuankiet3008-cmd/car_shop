<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class ThongKeController extends Controller
{
    public function index(Request $request, $tab = 'tieu-dung')
    {
        $service = new QL();

        // ===============================================
        // 1. NẾU BẤM VÀO TAB "DOANH THU"
        // ===============================================
        if ($tab == 'doanh-thu') {
            $namHienTai = date('Y');
            
            $tongDoanhThu = $service->ThongKe_TongDoanhThu($namHienTai);
            $soLuongXeBanRa = $service->ThongKe_SoLuongXeBanRa($namHienTai);
            $khachHangMoi = $service->ThongKe_KhachHangMoi($namHienTai);
            $tyLeQuayLai  = $service->ThongKe_TyLeQuayLai();
            
            // --- 3 DỮ LIỆU ĐỂ VẼ BIỂU ĐỒ ---
            $bieuDoDoanhThu = $service->ThongKe_BieuDoDoanhThu($namHienTai); // Tháng
            $bieuDoTuan = $service->ThongKe_BieuDoDoanhThu_Tuan();           // Tuần 
            $bieuDoNam = $service->ThongKe_BieuDoDoanhThu_Nam($namHienTai);  // Năm 
            
            $chiTietXeBanRa = $service->ThongKe_ChiTietXeBanRa($namHienTai);

            return view('admin.layouts.index_AD', [
                'key' => 'kiem_ke',
                'tab' => $tab,
                'tongDoanhThu' => $tongDoanhThu,
                'soLuongXeBanRa' => $soLuongXeBanRa,
                'khachHangMoi' => $khachHangMoi,
                'tyLeQuayLai'  => $tyLeQuayLai,
                
                // Trả 3 mảng này qua cho View
                'bieuDoDoanhThu' => $bieuDoDoanhThu, 
                'bieuDoTuan' => $bieuDoTuan,     
                'bieuDoNam' => $bieuDoNam,       
                
                'chiTietXeBanRa' => $chiTietXeBanRa, 
                'namHienTai' => $namHienTai
            ]);
        }

        // ===============================================
        // 2. NẾU BẤM VÀO TAB "TIÊU DÙNG"
        // ===============================================
        $from = $request->query('from', now()->subDays(30)->format('Y-m-d')); 
        $to = $request->query('to', now()->addMonths(1)->format('Y-m-d')); 
        $group = $request->query('group', 'ngay');

        $khungGio = $service->thongKeKhungGioLaiThu($from, $to);
        $topXe = $service->thongKeXeLaiThu(10);
        $topThuongHieu = $service->thongKeThuongHieuLaiThu(10);
        $topLoaiXeMua = $service->thongKeLoaiXeMuaNhieu(10);
        $topLoaiXeUaChuong = $service->thongKeLoaiXeUaChuong(10);
        $topThuongHieuMua = $service->thongKeThuongHieuMuaNhieu(10);
        $topMauXeUaChuong = $service->thongKeMauXeUaChuong(10);
        $topMauXeMua = $service->thongKeMauXeMua(10);
        $topLoaiXeXuHuong = $service->thongKeLoaiXeXuHuong(10); 
        $topThuongHieuXuHuong = $service->thongKeThuongHieuXuHuong(10);
        $bieuDo = $service->thongKeLichTheoThoiGian($from, $to, $group);
        $bieuDoBaoDuong = $service->thongKeLichBaoDuongTheoThoiGian($from, $to, $group);

        return view('admin.layouts.index_AD', [
            'key' => 'kiem_ke',
            'tab' => $tab,
            'khungGio' => $khungGio,
            'topXe' => $topXe,
            'topThuongHieu' => $topThuongHieu,
            'topLoaiXeMua' => $topLoaiXeMua,
            'topLoaiXeUaChuong' => $topLoaiXeUaChuong,
            'topThuongHieuMua' => $topThuongHieuMua,
            'topMauXeUaChuong' => $topMauXeUaChuong,
            'topMauXeMua' => $topMauXeMua,
            'topLoaiXeXuHuong' => $topLoaiXeXuHuong,
            'topThuongHieuXuHuong' => $topThuongHieuXuHuong,
            'bieuDo' => $bieuDo,
            'bieuDoBaoDuong' => $bieuDoBaoDuong,
            'group' => $group,
            'from' => $from,
            'to' => $to,  
        ]);
    }

    public function khungGioTheoNgay(Request $request)
    {
        $ngay = $request->query('ngay');
        if (!$ngay) return response()->json(['error' => 'Chưa truyền ngày'], 400);
        $service = new QL();
        return response()->json(['date' => $ngay, 'khungGio' => $service->thongKeChiTietNgay($ngay)]);
    }

    public function baoDuongTheoNgay(Request $request)
    {
        $ngay = $request->query('ngay');
        if (!$ngay) return response()->json(['error' => 'Chưa truyền ngày'], 400);
        $service = new QL();
        return response()->json(['date' => $ngay, 'baoDuong' => $service->thongKeChiTietBaoDuongTheoNgay($ngay)]);
    }
}