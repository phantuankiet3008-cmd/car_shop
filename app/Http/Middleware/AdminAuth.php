<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin')) {
            return redirect('/trang_admin/DangNhapADM');
        }

        return $next($request);
    }
}
