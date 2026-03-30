<?php

namespace App\Http\Controllers\User; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\Product; 


class danhsachsanphamController extends Controller
{
  
    public function index(Request $request, $IDloai = 0, $IDTH = 0)
    {

        
        $maLoai = (int)$IDloai;
        $maThuongHieu = (int)$IDTH;

      
        $search = trim($request->query('search', ''));

        
        $sp = new Product();

        
        $danhSachXe = $sp->locSanPham($search, $maLoai, $maThuongHieu);
        
     
        $loaiXeList = $sp->getAllLoaiXe();
        $thuongHieuList = $sp->getAllThuongHieu();

       
       return view('user.layouts.danhsachsanpham', compact(
            'danhSachXe', 
            'loaiXeList', 
            'thuongHieuList', 
            'search', 
            'maLoai', 
            'IDTH' 
        ));

       
    }
}
