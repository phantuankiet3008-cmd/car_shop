<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập nhân viên</title>
    <link rel="stylesheet" href="{{ asset('admin/css/Login.css') }}">

</head>

<body>
    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng nhập nhân viên</h2>
            <div class="auth-box">
                <form method="POST" action="{{ route('staff.login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="SoDIenThoai" placeholder="Số điện thoại" required>
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