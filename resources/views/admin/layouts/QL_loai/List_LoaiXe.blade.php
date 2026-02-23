<div class="main-content">
    <div class="card">
        <h2 class="page-title">DANH SÁCH LOẠI XE</h2>

        <a href="{{ url('/trang_admin/loai_xe/them') }}" class="btn btn-add">
            + Thêm Loại Xe Mới
        </a>

        <table class="table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Loại</th>
                    <th>Ảnh Minh Họa</th>
                    <th>Mô Tả</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>

                @if(isset($data['danh_sach']) && count($data['danh_sach']) > 0)
    @foreach($data['danh_sach'] as $row)

                        <tr>
                             <td>{{ $row['id_Loai_xe']}}</td>
                            <td><strong>{{ $row['Ten_Loai_Xe'] }}</strong></td>
                            <td>
                                <img src="{{ asset('upload/anh_loai/' . $row['Hinh_Anh_Loai']) }}" class="thumb"  width="100">
                            </td>
                            <td>{{ $row['Mo_Ta'] }}</td>
                            <td>
                                @if($row['Trang_Thai'] == 1)
                                    <span style="color:green; font-weight:bold;">Hiện</span>
                                @else
                                    <span style="color:gray;">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/trang_admin/loai_xe/sua/' . $row['id_Loai_xe']) }}"
                                   class="btn btn-edit">Sửa</a>

                                <a href="{{ url('/trang_admin/loai_xe/xoa/' . $row['id_Loai_xe']) }}"
                                   class="btn btn-delete"
                                   onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                                   Xóa
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 30px;">
                            Chưa có dữ liệu nào!
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
