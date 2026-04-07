@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">

<style>
.banner-tructuyen{
    margin:0 -20px;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
}

.banner-tructuyen img{
    width: 100%;
    height: 60vh;
    object-fit: cover;
    display: block;
}

.service-wrap{
    max-width:1200px;
    margin:auto;
    padding:80px 24px;
    font-family:Arial, Helvetica, sans-serif;
    color:#0b1f66;
}

/* HEADER */
.service-header h1{
    font-size:48px;
    font-weight:700;
    margin-bottom:16px;
    letter-spacing:-0.5px;
}

.service-header h2{
    font-size:28px;
    font-weight:600;
    margin-bottom:26px;
}

.service-header p{
    font-size:19px;
    line-height:2;
    max-width:900px;
}

/* GRID IMAGE */
.service-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:60px;
    margin:70px 0 50px;
}

.service-grid img{
    width:100%;
    height:360px;
    object-fit:cover;
}

/* CONTENT DƯỚI HÌNH */
.service-content{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:60px;
}

.service-item h3{
    font-size:28px;
    font-weight:700;
    margin-bottom:14px;
}

.service-item p{
    font-size:18px;
    line-height:2;
}

/* CONTACT */
.service-contact{
    margin-top:80px;
    text-align:center;
}

.service-contact h3{
    font-size:30px;
    margin-bottom:30px;
    font-weight:700;
}

.contact-links{
    display:flex;
    justify-content:center;
    gap:30px;
    flex-wrap:wrap;
}

.contact-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px 26px;
    text-decoration:none;
    color:#0b1f66;
    font-size:18px;
    font-weight:600;
    transition:all .3s ease;
}

.contact-item img{
    width:28px;
    height:28px;
}


/* MOBILE */
@media(max-width:768px){
    .service-grid,
    .service-content{
        grid-template-columns:1fr;
        gap:30px;
    }

    .service-header h1{
        font-size:32px;
    }

    .service-grid img{
        height:220px;
    }

    .contact-links{
        flex-direction:column;
        align-items:center;
    }
}
</style>

<div class="banner-tructuyen">
    <img src="{{ asset('upload/avatar/images/tructuyen3.jpg') }}" alt="">
</div>

<div class="service-wrap">

    <div class="service-header">
        <h1>Đặt lịch dịch vụ trực tuyến</h1>
        <h2>Mang đến giải pháp tiện lợi cho khách hàng</h2>

        <p>
            Giờ đây khách hàng có thể chủ động đặt lịch bảo dưỡng, sửa chữa xe nhanh chóng
            chỉ với vài thao tác đơn giản. Việc đặt lịch trước giúp tiết kiệm thời gian
            và đảm bảo xe được tiếp nhận ngay khi đến xưởng dịch vụ.
        </p>
    </div>

    <div class="service-grid">
        <img src="{{ asset('upload/avatar/images/tructuyen1.jpg') }}" alt="">
        <img src="{{ asset('upload/avatar/images/tructuyen2.jpg') }}" alt="">
    </div>

    <div class="service-content">
        <div class="service-item">
            <h3>Đặt lịch dịch vụ tại đại lý</h3>
            <p>
                Bạn có thể liên hệ trực tiếp với đại lý qua hotline hoặc Zalo
                để cung cấp thông tin xe, tình trạng cần kiểm tra và lựa chọn
                khung giờ phù hợp với lịch trình của mình.
            </p>
        </div>

        <div class="service-item">
            <h3>Tiết kiệm thời gian chờ đợi</h3>
            <p>
                Việc đặt lịch trước giúp kỹ thuật viên chuẩn bị sẵn phụ tùng,
                thiết bị và tiếp nhận xe nhanh chóng, hạn chế tối đa thời gian chờ đợi.
            </p>
        </div>
    </div>

    <!-- LIÊN HỆ -->
    <div class="service-contact">
        <h3>Liên hệ đặt lịch ngay</h3>

        <div class="contact-links">
            <a href="tel:03552631245" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/phone.png" alt="">
                <span>Gọi ngay: 0355 263 1245</span>
            </a>

            <a href="https://zalo.me/03552631245" target="_blank" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/chat.png" alt="">
                <span>Chat Zalo</span>
            </a>

            <a href="https://m.me/yourpage" target="_blank" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/facebook-messenger.png" alt="">
                <span>Messenger</span>
            </a>
        </div>
    </div>

</div>

@endsection