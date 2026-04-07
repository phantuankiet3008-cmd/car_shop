<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <title>Thêm khách hàng</title>
 <style> body{ font-family: Arial; padding: 20px; } input, textarea { width: 100%; margin-bottom: 10px; padding: 8px; } </style>
</head>
<body>
<div class="admin-form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-user-plus"></i> Thêm Khách Hàng Mới</h2>
        <p>Tạo tài khoản mới cho khách hàng tham gia hệ thống mua sắm.</p>
    </div>

    <form method="POST" action="{{ url('/trang_admin/khach_hang/them') }}">
        @csrf

        <div class="input-group full-width">
            <label>Họ và tên</label>
            <input type="text" name="Ho_Ten" placeholder="Nhập đầy đủ họ tên khách hàng" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="Email" placeholder="example@gmail.com" required>
        </div>

        <div class="input-group">
            <label>Số điện thoại</label>
            <input type="text" name="So_Dien_Thoai" placeholder="Nhập số điện thoại liên lạc" required>
        </div>

        <div class="input-group full-width">
            <label>Địa chỉ thường trú</label>
            <input type="text" name="Dia_Chi" placeholder="Số nhà, tên đường, quận/huyện..." required>
        </div>

        <div class="input-group">
            <label>Mật khẩu đăng nhập</label>
            <input type="password" name="Mat_Khau" placeholder="Thiết lập mật khẩu tạm thời" required>
        </div>

        <div class="input-group">
            <label>Trạng thái tài khoản</label>
            <select name="Trang_Thai">
                <option value="1" {{ old('Trang_Thai') == 1 ? 'selected' : '' }}>Kích hoạt (Cho phép đăng nhập)</option>
                <option value="0" {{ old('Trang_Thai') == 0 ? 'selected' : '' }}>Khoá (Tạm dừng hoạt động)</option>
            </select>
        </div>

        <div class="form-actions full-width">
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> LƯU KHÁCH HÀNG
            </button>
            <a href="{{ url('/trang_admin/khach_hang') }}" class="btn-cancel">HỦY BỎ</a>
        </div>
    </form>
</div>