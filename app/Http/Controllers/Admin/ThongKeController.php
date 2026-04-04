<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function index()
    {
        $namHienTai = Carbon::now()->year;
        $thangHienTai = Carbon::now()->month;

        // 1. TỔNG DOANH THU (Total Revenue)
        // Lấy những đơn hàng đã cọc, đã ký hoặc đã giao
        $tongDoanhThu = DB::table('don_hang')
            ->whereIn('Trang_Thai', ['da_coc', 'da_ky', 'da_giao'])
            ->sum('Tong_Tien');

        // 2. KHÁCH HÀNG MỚI (New Users)
        // Đếm số lượng khách hàng tạo trong tháng này
        $khachHangMoi = DB::table('khach_hang')
            ->whereMonth('Ngay_Tao', $thangHienTai)
            ->whereYear('Ngay_Tao', $namHienTai)
            ->count();

        // 3. DỮ LIỆU BIỂU ĐỒ DOANH THU THEO THÁNG TRONG NĂM
        $doanhThuDB = DB::table('don_hang')
            ->select(DB::raw('MONTH(Ngay_Tao) as thang'), DB::raw('SUM(Tong_Tien) as doanh_thu'))
            ->whereYear('Ngay_Tao', $namHienTai)
            ->whereIn('Trang_Thai', ['da_coc', 'da_ky', 'da_giao'])
            ->groupBy(DB::raw('MONTH(Ngay_Tao)'))
            ->pluck('doanh_thu', 'thang')
            ->toArray();

        // Ép mảng dữ liệu cho đủ 12 tháng (tháng nào không có doanh thu thì gán = 0)
        $bieuDoDoanhThu = [];
        for ($i = 1; $i <= 12; $i++) {
            $bieuDoDoanhThu[] = isset($doanhThuDB[$i]) ? (float) $doanhThuDB[$i] : 0;
        }

        // Trả toàn bộ dữ liệu về view (giao diện frontend)
        return view('admin.layouts.index_AD', [
            'key' => 'dashboard',
            'tongDoanhThu' => $tongDoanhThu,
            'khachHangMoi' => $khachHangMoi,
            'bieuDoDoanhThu' => $bieuDoDoanhThu,
            'namHienTai' => $namHienTai
        ]);
    }
}