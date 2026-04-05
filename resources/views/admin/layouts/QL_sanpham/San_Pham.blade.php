<h2 class="title-page">📦 Danh sách sản phẩm xe</h2>
<div class="filter-section" style="margin-bottom: 20px; background: #f4f4f4; padding: 15px; border-radius: 8px;">
    <form action="{{ url('/trang_admin/san_pham') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search_ten" placeholder="Tìm tên xe..." value="{{ request('search_ten') }}" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">

        <select name="search_loai" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">-- Tất cả loại xe --</option>
            @foreach($data['ds_loai'] as $loai)
                <option value="{{ $loai['id_Loai_xe'] }}" {{ request('search_loai') == $loai['id_Loai_xe'] ? 'selected' : '' }}>
                    {{ $loai['Ten_Loai_Xe'] }}
                </option>
            @endforeach
        </select>

        <select name="search_thuong_hieu" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">-- Tất cả thương hiệu --</option>
            @foreach($data['ds_thuong_hieu'] as $th)
                <option value="{{ $th['id_Thuong_Hieu'] }}" {{ request('search_thuong_hieu') == $th['id_Thuong_Hieu'] ? 'selected' : '' }}>
                    {{ $th['Ten_Thuong_Hieu'] }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-add" style="background-color: #2196F3; margin-top: 0;">🔍 Lọc</button>
        <a href="{{ url('/trang_admin/san_pham') }}" class="btn-edit" style="text-decoration: none; line-height: 25px;">🔄 Reset</a>
    </form>
</div>
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
             src="{{ $row['Anh_Dai_Dien'] }}"
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

