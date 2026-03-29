<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch bảo dưỡng</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 8px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn-edit { color: blue; text-decoration: none; margin-right: 10px; }
        .btn-delete { color: red; text-decoration: none; cursor: pointer; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
    </style>
</head>

<body>

    <h2>Quản lý Lịch bảo dưỡng</h2>

    <form method="GET">
        <input type="text" name="ten_khach" placeholder="Tên khách" value="{{ request('ten_khach') }}">
        <input type="text" name="sdt" placeholder="Số điện thoại" value="{{ request('sdt') }}">
        <input type="text" name="ten_xe" placeholder="Tên xe" value="{{ request('ten_xe') }}">
        <input type="text" name="goi" placeholder="Gói bảo dưỡng" value="{{ request('goi') }}">
        <input type="date" name="ngay_bao_duong" value="{{ request('ngay_bao_duong') }}">

        <select name="trang_thai">
            <option value="">--Tất cả trạng thái--</option>
            <option value="cho_xac_nhan" {{ request('trang_thai')=='cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
            <option value="da_xac_nhan" {{ request('trang_thai')=='da_xac_nhan' ? 'selected' : '' }}>Đã xác nhận</option>
            <option value="dang_bao_duong" {{ request('trang_thai')=='dang_bao_duong' ? 'selected' : '' }}>Đang bảo dưỡng</option>
            <option value="hoan_thanh" {{ request('trang_thai')=='hoan_thanh' ? 'selected' : '' }}>Hoàn thành</option>
            <option value="huy" {{ request('trang_thai')=='huy' ? 'selected' : '' }}>Hủy</option>
        </select>

        <button type="submit">Lọc</button>
        <a href="{{ url('/trang_admin/baoduong') }}"><button type="button">Reset</button></a>
    </form>

    <p>
        <a href="{{ url('/trang_admin/goibaoduong') }}" style="font-weight: bold; color: green;">
            [+] QUẢN LÝ GÓI BẢO DƯỠNG
        </a>
    </p>

    <table border="1">
        <thead>
            <tr style="background-color: #ddd;">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Xe</th>
                <th>Màu</th>
                <th>Gói dịch vụ</th>
                <th>Giá dự kiến</th>
                <th>Ngày hẹn</th>
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
                <td>{{ isset($row['gia']) ? number_format($row['gia']) : 0 }} đ</td>
                <td>{{ date('d/m/Y', strtotime($row['ngay_bao_duong'])) }}</td>
                <td>
                    @if($row['trang_thai'] == 'cho_xac_nhan') Chờ xác nhận
                    @elseif($row['trang_thai'] == 'da_xac_nhan') Đã xác nhận
                    @elseif($row['trang_thai'] == 'dang_bao_duong') Đang bảo dưỡng
                    @elseif($row['trang_thai'] == 'hoan_thanh') Hoàn thành
                    @else Hủy @endif
                </td>
                <td>{{ date('d/m/Y H:i', strtotime($row['ngay_tao'])) }}</td>
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