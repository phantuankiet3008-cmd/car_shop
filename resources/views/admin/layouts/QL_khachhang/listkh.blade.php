<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khách hàng</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="right_container">
    <h2>Danh sách khách hàng</h2>

    <a href="{{ url('/trang_admin/khach_hang/them') }}" class="btn-add">
        ➕ Thêm Khách Hàng
    </a>

   <form onsubmit="return redirectSearch(event)">
    <input type="text"
           id="keyword"
           placeholder="Tìm kiếm theo ID, Họ tên, Email..."
           value="{{ $keyword ?? '' }}">

    <button type="submit">Tìm kiếm</button>
</form>
    <br>

    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Mật khẩu</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
        @if(!empty($data['danh_sach']) && count($data['danh_sach']) > 0)

            @foreach($data['danh_sach'] as $row)
            <tr>
                <td>{{ $row['id_Khach_Hang'] }}</td>
                <td>{{ $row['Ho_Ten'] }}</td>
                <td>{{ $row['Email'] }}</td>
                <td>{{ $row['So_Dien_Thoai'] }}</td>
                <td>{{ $row['Dia_Chi'] }}</td>
                <td>{{ $row['Mat_Khau'] }}</td>
                <td>
                    {{ $row['Trang_Thai'] == 1 ? 'Kích hoạt' : 'Khoá' }}
                </td>
                <td>{{ $row['Ngay_Tao'] }}</td>
                <td>{{ $row['Ngay_Cap_Nhat'] }}</td>

                <td>
                    <a href="{{ url('/trang_admin/khach_hang/sua/'.$row['id_Khach_Hang']) }}">
                        <button type="button">Sửa</button>
                    </a>

                    <a href="{{ url('/trang_admin/khach_hang/xoa/'.$row['id_Khach_Hang']) }}"
                       onclick="return confirm('Bạn có chắc muốn xoá?');">
                        <button type="button">Xoá</button>
                    </a>
                </td>
            </tr>
            @endforeach

        @else
            <tr>
                <td colspan="10">Không tìm thấy khách hàng nào</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<script>
function redirectSearch(event) {
    event.preventDefault();

    let keyword = document.getElementById('keyword').value;

    if(keyword.trim() !== "") {
        window.location.href = "/trang_admin/khach_hang/tim/" + keyword;
    } else {
        window.location.href = "/trang_admin/khach_hang";
    }
}
</script>
</body>
</html>
