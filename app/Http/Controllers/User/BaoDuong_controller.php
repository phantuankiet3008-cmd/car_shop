<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BaoDuong;

class BaoDuong_controller extends Controller
{
    function trang_baoduong()
    {
        $service = new BaoDuong();
        $goi = $service->chongoi_baoduong();

        return view('user.layouts.BaoDuong', [
            'goi_bao_duong' => $goi
        ]);
    }

    function datlich_BaoDuong(Request $request)
    {
        $request->validate([
            'id_goi' => 'required',
            'ngay_bao_duong' => 'required'
        ]);

        $service = new BaoDuong();

        $service->datlich_baoduong(
            session('user_id'),
            $request->id_goi,
            $request->ngay_bao_duong
        );

        return back()->with('success','Đặt lịch bảo dưỡng thành công');
    }
}