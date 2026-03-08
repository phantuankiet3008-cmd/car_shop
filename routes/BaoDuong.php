<?php
use App\Http\Controllers\User\BaoDuong_controller;
use Illuminate\Support\Facades\Route;


// BẢO DƯỠNG XE
Route::get('/car_shop/baoduong', function () {
    return view('user.layouts.BaoDuong');
})->name('baoduong');
Route::get('/car_shop/baoduong', [BaoDuong_controller::class, 'trang_baoduong']);
Route::post('/car_shop/datlichbaoduong', [BaoDuong_controller::class, 'datlich_baoduong']);