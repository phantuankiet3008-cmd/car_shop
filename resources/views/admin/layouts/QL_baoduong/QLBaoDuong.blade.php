<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch bảo dưỡng</title>
</head>

<body>

    <h2>Lịch bảo dưỡng</h2>

    <form method="GET">

        <input type="text" name="ten_khach" placeholder="Tên khách" value="{{ request('ten_khach') }}">

        <input type="text" name="sdt" placeholder="Số điện thoại" value="{{ request('sdt') }}">

        <input type="text" name="ten_xe" placeholder="Tên xe" value="{{ request('ten_xe') }}">

        <input type="text" name="goi" placeholder="Gói bảo dưỡng" value="{{ request('goi') }}">

        <input type="date" name="ngay_bao_duong" value="{{ request('ngay_bao_duong') }}">

        <select name="trang_thai">
            <option value="">--Trạng thái--</option>

            <option value="cho_xac_nhan" {{ request('trang_thai')=='cho_xac_nhan' ? 'selected' : '' }}>
                Chờ xác nhận
            </option>

            <option value="da_xac_nhan" {{ request('trang_thai')=='da_xac_nhan' ? 'selected' : '' }}>
                Đã xác nhận
            </option>

            <option value="dang_bao_duong" {{ request('trang_thai')=='dang_bao_duong' ? 'selected' : '' }}>
                Đang bảo dưỡng
            </option>

        </select>

        <button type="submit">Lọc</button>

    </form>

    <p><a href="{{ url('/trang_admin/goibaoduong') }}" class="Gói bảo dưỡng">QUẢN LÝ GÓI BẢO DƯỠNG</a></p>

    <br>

    <table border="1" cellpadding="5">

        <tr>
            <th>ID</th>
            <th>Khách</th>
            <th>SĐT</th>
            <th>Xe</th>
            <th>Màu</th>
            <th>Gói</th>
            <th>Giá</th>
            <th>Ngày bảo dưỡng</th>
            <th>Ghi chú</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Cập nhật</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>

        @foreach($data as $row)

        <tr>
            <td>{{ $row['id_lich'] }}</td>
            <td>{{ $row['Ho_Ten'] }}</td>
            <td>{{ $row['So_Dien_Thoai'] }}</td>
            <td>{{ $row['ten_xe'] }}</td>
            <td>{{ $row['mau_xe'] }}</td>
            <td>{{ $row['ten_goi'] }}</td>
            <td>{{ number_format($row['gia']) }} đ</td>
            <td>{{ $row['ngay_bao_duong'] }}</td>
            <td>{{ $row['ghi_chu'] }}</td>
            <td>{{ $row['trang_thai'] }}</td>
            <td>{{ $row['ngay_tao'] }}</td>
            <td>{{ $row['ngay_cap_nhat'] }}</td>
            <td class="action">
                <a class="btn-edit" href="{{ url('/trang_admin/baoduong/sua/' . $row['id_lich']) }}">
                    Sửa
                </a>

                <a class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
                    href="{{ url('/trang_admin/baoduong/xoa/' . $row['id_lich']) }}">
                    Xóa
                </a>
            </td>
        </tr>

        @endforeach

    </table>

</body>

</html>