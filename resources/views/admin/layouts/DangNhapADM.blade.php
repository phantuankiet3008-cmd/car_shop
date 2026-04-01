<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="{{ asset('admin/css/Login.css') }}">

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
                <form method="POST" action="/trang_admin/DangNhapADM">
                    @csrf
                    <div class=" form-group">
                        <input type="text" name="TenDangNhap" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>