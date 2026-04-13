<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class TrangChuController extends Controller
{
    public function index()
    {
        return view('user.layouts.user_index');
    }

    public function trangchu()
    {
        $user = new User();

        // slider cũ
        $listanh = $user->Danh_Sach_Slider();

        $listanh = $user->Danh_Sach_Slider();

// Danh sách hãng
$thuongHieuList = ['Ford', 'Toyota', 'Hyundai', 'Mitsubishi', 'VinFast', 'BMW'];

$thuongHieuData = [];

foreach ($thuongHieuList as $thuongHieu) {
    $data = $user->lay_anh_va_id_theo_thuong_hieu_moi_nhat($thuongHieu);

    $thuongHieuData[strtolower($thuongHieu)] = [
        'Anh_Dai_Dien'   => $data['Anh_Dai_Dien'] ?? null,
        'id_Thuong_Hieu' => $data['id_Thuong_Hieu'] ?? 0,
        'id_Xe'          => $data['id_Xe'] ?? 0   // 🔥 QUAN TRỌNG
    ];
}

return view('user.partials.user_trangchu', [
    'data' => [
        'danh_sach_slider' => $listanh
    ],
    'thuongHieuData' => $thuongHieuData
]);
    }
}