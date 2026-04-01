<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý gói bảo dưỡng</title>
    <style>
    /* CSS nội bộ để làm đẹp bảng mà không ảnh hưởng body */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-family: sans-serif;
    }

    th,
    td {
        text-align: left;
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #343a40;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-action {
        text-decoration: none;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.9em;
        font-weight: bold;
    }

    .btn-edit {
        color: #007bff;
        border: 1px solid #007bff;
        margin-right: 5px;
    }

    .btn-edit:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-delete {
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .btn-delete:hover {
        background-color: #dc3545;
        color: white;
    }

    .nav-links a {
        text-decoration: none;
        font-weight: bold;
        margin-right: 20px;
        font-size: 0.9em;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #c3e6cb;
    }
    </style>
</head>

<body>
    @if(session('error'))
    <div style="color: red; font-weight: bold;">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
    @endif
    <h2>Quản lý gói bảo dưỡng</h2>

    <div class="nav-links">
        <a href="{{ url('/trang_admin/baoduong') }}" style="color: #6c757d;">← QUẢN LÝ LỊCH HẸN</a>
        <a href="{{ url('/trang_admin/goibaoduong/them') }}" style="color: #28a745;">[+] THÊM GÓI MỚI</a>
    </div>

    {{-- Thông báo --}}
    @if(session('success'))
    <div class="alert-success" style="margin-top: 15px;">
        {{ session('success') }}
    </div>
    @endif

    <br>

    <h3>Danh sách gói bảo dưỡng</h3>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Tên gói</th>
                <th>Mô tả</th>
                <th style="width: 120px;">Giá</th>
                <th style="width: 150px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($goibaoduong as $goi)
            <tr>
                <td>{{ $goi['id_goi'] }}</td>
                <td><strong>{{ $goi['ten_goi'] }}</strong></td>
                <td style="color: #666; font-size: 0.9em;">{{ $goi['mo_ta'] }}</td>
                <td><b style="color: #d32f2f;">{{ number_format($goi['gia']) }} đ</b></td>
                <td>
                    {{-- nút sửa --}}
                    <a href="{{ url('/trang_admin/goibaoduong/sua/' . $goi['id_goi']) }}"
                        class="btn-action btn-edit">Sửa</a>

                    {{-- nút xóa --}}
                    <a href="{{ url('/trang_admin/goibaoduong/xoa/' . $goi['id_goi']) }}" class="btn-action btn-delete"
                        onclick="return confirm('Bạn có chắc muốn xóa gói: {{ $goi['ten_goi'] }} ?')">
                        Xóa
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>