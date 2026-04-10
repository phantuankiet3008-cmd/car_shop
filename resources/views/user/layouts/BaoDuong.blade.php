@extends('user.layouts.user_index')
@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lịch bảo dưỡng</title>

    {{-- Link FontAwesome để hiện icon check khi chọn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Sử dụng Scope CSS để không ảnh hưởng layout chung */
        .booking-service-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 25px;
            background: #fdfdfd;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .booking-service-wrapper h2 {
            text-align: center;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .booking-service-wrapper h3 {
            color: #34495e;
            border-left: 5px solid #e74c3c;
            padding-left: 15px;
            margin: 30px 0 20px;
            font-size: 1.3rem;
        }

        .booking-service-wrapper .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .booking-service-wrapper .card {
            position: relative;
            background: white;
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
            display: block; /* Đảm bảo label hiển thị đúng */
        }

        .booking-service-wrapper .card:hover {
            border-color: #3498db;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        .booking-service-wrapper .card input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        /* Hiệu ứng Checkbox */
        .booking-service-wrapper .card:has(input[type="radio"]:checked) {
            border-color: #e74c3c;
            background-color: #fff5f5;
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.2);
        }

        .booking-service-wrapper .card:has(input[type="radio"]:checked)::after {
            content: '\f058';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            color: #e74c3c;
            font-size: 1.2rem;
        }

        .booking-service-wrapper .card img {
            width: 100%;
            height: 160px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .booking-service-wrapper .card p {
            margin: 5px 0;
            font-size: 0.95rem;
            color: #555;
        }

        .booking-service-wrapper .note, 
        .booking-service-wrapper .date {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
        }

        .booking-service-wrapper .date {
            max-width: 300px;
        }

        .booking-service-wrapper button[type="submit"] {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 40px auto 10px;
            padding: 15px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .booking-service-wrapper button[type="submit"]:hover {
            background: #c0392b;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
        }
    </style>
@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
        {{ session('error') }}
    </div>
@endif
    <div class="booking-service-wrapper">
        <h2>ĐẶT LỊCH BẢO DƯỠNG</h2>

        <form method="POST" action="{{ url('user/car_shop/dat_bao_duong') }}">
            @csrf

            <h3>1. Chọn xe của bạn</h3>
            <div class="grid">
              @forelse($ds_xe as $xe)
    <label class="card">
        <input type="radio" name="id_xe" value="{{ $xe['id_Xe_Mau'] }}" required>
        <div class="card-body">
            <p><b>{{ $xe['Ten_Xe'] }}</b></p>
            <p><small>Màu: {{ $xe['Ten_Mau'] }}</small></p>
            <p><small>Hãng: {{ $xe['Ten_Thuong_Hieu'] }} | Loại: {{ $xe['Ten_Loai_Xe'] }}</small></p>
        </div>
    </label>
@empty
    <p style="text-align: center; color: #7f8c8d; grid-column: 1 / -1;">
        Bạn chưa có xe nào trong hệ thống.
    </p>
@endforelse
            </div>

            <h3>2. Chọn gói bảo dưỡng</h3>
            <div class="grid">
                @foreach($goi_bao_duong as $goi)
                <label class="card">
                    <input type="radio" name="id_goi" value="{{ $goi['id_goi'] }}" required>
                    <p><b>{{ $goi['ten_goi'] }}</b></p>
                    <p style="font-size: 0.85rem; height: 40px; overflow: hidden;">{{ $goi['mo_ta'] }}</p>
                    <p style="color: #e74c3c; font-weight: bold;">{{ number_format($goi['gia']) }} VNĐ</p>
                </label>
                @endforeach
            </div>

            <h3>3. Thông tin bổ sung</h3>
            <div style="margin-bottom: 20px;">
                <label>Ghi chú tình trạng xe:</label>
                <textarea class="note" name="ghi_chu" placeholder="Ví dụ: Xe bị kêu ở phanh trước..."></textarea>
            </div>

            <div>
                <label>Ngày hẹn bảo dưỡng:</label>
                <input class="date" type="date" name="ngay_bao_duong" required>
            </div>

            <button type="submit">XÁC NHẬN ĐẶT LỊCH</button>
        </form>
    </div>
    <script>
    // Lấy ô input date
    const dateInput = document.querySelector('.date');
    // Tạo ngày hiện tại theo định dạng YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0];
    // Thiết lập thuộc tính min để chặn chọn ngày quá khứ
    dateInput.setAttribute('min', today);
</script>
@endsection