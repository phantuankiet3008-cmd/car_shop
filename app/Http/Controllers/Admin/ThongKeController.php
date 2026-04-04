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

        $from = $request->query('from');
        $to = $request->query('to');
        $group = $request->query('group', 'ngay');//

        $khungGio = $service->thongKeKhungGioLaiThu($from, $to);
        $topXe = $service->thongKeXeLaiThu(10);
        $topThuongHieu = $service->thongKeThuongHieuLaiThu(10);
        $topLoaiXeMua = $service->thongKeLoaiXeMuaNhieu(10);
        $topThuongHieuMua = $service->thongKeThuongHieuMuaNhieu(10);
        $topMauXe = $service->thongKeMauXeYeuThich(10);
        $bieuDo = $service->thongKeLichTheoThoiGian($from, $to, $group);
        $bieuDoBaoDuong = $service->thongKeLichBaoDuongTheoThoiGian($from, $to, $group);

        return view('admin.layouts.index_AD', [
            'key' => 'kiem_ke',
            'tab' => $tab,
            'khungGio' => $khungGio,
            'topXe' => $topXe,
            'topThuongHieu' => $topThuongHieu,
            'topLoaiXeMua' => $topLoaiXeMua,
            'topThuongHieuMua' => $topThuongHieuMua,
            'topMauXe' => $topMauXe,
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

