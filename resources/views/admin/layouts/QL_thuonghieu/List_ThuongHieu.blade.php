


<div class="main-content">
    <div class="card">
        <h2 class="page-title">DANH SÁCH THƯƠNG HIỆU</h2>

        <a href="{{ url('/trang_admin/thuong_hieu/them') }}" class="btn btn-add">
            + Thêm Thương Hiệu
        </a>

        <table class="table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Tên Thương Hiệu</th>
                    <th>Mã Viết Tắt</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data['danh_sach']) && count($data['danh_sach']) > 0)
                    @foreach($data['danh_sach'] as $row)
                        <tr>
                            <td>{{ $row['id_Thuong_Hieu'] }}</td>

                            <td>
                                <img src="{{ asset('upload/thuong_hieu/' . $row['Logo']) }}"
                                     class="thumb">
                            </td>

                            <td style="font-weight:bold; color:#007bff; font-size:16px;">
                                {{ $row['Ten_Thuong_Hieu'] }}
                            </td>

                            <td>
                                <span style="background:#eee; padding:3px 8px; border-radius:4px;">
                                    {{ $row['Ma_Thuong_Hieu'] }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ url('/trang_admin/thuong_hieu/sua/' . $row['id_Thuong_Hieu']) }}"
                                   class="btn btn-edit">
                                    Sửa
                                </a>

                                <a href="{{ url('/trang_admin/thuong_hieu/xoa/' . $row['id_Thuong_Hieu']) }}"
                                   class="btn btn-delete"
                                   onclick="return confirm('Xóa thương hiệu này?');">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Chưa có thương hiệu nào!
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

