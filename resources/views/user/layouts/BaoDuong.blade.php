<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lịch bảo dưỡng</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f7fa;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1000px;
        margin: 30px auto;
        background: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    h3 {
        margin-top: 25px;
        border-left: 5px solid #3498db;
        padding-left: 10px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        transition: 0.2s;
        background: #fafafa;
    }

    .card:hover {
        border-color: #3498db;
        transform: translateY(-3px);
    }

    .card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 6px;
    }

    .card p {
        margin: 5px 0;
    }

    .card input {
        margin-bottom: 8px;
    }

    .note {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-top: 10px;
    }

    .date {
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-top: 10px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #3498db;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 8px;
        margin-top: 20px;
        cursor: pointer;
    }

    button:hover {
        background: #2980b9;
    }
    </style>
</head>

<body>

    <div class="container">

        <h2>ĐẶT LỊCH BẢO DƯỠNG</h2>

        <form method="POST" action="user/car_shop/dat_bao_duong">
            @csrf

            <h3>Chọn xe</h3>
            <div class="grid">
                @foreach($ds_xe as $xe)
                <label class="card">
                    <input type="radio" name="id_xe" value="{{ $xe->id_Xe_Mau }}" required>

                    <img src="{{ asset('images/' . $xe->hinh_anh) }}">

                    <p><b>{{ $xe->ten_xe }}</b></p>
                    <p>Hãng: {{ $xe->ten_thuong_hieu }}</p>
                    <p>Loại: {{ $xe->ten_loai }}</p>
                </label>
                @endforeach
            </div>

            <h3>Chọn gói bảo dưỡng</h3>
            <div class="grid">
                @foreach($goi_bao_duong as $goi)
                <label class="card">
                    <input type="radio" name="id_goi" value="{{ $goi['id_goi'] }}" required>

                    <p><b>Tên gói:</b> {{ $goi['ten_goi'] }}</p>
                    <p><b>Mô tả:</b> {{ $goi['mo_ta'] }}</p>
                    <p><b>Giá:</b> {{ number_format($goi['gia']) }} VNĐ</p>
                </label>
                @endforeach
            </div>

            <h3>Ghi chú</h3>
            <textarea class="note" name="ghi_chu" placeholder="Nhập ghi chú nếu có..."></textarea>

            <h3>Chọn ngày</h3>
            <input class="date" type="date" name="ngay_bao_duong" required>

            <button type="submit">Đặt lịch</button>

        </form>

    </div>

</body>

</html>