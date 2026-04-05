<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="{{ asset('admin/css/Login.css') }}">
    <style>
    /* CSS bổ sung để hiển thị thông báo */
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .error-text {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    </style>
</head>

<body>

    @if(session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert-error">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif
    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng nhập Admin</h2>

            <div class="auth-box">

            <div class="auth-box"> 
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="TenDangNhap" placeholder="Tên đăng nhập"
                            value="{{ old('TenDangNhap') }}" required>
                        @error('TenDangNhap')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                        @error('MatKhau')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn">Đăng nhập</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>