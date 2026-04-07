<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole 
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->session()->get('user');

        if (!$user) {
            return redirect()->route('admin.login.form')->with('error', 'Vui lòng đăng nhập.');
        }

        $userRole = (string)($user['role_id'] ?? '');

        if (!in_array($userRole, $roles)) {
            abort(403, 'Bạn không có quyền truy cập vào chức năng này.');
        }

        return $next($request);
    }
}