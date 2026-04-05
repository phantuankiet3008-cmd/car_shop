<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa lịch bảo dưỡng</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <h2>Sửa lịch bảo dưỡng</h2>

    @if(session('error'))
    <p style="color:red; text-align:center">{{ session('error') }}</p>
    @endif

    <form action="/trang_admin/baoduong/update/{{ $data['baoduong']['id_lich'] }}" method="POST">
        @csrf

        <table>

            <tr>
                <td>Khách hàng</td>
                <td>{{ $data['baoduong']['Ho_Ten'] }}</td>
            </tr>

            <tr>
                <td>Số điện thoại</td>
                <td>{{ $data['baoduong']['So_Dien_Thoai'] }}</td>
            </tr>

            <tr>
                <td>Xe</td>
                <td>
                    {{ $data['baoduong']['Ten_Xe'] }} - {{ $data['baoduong']['Ten_Mau'] }}
                </td>
            </tr>

            <!-- ✅ CHO PHÉP CHỌN GÓI -->
            <tr>
                <td>Gói bảo dưỡng</td>
                <td>
                    <select name="id_goi" required>
                        @foreach($data['ds_goi'] as $goi)
                        <option value="{{ $goi['id_goi'] }}" @if($goi['id_goi']==$data['baoduong']['id_goi']) selected
                            @endif>
                            {{ $goi['ten_goi'] }}
                        </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td>Ngày bảo dưỡng</td>
                <td>
                    <input type="date" name="ngay_bao_duong" value="{{ $data['baoduong']['ngay_bao_duong'] }}">
                </td>
            </tr>

            <tr>
                <td>Ghi chú</td>
                <td>
                    <textarea name="ghi_chu" rows="4">
{{ $data['baoduong']['ghi_chu'] }}
</textarea>
                </td>
            </tr>

            <tr>
                <td>Trạng thái</td>
                <td>
                    <select name="trang_thai">
                        <option value="cho_xac_nhan" @if($data['baoduong']['trang_thai']=='cho_xac_nhan' ) selected
                            @endif>
                            Chờ xác nhận
                        </option>

                        <option value="da_xac_nhan" @if($data['baoduong']['trang_thai']=='da_xac_nhan' ) selected
                            @endif>
                            Đã xác nhận
                        </option>

                        <option value="dang_bao_duong" @if($data['baoduong']['trang_thai']=='dang_bao_duong' ) selected
                            @endif>
                            Đang bảo dưỡng
                        </option>

                        <option value="hoan_thanh" @if($data['baoduong']['trang_thai']=='hoan_thanh' ) selected @endif>
                            Hoàn thành
                        </option>
                    </select>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit">Cập nhật</button>
                    <a href="/trang_admin/baoduong">Quay lại</a>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>