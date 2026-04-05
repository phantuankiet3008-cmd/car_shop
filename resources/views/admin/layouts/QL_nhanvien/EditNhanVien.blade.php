<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa nhân viên</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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