<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm nhân viên</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <div class="right_container">
        <h2>Thêm nhân viên</h2>

        <form method="POST" action="{{ url('/trang_admin/nhan_vien/them') }}">
            @csrf

            <label>Họ tên</label>
            <input type="text" name="Ho_Ten" required>

            <label>Username</label>
            <input type="text" name="UserName" required>

            <label>Email</label>
            <input type="email" name="Email" required>

            <label>Số điện thoại</label>
            <input type="text" name="So_Dien_Thoai">

            <label>Mật khẩu</label>
            <input type="password" name="MatKhau" required>

            <label>Vai trò</label>
            <select name="role_id" required>
                <option value="">-- Chọn vai trò --</option>
                <option value="1">Admin</option>
                <option value="2">Nhân viên</option>
                <option value="3">Kế toán</option>
                <option value="4">Kỹ thuật</option>
            </select>

            <label>Trạng thái</label>
            <select name="Trang_Thai">
                <option value="1">Kích hoạt</option>
                <option value="0">Khoá</option>
            </select>

            <br><br>

            <button type="submit">Thêm</button>
            <a href="{{ url('/trang_admin/nhan_vien') }}">
                <button type="button">Quay lại</button>
            </a>
        </form>
    </div>

</body>

</html>