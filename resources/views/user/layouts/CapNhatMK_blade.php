<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('user/css/Login_user.css') }}">
</head>

<body>

    <div class="auth-page">
        <div class="auth-container">
            <h2>Cập nhật mật khẩu mới</h2>

            {{-- Thông báo thành công --}}
            @if(session('success'))
            <p class="msg" style="color:green;">
                {{ session('success') }}
            </p>
            @endif

            {{-- Thông báo lỗi --}}
            @if(session('error'))
            <p class="msg" style="color:red;">
                {{ session('error') }}
            </p>
            @endif

            {{-- Hiển thị lỗi validate --}}
            @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.reset.process') }}">
                @csrf

                {{-- truyền số điện thoại ẩn --}}
                <input type="hidden" name="phone" value="{{ $phone ?? '' }}">

                <div class="form-group">
                    <input type="password" name="password" placeholder="Mật khẩu mới" required>

                    <br><br>

                    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>

                    <br><br>

                    <button type="submit" class="btn">
                        Cập nhật
                    </button>
                </div>
            </form>

            <p>
                <a href="{{ route('login.form') }}">
                    Quay lại đăng nhập
                </a>
            </p>

        </div>
    </div>

</body>

</html>