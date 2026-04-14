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

.status_cancel {
    color: white;
    background: #e74c3c;
    padding: 4px 8px;
    border-radius: 4px;
}

.btn-huy {
    background-color: #e74c3c;
    /* đỏ */
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-huy:hover {
    background-color: #c0392b;
}

.btn-huy:active {
    transform: scale(0.95);
}

.btn-huy:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>




<h2>Lịch bảo dưỡng của tôi</h2>

<table class="user_table">
    <tr>
        <th>ID</th>
        <th>Tên xe</th>
        <th>Màu</th>
        <th>Tên gói</th>
        <th>Giá</th>
        <th>Ngày</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    @if($danh_sach)
    @while($danhSach = $danh_sach->fetch_assoc())
    <tr>
        <td>{{ $danhSach['id_lich'] }}</td>
        <td>{{ $danhSach['Ten_Xe'] }}</td>
        <td>{{ $danhSach['Ten_Mau'] }}</td>
        <td>{{ $danhSach['ten_goi'] }}</td>
        <td>{{ $danhSach['gia'] }}</td>
        <td>{{ $danhSach['ngay_bao_duong'] }}</td>
        <td>
            @if($danhSach['trang_thai'] == 'cho_xac_nhan')
            <span class="status_wait">Chờ xác nhận</span>
            @elseif($danhSach['trang_thai'] == 'da_xac_nhan')
            <span class="status_success">Đã xác nhận</span>
            @elseif($danhSach['trang_thai'] == 'dang_bao_duong')
            <span class="status_success">Đang bảo dưỡng</span>
            @elseif($danhSach['trang_thai'] == 'hoan_thanh')
            <span class="status_success">Hoàn thành</span>
            @else($danhSach['trang_thai'] == 'huy')
            <span class="status_cancel">Đã hủy</span>

            @endif
        </td>
        <td>
            @if($danhSach['trang_thai'] == 'cho_xac_nhan')
            <form method="POST" action="{{ url('/user/car_shop/huy_bao_duong/'.$danhSach['id_lich']) }}">
                @csrf
                <button type="submit" class="btn-huy">Hủy</button>
            </form>
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