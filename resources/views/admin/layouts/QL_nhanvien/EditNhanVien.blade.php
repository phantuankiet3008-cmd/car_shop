<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa nhân viên</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>/* Container chính */
.right_container {
    width: 100%;
    max-width: 1000px;
    margin: 40px auto;
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    font-family: 'Inter', sans-serif;
}

/* Tiêu đề */
.right_container h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 30px;
    border-left: 5px solid #6366f1;
    padding-left: 15px;
    text-transform: uppercase;
}

/* Form layout */
.right_container form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 25px;
}

/* Label */
.right_container label {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 5px;
}

/* Input + Select */
.right_container input,
.right_container select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    background: #fcfcfc;
    transition: all 0.3s;
}

/* Focus đẹp */
.right_container input:focus,
.right_container select:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
    outline: none;
}

/* Email riêng cho chắc */
.right_container input[type="email"] {
    letter-spacing: 0.5px;
}

/* Mật khẩu */
.right_container input[type="password"] {
    font-style: italic;
}

/* Nút */
.right_container button {
    padding: 14px 25px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

/* Nút cập nhật */
.right_container button[type="submit"] {
    background: #6366f1;
    color: white;
}

.right_container button[type="submit"]:hover {
    background: #4f46e5;
    box-shadow: 0 8px 15px rgba(99,102,241,0.3);
}

/* Nút quay lại */
.right_container a button {
    background: #e2e8f0;
    color: #1e293b;
}

.right_container a button:hover {
    background: #cbd5f5;
}

/* Khoảng cách 2 nút */
.right_container form button,
.right_container form a {
    margin-top: 10px;
}

/* Làm 2 nút nằm cùng hàng */
.right_container form button[type="submit"] {
    grid-column: span 1;
}

.right_container form a {
    grid-column: span 1;
}

/* Responsive */
@media (max-width: 768px) {
    .right_container form {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

    @php
    $nhan_vien = $data['nhan_vien'];
    @endphp

    <div class="right_container">
        <h2>Sửa nhân viên</h2>

        <form method="POST" action="{{ url('/trang_admin/nhan_vien/sua/'.$nhan_vien['id_Ad']) }}">
            @csrf

            <label>Họ tên</label>
            <input type="text" name="Ho_Ten" value="{{ $nhan_vien['Ho_Ten'] }}" required>

            <label>Username</label>
            <input type="text" name="UserName" value="{{ $nhan_vien['UserName'] }}" required>

            <label>Email</label>
            <input type="email" name="Email" value="{{ $nhan_vien['Email'] }}" required>

            <label>Số điện thoại</label>
            <input type="text" name="So_Dien_Thoai" value="{{ $nhan_vien['So_Dien_Thoai'] }}">

            <label>Mật khẩu (bỏ trống nếu không đổi)</label>
            <input type="password" name="MatKhau">

            <label>Vai trò</label>
            <select name="role_id">
                <option value="1" {{ $nhan_vien['role_id'] == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $nhan_vien['role_id'] == 2 ? 'selected' : '' }}>Nhân viên</option>
                <option value="3" {{ $nhan_vien['role_id'] == 3 ? 'selected' : '' }}>Kế toán</option>
                <option value="4" {{ $nhan_vien['role_id'] == 4 ? 'selected' : '' }}>Kỹ thuật</option>
            </select>

            <label>Trạng thái</label>
            <select name="Trang_Thai">
                <option value="1" {{ $nhan_vien['Trang_Thai'] == 1 ? 'selected' : '' }}>Kích hoạt</option>
                <option value="0" {{ $nhan_vien['Trang_Thai'] == 0 ? 'selected' : '' }}>Khoá</option>
            </select>

            <br><br>

            <button type="submit">Cập nhật</button>

            <a href="{{ url('/trang_admin/nhan_vien') }}">
                <button type="button">Quay lại</button>
            </a>
        </form>
    </div>

</body>

</html>