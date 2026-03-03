<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product;


class ChitietxeController extends Controller
{
    public function index($id)
    {
        $sp = new Product();

        $id = (int)$id;

        // ===== 1. Chi tiết xe =====
        $chitietsp = $sp->chitietsp($id);

        if (!$chitietsp) {
            return abort(404, 'Không tìm thấy xe trong hệ thống.');
        }

        // ===== 2. Ảnh xe =====
        $anh_xe_mau = [];
        $result_anh = $sp->list_anh_xe_mau($id);

        if ($result_anh) {
            while ($row = $result_anh->fetch_assoc()) {
                $anh_xe_mau[] = $row;
            }
        }

        // ===== 3. Màu xe =====
        $mau_xe = [];
        $result_mau = $sp->list_mau_xe($id);

        if ($result_mau) {
            while ($row = $result_mau->fetch_assoc()) {
                $mau_xe[] = $row;
            }
        }

        // ===== 4. Giá mặc định =====
        $gia_mac_dinh = 0;
        if (!empty($mau_xe)) {
            $gia_mac_dinh = $mau_xe[0]['Gia'];
        }

        // ===== 5. Ưu đãi =====
        $uu_dai = [];
        $result_uu_dai = $sp->uu_dai_cua_xe($id);

        if ($result_uu_dai) {
            while ($row = $result_uu_dai->fetch_assoc()) {
                $uu_dai[] = $row;
            }
        }

        return view('user.layouts.chitietsp', compact(
            'chitietsp',
            'anh_xe_mau',
            'mau_xe',
            'gia_mac_dinh',
            'uu_dai'
        ));
    }
}