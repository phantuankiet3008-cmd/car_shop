<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khách hàng</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="form-container">
    <h2>Thêm khách hàng</h2>

    

    <form method="POST" action="{{ url('/trang_admin/khach_hang/them') }}">
        @csrf

        <label>Họ tên</label>
        <input type="text" name="Ho_Ten"  required>

        <label>Email</label>
        <input type="email" name="Email" required>

        <label>Số điện thoại</label>
        <input type="text" name="So_Dien_Thoai" required>

        <label>Địa chỉ</label>
        <input type="text" name="Dia_Chi" required>

        <label>Mật khẩu</label>
        <input type="password" name="Mat_Khau" required>

        <label>Trạng thái</label>
        <select name="Trang_Thai">
            <option value="1" {{ old('Trang_Thai') == 1 ? 'selected' : '' }}>
                Kích hoạt
            </option>
            <option value="0" {{ old('Trang_Thai') == 0 ? 'selected' : '' }}>
                Khoá
            </option>
        </select>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                Lưu khách hàng
            </button>

            <a href="{{ url('/trang_admin/khach_hang') }}" class="btn-back">
                Quay lại
            </a>
        </div>
    </form>
</div>

</body>
</html>
