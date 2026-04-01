<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class DangNhapADM_controller extends Controller
{
    public function showLogin()
    {
        return view('admin.layouts.DangNhapADM');
    }

    public function login(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required',
            'MatKhau' => 'required'
        ]);
    
        $ql = new QL();
        $user = $ql->DangNhap($request->TenDangNhap, $request->MatKhau);
    
        if ($user) {
    
            $request->session()->put('user', $user);
    
            return redirect()->route('admin.dashboard');
        }
    
        return redirect()->back()->with('error', 'Sai tài khoản hoặc mật khẩu');
    }

function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('admin.login.form')
            ->with('success', 'Đăng xuất thành công.');
    }
}