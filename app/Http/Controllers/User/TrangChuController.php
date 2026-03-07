<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class TrangChuController extends Controller
{
    protected $sp;

    public function __construct()
    {
        $this->sp = new QL();
    }

    public function index(Request $request)
    {
        $MaLoai = intval($request->MaLoai ?? 0);
        $MaThuongHieu = intval($request->MaThuongHieu ?? 0);

        // Lấy danh sách loại xe
     $listLoai = $this->sp->DS_Loai_Xe();

        // Lấy danh sách thương hiệu
        if ($MaLoai) {
            $listThuongHieu = $this->sp->list_thuong_hieu_theo_loai($MaLoai);
        } else {
           $listThuongHieu = $this->sp->DS_Thuong_Hieu_Xe();
        }

        return view('user.layouts.user_index', compact(
            'listLoai',
            'listThuongHieu',
            'MaLoai',
            'MaThuongHieu'
        ));
    }
}