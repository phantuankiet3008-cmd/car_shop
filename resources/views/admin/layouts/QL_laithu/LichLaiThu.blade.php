<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('admin/css/datlich.css') }}">
</head>
<body>
    

<form method="GET"action="{{ url('/trang_admin/lai_thu') }}"class="filter_form">
    <input type="date" name="ngay">

    <input type="text" name="ten_khach" placeholder="Tên khách">

    <select name="trang_thai">
        <option value="">-- Trạng thái --</option>
        <option value="0">Chờ duyệt</option>
        <option value="1">Đã duyệt</option>
        <option value="2">Đã hủy</option>
    </select>

    <button type="submit">Lọc</button>
</form>
    <table class="admin_table">
    <tr>
        <th>ID</th>
        <th>Tên khách</th>
        <th>SĐT</th>
        <th>Tên xe</th>
        <th>Màu</th>
        <th>Ngày</th>
        <th>Khung giờ</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    @if($data['danh_sach'])
        @while($row = $data['danh_sach']->fetch_assoc())
        <tr>
            <td>{{ $row['id_Dat_Lich'] }}</td>
            <td>{{ $row['Ho_Ten'] }}</td>
            <td>{{ $row['So_Dien_Thoai'] }}</td>
            <td>{{ $row['Ten_Xe'] }}</td>
            <td>{{ $row['Ten_Mau'] }}</td>
            <td>{{ $row['Ngay_Lai_Thu'] }}</td>
            <td>{{ $row['Khung_Gio'] }}</td>
            <td>
            @if($row['Trang_Thai'] == 0)
            <span class="status_wait">Chờ duyệt</span>
            @elseif($row['Trang_Thai'] == 1)
            <span class="status_success">Đã duyệt</span>
            @else
            <span class="status_cancel">Đã hủy</span>
            @endif
            </td>
            <td>
            <a class="action_link"
            href="{{ url('/trang_admin/lai_thu/cap-nhat/'.$row['id_Dat_Lich'].'/1') }}">
            Duyệt</a>
            <a class="action_link"
            href="{{ url('/trang_admin/lai_thu/cap-nhat/'.$row['id_Dat_Lich'].'/2') }}">
            Hủy</a>
            <a class="action_link"
            href="{{ url('/trang_admin/lai_thu/xoa/'.$row['id_Dat_Lich']) }}"
            onclick="return confirm('Xóa lịch này?')">
            Xóa</a>
            </td>
        </tr>
        @endwhile
    @endif
</table>
</body>
</html>