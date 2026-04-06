<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function index(Request $request, $tab = 'tieu-dung')
    {
        $service = new QL();

        // Thiết lập thời gian mặc định: 30 ngày trước đến 1 tháng sau tính từ ngày hiện tại
        $from = $request->query('from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $to = $request->query('to', Carbon::now()->addMonth(1)->format('Y-m-d'));
        $group = $request->query('group', 'ngay');

        // Lấy dữ liệu từ Service QL
        // Lưu ý: Tên biến bên trái (Key) phải khớp 100% với biến gọi trong file Blade
        $data = [
            'key'                  => 'kiem_ke',
            'tab'                  => $tab,
            'from'                 => $from,
            'to'                   => $to,
            'group'                => $group,

            // Biểu đồ đường - Lái thử
            'bieuDo'               => $service->thongKeLichTheoThoiGian($from, $to, $group),

            // Biểu đồ cột - Giờ vàng (Gán kết quả vào biến bieuDoGio để Blade nhận được)
           'thongKeKhungGio'      => $service->thongKeKhungGioLaiThu($from, $to),

            // Biểu đồ tròn & Bảng xu hướng (Dùng hàm XuHuong để có cả lượt thích và lượt mua)
            'topLoaiXeXuHuong'     => $service->thongKeLoaiXeXuHuong(10),
            'topThuongHieuXuHuong' => $service->thongKeThuongHieuXuHuong(10),

            // Biểu đồ bảo dưỡng
            'bieuDoBaoDuong'       => $service->thongKeLichBaoDuongTheoThoiGian($from, $to, $group),

            // Các dữ liệu Top cũ (Dùng cho các bảng danh sách bên dưới nếu cần)
            'topXe'                => $service->thongKeXeLaiThu(10),
            'topThuongHieu'        => $service->thongKeThuongHieuLaiThu(10),
            'topLoaiXeUaChuong'    => $service->thongKeLoaiXeUaChuong(10),
            'topLoaiXeMua'         => $service->thongKeLoaiXeMuaNhieu(10),
            'topThuongHieuMua'     => $service->thongKeThuongHieuMuaNhieu(10),
            'topMauXeUaChuong'     => $service->thongKeMauXeUaChuong(10),
            'topMauXeMua'          => $service->thongKeMauXeMua(10),
            'topThuongHieuXuHuong' => $service->thongKeThuongHieuXuHuong(10),
        ];

        return view('admin.layouts.index_AD', $data);
    }

    // API phục vụ cho nút "Xem chi tiết khung giờ" bằng Fetch
    public function khungGioTheoNgay(Request $request)
    {
        $ngay = $request->query('ngay');
        if (!$ngay) {
            return response()->json(['error' => 'Chưa truyền ngày'], 400);
        }

        $service = new QL();
        $data = $service->thongKeChiTietNgay($ngay);
        return response()->json(['date' => $ngay, 'khungGio' => $data]);
    }

    // API phục vụ cho nút "Tra cứu ngày" bảo dưỡng bằng Fetch
    public function baoDuongTheoNgay(Request $request)
    {
        $ngay = $request->query('ngay');
        if (!$ngay) {
            return response()->json(['error' => 'Chưa truyền ngày'], 400);
        }

        $service = new QL();
        $data = $service->thongKeChiTietBaoDuongTheoNgay($ngay);
        return response()->json(['date' => $ngay, 'baoDuong' => $data]);
    }
}