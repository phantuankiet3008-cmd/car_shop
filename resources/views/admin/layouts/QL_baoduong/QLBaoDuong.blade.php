<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch bảo dưỡng</title>
    <style>
    /* Chỉ tác động vào các thành phần bên trong trang quản lý này */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: sans-serif;
    }

    th,
    td {
        text-align: left;
        padding: 12px 8px;
        border: 1px solid #ddd;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit {
        color: #007bff;
        text-decoration: none;
        margin-right: 10px;
        font-weight: bold;
    }

    .btn-delete {
        color: #dc3545;
        text-decoration: none;
        cursor: pointer;
        font-weight: bold;
    }

    /* Badge trạng thái */
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: bold;
        color: white;
        display: inline-block;
    }

    .bg-warning {
        background-color: #ffc107;
        color: #212529;
    }

    /* Chờ xác nhận */
    .bg-info {
        background-color: #17a2b8;
    }

    /* Đã xác nhận */
    .bg-primary {
        background-color: #007bff;
    }

    /* Đang bảo dưỡng */
    .bg-success {
        background-color: #28a745;
    }

    /* Hoàn thành */
    .bg-danger {
        background-color: #dc3545;
    }

    /* Hủy */

    .filter-form {
        margin-bottom: 20px;
        background: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
    }

    .filter-form input,
    .filter-form select {
        padding: 6px;
        margin-right: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-filter {
        background-color: #333;
        color: white;
        border: none;
        padding: 7px 15px;
        cursor: pointer;
        border-radius: 4px;
    }


    .note-cell {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }

    .note-cell:hover {
        white-space: normal;
        background: #fff3cd;
    }
    </style>
</head>

<body>
    @if(session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="color: red; font-weight: bold;">
        {{ session('error') }}
    </div>
    @endif
    <h2>Quản lý Lịch bảo dưỡng</h2>

    <div class="filter-form">
        <form method="GET">
            <input type="text" name="ten_khach" placeholder="Tên khách" value="{{ request('ten_khach') }}">
            <input type="text" name="sdt" placeholder="Số điện thoại" value="{{ request('sdt') }}">
            <input type="text" name="ten_xe" placeholder="Tên xe" value="{{ request('ten_xe') }}">
            <input type="text" name="goi" placeholder="Gói bảo dưỡng" value="{{ request('goi') }}">
            <input type="date" name="ngay_bao_duong" value="{{ request('ngay_bao_duong') }}">

            <select name="trang_thai">
                <option value="">--Tất cả trạng thái--</option>
                <option value="cho_xac_nhan" {{ request('trang_thai')=='cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận
                </option>
                <option value="da_xac_nhan" {{ request('trang_thai')=='da_xac_nhan' ? 'selected' : '' }}>Đã xác nhận
                </option>
                <option value="dang_bao_duong" {{ request('trang_thai')=='dang_bao_duong' ? 'selected' : '' }}>Đang bảo
                    dưỡng</option>
                <option value="hoan_thanh" {{ request('trang_thai')=='hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                </option>
                <option value="huy" {{ request('trang_thai')=='huy' ? 'selected' : '' }}>Hủy</option>
            </select>

            <button type="submit" class="btn-filter">Lọc</button>
            <a href="{{ url('/trang_admin/baoduong') }}"><button type="button" style="cursor:pointer">Reset</button></a>
        </form>
    </div>

    <p>
        <a href="{{ url('/trang_admin/goibaoduong') }}"
            style="text-decoration: none; font-weight: bold; color: #28a745;">
            [+] QUẢN LÝ GÓI BẢO DƯỠNG
        </a>
    </p>

    <table>
        <thead>
            <tr style="background-color: #343a40; color: white;">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Xe</th>
                <th>Màu</th>
                <th>Gói dịch vụ</th>
                <th>Giá dự kiến</th>
                <th>Ngày hẹn</th>
                <th>Ghi chú</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row['id_lich'] }}</td>
                <td><strong>{{ $row['Ho_Ten'] }}</strong></td>
                <td>{{ $row['So_Dien_Thoai'] }}</td>
                <td>{{ $row['ten_xe'] }}</td>
                <td>{{ $row['mau_xe'] }}</td>
                <td>{{ $row['ten_goi'] }}</td>
                <td><b style="color: #d32f2f;">{{ isset($row['gia']) ? number_format($row['gia']) : 0 }} đ</b></td>
                <td>{{ date('d/m/Y', strtotime($row['ngay_bao_duong'])) }}</td>
                <td class="note-cell">
                    {{ $row['ghi_chu'] ?? '-' }}
                </td>

                <td>
                    @if($row['trang_thai'] == 'cho_xac_nhan')
                    <span class="status-badge bg-warning">Chờ xác nhận</span>
                    @elseif($row['trang_thai'] == 'da_xac_nhan')
                    <span class="status-badge bg-info">Đã xác nhận</span>
                    @elseif($row['trang_thai'] == 'dang_bao_duong')
                    <span class="status-badge bg-primary">Đang bảo dưỡng</span>
                    @elseif($row['trang_thai'] == 'hoan_thanh')
                    <span class="status-badge bg-success">Hoàn thành</span>
                    @else
                    <span class="status-badge bg-danger">Hủy</span>
                    @endif
                </td>
                <td style="font-size: 0.85em; color: #666;">{{ date('d/m/Y H:i', strtotime($row['ngay_tao'])) }}</td>
                <td>
                    <a class="btn-edit" href="{{ url('/trang_admin/baoduong/sua/' . $row['id_lich']) }}">Sửa</a>
                    <a class="btn-delete" onclick="return confirm('Xóa lịch hẹn của khách {{ $row['Ho_Ten'] }}?')"
                        href="{{ url('/trang_admin/baoduong/xoa/' . $row['id_lich']) }}">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>