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


<style>
    body{
    background:#f4f6f9;
    font-family: Arial, Helvetica, sans-serif;
    margin:0;
    padding:0;
}

/* khung profile */
.profile-card{
    max-width:500px;
    width:100%;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

/* avatar */
.avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    display:block;
    margin:0 auto 10px;
    border:4px solid #eaeaea;
}

/* tên */
.profile-name{
    text-align:center;
    font-size:22px;
    font-weight:bold;
}

.profile-phone{
    text-align:center;
    color:#666;
    margin-bottom:25px;
}

/* tiêu đề */
.title{
    font-size:22px;
    margin-bottom:20px;
    text-align:center;
}

/* form */
.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:500;
}

.form-group input{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}

/* focus input */
.form-group input:focus{
    border-color:#0d6efd;
    outline:none;
}

/* nút */
button{
    width:100%;
    padding:12px;
    background:#0d6efd;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.2s;
}

button:hover{
    background:#0b5ed7;
}

/* thông báo */
.alert{
    text-align:center;
    padding:10px;
    background:#d1e7dd;
    color:#0f5132;
    border-radius:6px;
    margin-bottom:15px;
}
</style>

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
               value="{{ $khachhang['Ho_Ten'] }}" required>
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="SoDienThoai"
               value="{{ $khachhang['So_Dien_Thoai'] }}" disabled>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="Email"
               value="{{ $khachhang['Email'] }}" required>
    </div>

    <div class="form-group">
        <label>Địa chỉ</label>
        <input type="text" name="DiaChi"
               value="{{ $khachhang['Dia_Chi'] }}" required>
    </div>

    <div class="form-group">
        <label>Cập nhật avatar</label>
        <input type="file" name="avatar">
    </div>

    <button type="submit" name="update_profile">Cập nhật</button>
</form>

</body>
</html>