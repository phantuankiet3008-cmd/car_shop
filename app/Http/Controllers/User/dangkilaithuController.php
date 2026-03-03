<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product;


class DangkilaithuController extends Controller
{
    function index($id){
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
        $Xe_mau = [];
        $result_xe_mau = $sp->getDanhSachXeMauTheoXe($id);

        if ($result_xe_mau) {
            while ($row = $result_xe_mau->fetch_assoc()) {
                $Xe_mau[] = $row;
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

        
         return view('user.layouts.DangKiLaiThu', [
             'chitietsp' => (object)$chitietsp,
             'anh_xe_mau' => $anh_xe_mau,
             'xeMau' => !empty($Xe_mau) ? (object)$Xe_mau[0] : null,
             'mau_xe' => $mau_xe
         ]);
    }
}