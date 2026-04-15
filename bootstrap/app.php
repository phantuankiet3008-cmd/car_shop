<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
// Import các class middleware để dùng ::class bên dưới (tùy chọn nhưng nên làm)
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\UserAuth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            
            Route::middleware('web')->group(base_path('routes/user_chitiet.php'));
        },
        
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.session' => CheckSession::class,
            'role'          => CheckRole::class, // Đã sửa: Chỉ trỏ đến Class
            'user.auth'     => UserAuth::class,
        ]);
    })
   
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();