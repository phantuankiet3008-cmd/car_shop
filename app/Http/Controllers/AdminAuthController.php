<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QL;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.layouts.DangNhapADM');
    }

    public function login(Request $request)
{
    $TenDangNhap = $request->TenDangNhap;
    $MatKhau     = $request->MatKhau;

    $ql = new QL(); // ✅ THÊM DÒNG NÀY
    $login = $ql->dang_nhap_ADM($TenDangNhap, $MatKhau);

    if ($login) {
        session([
            'admin' => [
                'username' => $TenDangNhap,
                
            ]
        ]);

        return redirect('/trang_admin');
    }

    return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
}
}
