<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class khuyenmaiController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function khuyenmai()
    {
        $sanPham = $this->user->lay_san_pham_khuyen_mai();

        return view('user.car_shop.khuyenmai', [
            'sanPham' => $sanPham
        ]);
    }
}