<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class danhsachsanphamController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $maLoai = (int) $request->input('MaLoai', 0);
        $maThuongHieu = (int) $request->input('MaThuongHieu', 0);

        $query = DB::table('san_pham_xe')
            ->join('loai_xe', 'san_pham_xe.id_Loai_Xe', '=', 'loai_xe.id_Loai_xe')
            ->join('thuong_hieu_xe', 'san_pham_xe.id_Thuong_Hieu', '=', 'thuong_hieu_xe.id_Thuong_Hieu')
            ->leftJoin('xe_mau', function($join) {
                $join->on('san_pham_xe.id_Xe', '=', 'xe_mau.id_Xe')
                     ->where('xe_mau.is_Default', '=', 1);
            })
            ->select('san_pham_xe.*', 'loai_xe.Ten_Loai_Xe', 'thuong_hieu_xe.Ten_Thuong_Hieu', 'xe_mau.Gia as Gia_Mau')
            ->where('san_pham_xe.Trang_Thai', 1)
            ->orderBy('san_pham_xe.id_Xe', 'desc');

        if ($search !== '') {
            $query->where('san_pham_xe.Ten_Xe', 'like', '%' . $search . '%');
        }
        if ($maLoai > 0) {
            $query->where('san_pham_xe.id_Loai_Xe', $maLoai);
        }
        if ($maThuongHieu > 0) {
            $query->where('san_pham_xe.id_Thuong_Hieu', $maThuongHieu);
        }

        $danhSachXe = $query->paginate(9);
        $loaiXeList = DB::table('loai_xe')->where('Trang_Thai', 1)->get();
        $thuongHieuList = DB::table('thuong_hieu_xe')->where('Trang_Thai', 1)->get();

       
        return view('user.layouts.danhsachsanpham', compact('danhSachXe', 'loaiXeList', 'thuongHieuList', 'search', 'maLoai', 'maThuongHieu'));
    }
}