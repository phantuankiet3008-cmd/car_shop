<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa lịch bảo dưỡng</title>
</head>

<body>
    <h2>Sửa lịch bảo dưỡng</h2>

    @if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="/trang_admin/baoduong/update/{{ $data['baoduong']['id_lich'] }}" method="POST">

        @csrf

        <table border="1" cellpadding="10">

            <tr>
                <td>Khách hàng</td>
                <td>
                    {{ $data['baoduong']['Ho_Ten'] }}
                </td>
            </tr>

            <tr>
                <td>Số điện thoại</td>
                <td>
                    {{ $data['baoduong']['So_Dien_Thoai'] }}
                </td>
            </tr>

            <tr>
                <td>Xe</td>
                <td>
                    {{ $data['baoduong']['Ten_Xe'] }} - {{ $data['baoduong']['Ten_Mau'] }}
                </td>
            </tr>

            <tr>
                <td>Gói bảo dưỡng</td>
                <td>
                    {{ $data['baoduong']['ten_goi'] }}
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
                    <textarea name="ghi_chu" rows="4" cols="40">
{{ $data['baoduong']['ghi_chu'] }}
</textarea>
                </td>
            </tr>

            <tr>
                <td>Trạng thái</td>
                <td>

                    <select name="trang_thai">

                        <option value="0" @if($data['baoduong']['trang_thai']==0) selected @endif>
                            Chờ xác nhận
                        </option>

                        <option value="1" @if($data['baoduong']['trang_thai']==1) selected @endif>
                            Đã xác nhận
                        </option>

                        <option value="2" @if($data['baoduong']['trang_thai']==2) selected @endif>
                            Đang bảo dưỡng
                        </option>

                        <option value="3" @if($data['baoduong']['trang_thai']==3) selected @endif>
                            Hoàn thành
                        </option>

                    </select>

                </td>
            </tr>

            <tr>
                <td></td>
                <td>

                    <button type="submit">
                        Cập nhật
                    </button>

                    <a href="/trang_admin/baoduong">
                        Quay lại
                    </a>

                </td>
            </tr>

        </table>

    </form>
</body>

</html>