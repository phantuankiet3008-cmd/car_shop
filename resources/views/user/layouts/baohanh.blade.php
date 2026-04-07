@extends('user.layouts.user_index')

@section('content')

<!-- FONT (rất quan trọng để nhìn đẹp) -->
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* RESET nhẹ */
.container-baohanh *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Banner full màn hình */
.banner-baohanh{
    width: 100vw;
    height: 82vh;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
}

.banner-baohanh img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Nội dung */
.container-baohanh{
    max-width: 820px;
    margin: 110px auto;T
    font-family: 'Arial', sans-serif;
    color: #2c3e50;
}

/* Tiêu đề */
.container-baohanh h1{
    text-align: center;
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 80px;
    letter-spacing: -0.6px;
}

/* Khoảng cách từng mục */
.policy-card{
    margin-bottom: 54px;
}

/* Tiêu đề mục */
.policy-card h3{
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 14px;
}

/* Thời hạn */
.time{
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
}

/* Nhấn mạnh số */
.highlight{
    font-weight: 700;
    font-size: 19px;
}

/* Nội dung */
.policy-card p,
.policy-card ul{
    font-size: 18px;
    line-height: 2;
    color: #333;
}

.policy-card ul{
    padding-left: 22px;
    margin-top: 10px;
}

.policy-card ul li{
    margin-bottom: 8px;
}

/* Mobile */
@media (max-width: 768px){
    .container-baohanh{
        margin: 70px auto;
    }

    .container-baohanh h1{
        font-size: 28px;
        margin-bottom: 40px;
    }

    .policy-card h3{
        font-size: 22px;
    }
}
.container-baohanh p{
    margin: 8px 0 !important;
    line-height: 1.7 !important;
}

.container-baohanh h3{
    margin: 0 0 8px 0 !important;
}

.container-baohanh ul{
    margin: 8px 0 !important;
}

.container-baohanh li{
    margin: 4px 0 !important;
}
</style>

<!-- Banner tách riêng -->
<div class="banner-baohanh">
    <img src="{{ asset('upload/avatar/images/baohanh.jpg') }}" alt="Banner bảo hành">
</div>

<!-- Nội dung -->
<div class="container-baohanh">
    <h1>Chính Sách Bảo Hành Xe</h1>

    <div class="policy-card">
        <h3>1. Bảo hành động cơ</h3>
        <p class="time">Thời hạn: <span class="highlight">3 năm hoặc 50.000 km</span></p>
        <p>Bao gồm các lỗi kỹ thuật phát sinh từ động cơ như piston, trục cam, trục khuỷu, hệ thống làm mát và bôi trơn.</p>
    </div>

    <div class="policy-card">
        <h3>2. Bảo hành hộp số</h3>
        <p class="time">Thời hạn: <span class="highlight">3 năm hoặc 50.000 km</span></p>
        <p>Áp dụng cho hộp số tự động và số sàn. Hỗ trợ sửa chữa, thay thế bánh răng, ly hợp, biến mô và hệ điều khiển.</p>
    </div>

    <div class="policy-card">
        <h3>3. Hệ thống điện & điện tử</h3>
        <p class="time">Thời hạn: <span class="highlight">2 năm</span></p>
        <p>Bảo hành ECU, cảm biến, camera, màn hình, điều hòa, hệ thống giải trí và dây điện.</p>
    </div>

    <div class="policy-card">
        <h3>4. Hệ thống phanh, lái, treo</h3>
        <p class="time">Thời hạn: <span class="highlight">3 năm hoặc 50.000 km</span></p>
        <p>Bảo hành hệ thống trợ lực lái, treo trước/sau, phanh ABS (không bao gồm hao mòn tự nhiên).</p>
    </div>

    <div class="policy-card">
        <h3>5. Thân vỏ & sơn xe</h3>
        <p class="time">Thời hạn: <span class="highlight">3 năm</span></p>
        <p>Bảo hành bong tróc sơn do lỗi kỹ thuật và gỉ sét thân vỏ từ bên trong.</p>
    </div>

    <div class="policy-card">
        <h3>6. Điều kiện áp dụng bảo hành</h3>
        <ul>
            <li>Xe còn trong thời hạn bảo hành</li>
            <li>Có sổ bảo hành và lịch sử bảo dưỡng đầy đủ</li>
            <li>Bảo dưỡng tại đại lý/garage ủy quyền ABC</li>
            <li>Không tự ý thay đổi kết cấu xe</li>
        </ul>
    </div>

    <div class="policy-card">
        <h3>7. Trường hợp không được bảo hành</h3>
        <ul>
            <li>Hao mòn tự nhiên: lốp, má phanh, ắc quy, bóng đèn</li>
            <li>Hư hỏng do tai nạn, ngập nước, thiên tai</li>
            <li>Sử dụng phụ tùng, dầu nhớt không chính hãng</li>
            <li>Không bảo dưỡng định kỳ theo khuyến cáo</li>
        </ul>
    </div>
</div>

@endsection