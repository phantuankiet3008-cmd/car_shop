<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\danhsachsanphamController;
route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);
