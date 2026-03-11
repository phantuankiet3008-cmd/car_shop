<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('user/css/baoduong_user.css') }}">
</head>

<body>
    <h2>GÓI BẢO DƯỠNG XE</h2>

    @foreach($goi_bao_duong as $goi)

    <h3>{{ $goi['ten_goi'] }}</h3>

    <p>{{ $goi['mo_ta'] }}</p>

    <p>Giá: {{ number_format($goi['gia']) }} VNĐ</p>

    <form method="POST" action="/car_shop/dat_bao_duong">
        @csrf

        <input type="hidden" name="id_goi" value="{{ $goi['id_goi'] }}">

        <label>Ngày bảo dưỡng:</label>
        <input type="date" name="ngay_bao_duong" required>

        <button type="submit">Đặt lịch</button>

    </form>

    </div>

    @endforeach
</body>

</html>