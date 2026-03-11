@extends('user.layouts.user_index')
    <style>
        .user_table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.user_table th {
    background: #f4f4f4;
    padding: 10px;
    text-align: left;
}

.user_table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}
    </style>
 

    
@section('content')
<h2>Lịch lái thử của tôi</h2>

<table class="user_table">
    <tr>
        <th>ID</th>
        <th>Tên xe</th>
        <th>Màu</th>
        <th>Ngày</th>
        <th>Khung giờ</th>
        <th>Trạng thái</th>
    </tr>

    @if($danh_sach)
        @while($danhSach = $danh_sach->fetch_assoc())
        <tr>
            <td>{{ $danhSach['id_Dat_Lich'] }}</td>
            <td>{{ $danhSach['Ten_Xe'] }}</td>
            <td>{{ $danhSach['Ten_Mau'] }}</td>
            <td>{{ $danhSach['Ngay_Lai_Thu'] }}</td>
            <td>{{ $danhSach['Khung_Gio'] }}</td>
            <td>
                @if($danhSach['Trang_Thai'] == 0)
                    <span class="status_wait">Chờ duyệt</span>
                @elseif($danhSach['Trang_Thai'] == 1)
                    <span class="status_success">Đã duyệt</span>
                @else
                    <span class="status_cancel">Đã hủy</span>
                @endif
            </td>
        </tr>
        @endwhile
    @endif
</table>

{{-- Thông báo lỗi --}}
@if(session('error'))
    <div style="color: white; background: #e74c3c; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif
{{-- Thông báo thành công --}}
@if(session('success'))
    <div style="color: white; background: #2ecc71; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

@endsection
