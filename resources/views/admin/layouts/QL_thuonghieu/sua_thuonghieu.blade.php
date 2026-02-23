<div class="main-content">
    <div class="card">
        <h2 class="page-title">
            SỬA THƯƠNG HIỆU: {{ $data['thuong_hieu']['Ten_Thuong_Hieu'] }}
        </h2>

        <form action="{{ url('/trang_admin/thuong_hieu/sua/' . $data['thuong_hieu']['id_Thuong_Hieu']) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <table class="table-admin">
                <tr>
                    <td style="width:200px;">Tên Thương Hiệu</td>
                    <td>
                        <input type="text"
                               name="ten_thuong_hieu"
                               value="{{ $data['thuong_hieu']['Ten_Thuong_Hieu'] }}"
                               required>
                    </td>
                </tr>

                <tr>
                    <td>Mã Viết Tắt</td>
                    <td>
                        <input type="text"
                               name="ma_thuong_hieu"
                               value="{{ $data['thuong_hieu']['Ma_Thuong_Hieu'] }}"
                               required>
                    </td>
                </tr>

                <tr>
                    <td>Logo</td>
                    <td>
                        <input type="file" name="hinh_anh">
                        <br><br>
                        @if($data['thuong_hieu']['Logo'])
                            <img src="{{ asset('upload/anh_logo/' . $data['thuong_hieu']['Logo']) }}"
                                 width="120"
                                 class="thumb">
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>Trạng Thái</td>
                    <td>
                        <select name="trang_thai">
                            <option value="1"
                                {{ $data['thuong_hieu']['Trang_Thai'] == 1 ? 'selected' : '' }}>
                                Hiện
                            </option>
                            <option value="0"
                                {{ $data['thuong_hieu']['Trang_Thai'] == 0 ? 'selected' : '' }}>
                                Ẩn
                            </option>
                        </select>
                    </td>
                </tr>
            </table>

            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-edit">
                    CẬP NHẬT
                </button>

                <a href="{{ url('/trang_admin/thuong_hieu_xe') }}"
                   class="btn btn-delete">
                    QUAY LẠI
                </a>
            </div>
        </form>
    </div>
</div>
