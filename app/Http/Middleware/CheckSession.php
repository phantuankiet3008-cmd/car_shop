<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('admin.login.form')
                ->with('error', 'Vui lòng đăng nhập để truy cập.');
        }

        return $next($request);
    }
}