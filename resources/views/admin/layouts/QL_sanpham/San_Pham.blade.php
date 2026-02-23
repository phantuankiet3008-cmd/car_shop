<h2 class="title-page">📦 Danh sách sản phẩm xe</h2>

<a href="{{ url('/trang_admin/san_pham/them') }}" class="btn-add">
    ➕ Thêm sản phẩm
</a>

@if (!isset($data['danh_sach']) || $data['danh_sach']->num_rows == 0)
    <p>Không có sản phẩm nào.</p>
@else

<table class="table-admin">
    <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên xe</th>
        <th>Loại xe</th>
        <th>Thương hiệu</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

@while ($row = $data['danh_sach']->fetch_assoc())
<tr>
    <td>{{ $row['id_Xe'] }}</td>

    <td>
        <img class="img-xe"
             src="{{ asset('upload/anh_dai_dien/' . $row['Anh_Dai_Dien']) }}"
             style="width:100px; height:auto;">
    </td>

    <td>{{ $row['Ten_Xe'] }}</td>
    <td>{{ $row['Ten_Loai_Xe'] }}</td>
    <td>{{ $row['Ten_Thuong_Hieu'] }}</td>

    <td>
        {!! $row['Trang_Thai'] ? '🟢 Hiện' : '🔴 Ẩn' !!}
    </td>

    <td class="action.">
        <a class="btn-edit"
           href="{{ url('/trang_admin/san_pham/sua/' . $row['id_Xe']) }}">
            Sửa
        </a>

        <a class="btn-delete"
           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
           href="{{ url('/trang_admin/san_pham/xoa/' . $row['id_Xe']) }}">
            Xóa
        </a>
    </td>
</tr>
@endwhile

</table>
@endif
