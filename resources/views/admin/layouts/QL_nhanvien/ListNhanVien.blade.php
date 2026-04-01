<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách nhân viên</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <div class="right_container">
        <h2>Danh sách nhân viên</h2>

        <!-- Nút thêm -->
        <a href="{{ url('/trang_admin/nhan_vien/them') }}" class="btn-add">
            ➕ Thêm Nhân Viên
        </a>

        <!-- FORM FILTER -->
        <form method="GET">
            <input type="text" name="search_ten" placeholder="Tìm theo tên..." value="{{ $filters['ten'] ?? '' }}">

            <input type="text" name="search_email" placeholder="Tìm theo email..."
                value="{{ $filters['email'] ?? '' }}">

            <select name="search_role">
                <option value="">-- Vai trò --</option>
                <option value="1" {{ ($filters['role'] ?? '') == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ ($filters['role'] ?? '') == 2 ? 'selected' : '' }}>Nhân viên</option>
                <option value="3" {{ ($filters['role'] ?? '') == 3 ? 'selected' : '' }}>Kế toán</option>
                <option value="4" {{ ($filters['role'] ?? '') == 4 ? 'selected' : '' }}>Kỹ thuật</option>
            </select>

            <button type="submit">Lọc</button>
        </form>

        <br>

        <!-- TABLE -->
        <table class="table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @if(!empty($data['danh_sach']))

                @foreach($data['danh_sach'] as $row)
                <tr>
                    <td>{{ $row['id_Ad'] }}</td>
                    <td>{{ $row['Ho_Ten'] }}</td>
                    <td>{{ $row['Email'] }}</td>
                    <td>{{ $row['So_Dien_Thoai'] }}</td>

                    <!-- ROLE -->
                    <td>
                        {{ $row['ten_role'] ?? 'Không rõ' }}
                    </td>

                    <!-- TRẠNG THÁI -->
                    <td>
                        {{ $row['Trang_Thai'] == 1 ? 'Kích hoạt' : 'Khoá' }}
                    </td>

                    <td>{{ $row['created_at'] }}</td>

                    <!-- ACTION -->
                    <td>
                        <a href="{{ url('/trang_admin/nhan_vien/sua/'.$row['id_Ad']) }}">
                            <button type="button">Sửa</button>
                        </a>

                        <a href="{{ url('/trang_admin/nhan_vien/xoa/'.$row['id_Ad']) }}"
                            onclick="return confirm('Bạn có chắc muốn xoá?');">
                            <button type="button">Xoá</button>
                        </a>
                    </td>
                </tr>
                @endforeach

                @else
                <tr>
                    <td colspan="8">Không có nhân viên nào</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</body>

</html>