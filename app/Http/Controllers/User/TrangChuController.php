<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\user;

class TrangChuController extends Controller
{
    public function index()
    {
        return view('user.layouts.user_index');
    }
    public function trangchu()
    {
        $user = new User();
        $listanh = $user->Danh_Sach_Slider();
        return view('user.partials.user_trangchu', [
            
            'data' => [
                'danh_sach_slider' => $listanh
            ]
        ]);
        
    }
}

?>