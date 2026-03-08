<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý gói bảo dưỡng</title>
</head>

<body>

    <h2>Quản lý gói bảo dưỡng</h2>
    <p><a href="{{ url('/trang_admin/baoduong') }}" class="Gói bảo dưỡng">QUẢN LÝ BẢO DƯỠNG</a></p>
    <p><a href="{{ url('/trang_admin/goibaoduong/them') }}" class="Thêm gói bảo dưỡng">THÊM GÓI BẢO DƯỠNG</a></p>
    {{-- Thông báo --}}
    @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif


    <br><br>

    <h3>Danh sách gói bảo dưỡng</h3>

    <table border="1" cellpadding="5">

        <tr>
            <th>ID</th>
            <th>Tên gói</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Thao tác</th>
        </tr>

        @foreach($goibaoduong as $goi)

        <tr>
            <td>{{ $goi->id }}</td>
            <td>{{ $goi->ten_goi }}</td>
            <td>{{ $goi->mo_ta }}</td>
            <td>{{ number_format($goi->gia) }} đ</td>

            <td>

                {{-- nút sửa --}}
                <a href="?edit={{ $goi->id }}">Sửa</a>

                {{-- nút xóa --}}
                <a href="/trang_admin/goibaoduong/xoa/{{ $goi->id }}" onclick="return confirm('Bạn có chắc muốn xóa?')">
                    Xóa
                </a>
                @endforeach

    </table>

</body>

</html>