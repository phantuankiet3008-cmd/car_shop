<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ThongKeController extends Controller
{
    public function index(Request $request, $tab = 'tieu-dung')
    {
        $service = new QL();

        // Thiết lập thời gian mặc định: 30 ngày trước đến 1 tháng sau tính từ ngày hiện tại
        $from = $request->query('from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $to = $request->query('to', Carbon::now()->addMonth(1)->format('Y-m-d'));
        $group = $request->query('group', 'ngay');

        // ===============================================
        // 1. NẾU BẤM VÀO TAB "DOANH THU"
        // ===============================================
        if ($tab == 'doanh-thu') {
            $namHienTai = date('Y');
            
            // Tính tổng tiền các đơn hàng đã thanh toán (paid)
            $tongDoanhThu = DB::table('don_hang')->where('payment_status', 'paid')->sum('Tong_Tien');
            
            // Đếm tổng số khách hàng mới
            $khachHangMoi = DB::table('khach_hang')->count();
            
            // Gom nhóm doanh thu theo từng tháng để vẽ biểu đồ lượn sóng
            $doanhThuDB = DB::table('don_hang')
                ->select(DB::raw('MONTH(Ngay_Tao) as thang'), DB::raw('SUM(Tong_Tien) as doanh_thu'))
                ->where('payment_status', 'paid')
                ->whereYear('Ngay_Tao', $namHienTai)
                ->groupBy(DB::raw('MONTH(Ngay_Tao)'))
                ->pluck('doanh_thu', 'thang')
                ->toArray();

            // Nhồi dữ liệu cho đủ 12 tháng (tháng nào không có doanh thu thì = 0)
            $bieuDoDoanhThu = [];
            for ($i = 1; $i <= 12; $i++) {
                $bieuDoDoanhThu[] = isset($doanhThuDB[$i]) ? (float) $doanhThuDB[$i] : 0;
            }

            return view('admin.layouts.index_AD', [
                'key' => 'kiem_ke',
                'tab' => $tab,
                'tongDoanhThu' => $tongDoanhThu,
                'khachHangMoi' => $khachHangMoi,
                'bieuDoDoanhThu' => $bieuDoDoanhThu,
                'namHienTai' => $namHienTai
            ]);
        }

        // ===============================================
        // 2. NẾU BẤM VÀO TAB "TIÊU DÙNG" (Mặc định)
        // ===============================================
        $data = [
            'key'                  => 'kiem_ke',
            'tab'                  => $tab,
            'from'                 => $from,
            'to'                   => $to,
            'group'                => $group,
            'bieuDo'               => $service->thongKeLichTheoThoiGian($from, $to, $group),
            'thongKeKhungGio'      => $service->thongKeKhungGioLaiThu($from, $to),
            'topLoaiXeXuHuong'     => $service->thongKeLoaiXeXuHuong(10),
            'topThuongHieuXuHuong' => $service->thongKeThuongHieuXuHuong(10),
            'bieuDoBaoDuong'       => $service->thongKeLichBaoDuongTheoThoiGian($from, $to, $group),
            'topXe'                => $service->thongKeXeLaiThu(10),
            'topThuongHieu'        => $service->thongKeThuongHieuLaiThu(10),
            'topLoaiXeUaChuong'    => $service->thongKeLoaiXeUaChuong(10),
            'topLoaiXeMua'         => $service->thongKeLoaiXeMuaNhieu(10),
            'topThuongHieuMua'     => $service->thongKeThuongHieuMuaNhieu(10),
            'topMauXeUaChuong'     => $service->thongKeMauXeUaChuong(10),
            'topMauXeMua'          => $service->thongKeMauXeMua(10),
        ];

        return view('admin.layouts.index_AD', $data);
    }

    // API phục vụ cho nút "Xem chi tiết khung giờ" bằng Fetch
    public function khungGioTheoNgay(Request $request)
    {
        $ngay = $request->query('ngay');
        if (!$ngay) return response()->json(['error' => 'Chưa truyền ngày'], 400);
        $service = new QL();
        return response()->json(['date' => $ngay, 'khungGio' => $service->thongKeChiTietNgay($ngay)]);
    }

    // API phục vụ cho nút "Tra cứu ngày" bảo dưỡng bằng Fetch
    public function baoDuongTheoNgay(Request $request) 
    {
        $ngay = $request->query('ngay');
        if (!$ngay) return response()->json(['error' => 'Chưa truyền ngày'], 400);
        $service = new QL();
        return response()->json(['date' => $ngay, 'baoDuong' => $service->thongKeChiTietBaoDuongTheoNgay($ngay)]);
    }
}