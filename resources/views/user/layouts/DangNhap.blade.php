<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('user/css/login_user.css') }}">
</head>

<body>

    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng nhập</h2>

            {{-- Hiển thị lỗi --}}
            @if(session('error'))
            <p style="color:red; text-align:center;">
                {{ session('error') }}
            </p>
            @endif

            {{-- Hiển thị lỗi validate --}}
            @if ($errors->any())
            <div style="color:red; text-align:center;">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div class="auth-box">
                <form method="POST" action="{{ url('/car_shop/dangnhap') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="SDT" placeholder="Số điện thoại" value="{{ old('SDT') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                    </div>

                    <button type="submit" class="btn">Đăng nhập</button>

                    <p class="link-text">
                        Chưa có tài khoản?
                        <a href="{{ url('/car_shop/dangky') }}">Đăng KÝ</a>
                    </p>

                    <p class="link-text">
                        Quên mật khẩu
                        <a href="{{ url('/car_shop/quenmk') }}">Quên Mật Khẩu</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>