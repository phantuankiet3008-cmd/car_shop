<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class BaoDuong_controller extends Controller
{
    function trang_baoduong()
    {
        $service = new User();
        $idkhachhang = session('user_id');

        $listxekhach = $service->lay_xe_khach($idkhachhang);

        $goi = $service->chongoi_baoduong();

        return view('user.layouts.BaoDuong', [
            'ds_xe' => $listxekhach,
            'goi_bao_duong' => $goi
        ]);
    }

    function datlich_BaoDuong(Request $request)
    {
        $request->validate([
            'id_xe' => 'required',
            'id_goi' => 'required',
            'ngay_bao_duong' => 'required|date'
        ]);

        $service = new User();

        $soLuong = $service->dem_lich_trong_ngay($request->ngay_bao_duong);

        if ($soLuong >= 10) { // giới hạn 10 slot/ngày
            return back()->with('error', 'Ngày này đã hết slot');
        }

        $service->datlich_baoduong(
            session('user_id'),
            $request->id_Xe_Mau,
            $request->id_goi,
            $request->ngay_bao_duong,
            $request->ghi_chu
        );

        return back()->with('success', 'Đặt lịch bảo dưỡng thành công');
    }
    }