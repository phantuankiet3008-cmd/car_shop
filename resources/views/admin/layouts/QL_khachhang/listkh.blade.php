<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khách hàng</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="right_container">
    <div class="header-page">
        <h2>Danh sách khách hàng</h2>
        <a href="{{ url('/trang_admin/khach_hang/them') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Thêm Khách Hàng
        </a>
    </div>

    <div class="search-section">
        <form onsubmit="return redirectSearch(event)" class="search-form">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="keyword" placeholder="Tìm kiếm theo ID, Họ tên, Email..." value="{{ $keyword ?? '' }}">
            </div>
            <button type="submit" class="btn-search">Tìm kiếm</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Thông tin liên hệ</th> <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($data['danh_sach']) && count($data['danh_sach']) > 0)
                @foreach($data['danh_sach'] as $row)
                <tr>
                    <td><span class="badge-id">#{{ $row['id_Khach_Hang'] }}</span></td>
                    <td><strong>{{ $row['Ho_Ten'] }}</strong></td>
                    <td>
                        <div class="contact-info">
                            <span><i class="fa-regular fa-envelope"></i> {{ $row['Email'] }}</span>
                            <span><i class="fa-solid fa-phone"></i> {{ $row['So_Dien_Thoai'] }}</span>
                        </div>
                    </td>
                    <td><span class="text-truncate">{{ $row['Dia_Chi'] }}</span></td>
                    <td>
                        <span class="status-badge {{ $row['Trang_Thai'] == 1 ? 'active' : 'locked' }}">
                            {{ $row['Trang_Thai'] == 1 ? 'Kích hoạt' : 'Khoá' }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y', strtotime($row['Ngay_Tao'])) }}</td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <a href="{{ url('/trang_admin/khach_hang/sua/'.$row['id_Khach_Hang']) }}" class="btn-edit" title="Sửa">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{ url('/trang_admin/khach_hang/xoa/'.$row['id_Khach_Hang']) }}" 
                               class="btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xoá?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Không tìm thấy khách hàng nào</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
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
