{{-- thông báo --}}
@php
    $msg = session('msg');
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang người dùng</title>

    <!-- Thêm CSS Laravel -->
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

</head>
<body>

<h2>Thông tin tài khoản</h2>

@if($msg)
    <p class="alert success">{{ $msg }}</p>
@endif

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Họ tên</label>
        <input type="text" name="TenKH"
               value="{{ $khachhang->Ho_Ten }}" required>
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="SoDienThoai"
               value="{{ $khachhang->So_Dien_Thoai }}" disabled>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="Email"
               value="{{ $khachhang->Email }}" required>
    </div>

    <div class="form-group">
        <label>Địa chỉ</label>
        <input type="text" name="DiaChi"
               value="{{ $khachhang->Dia_Chi }}" required>
    </div>

    <div class="form-group">
        <label>Cập nhật avatar</label>
        <input type="file" name="avatar">
    </div>

    <button type="submit" name="update_profile">Cập nhật</button>
</form>

</body>
</html>