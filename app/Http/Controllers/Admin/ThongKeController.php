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

        $from = $request->query('from',now()->subDays (30)->format('Y-m-d'));
        $to = $request->query('to', now()->addMonths(1)->format('Y-m-d'));
        $group = $request->query('group', 'ngay');//

        $khungGio = $service->thongKeKhungGioLaiThu($from, $to);
        $topXe = $service->thongKeXeLaiThu(10);
        $topThuongHieu = $service->thongKeThuongHieuLaiThu(10);
        $topLoaiXeMua = $service->thongKeLoaiXeMuaNhieu(10);
        $topLoaiXeUaChuong = $service->thongKeLoaiXeUaChuong(10);
        $topThuongHieuMua = $service->thongKeThuongHieuMuaNhieu(10);
        $topMauXeUaChuong = $service->thongKeMauXeUaChuong(10);
        $topMauXeMua = $service->thongKeMauXeMua(10);
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
        if (!$ngay) {
            return response()->json(['error' => 'Chưa truyền ngày'], 400);
        }

        $service = new QL();
        $data = $service->thongKeChiTietNgay($ngay);
        return response()->json(['date' => $ngay, 'khungGio' => $data]);
    }

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

