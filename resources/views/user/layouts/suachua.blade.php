@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">

<style>
.banner-suachua{
    margin:0 -20px;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
}

.banner-suachua img{
    width: 100%;
    height: 60vh;
    object-fit: cover;
    display: block;
}

.quality-wrap{
    max-width:1200px;
    margin:auto;
    padding:90px 24px;
    font-family:Arial, Helvetica, sans-serif;
    color: #2c3e50;
}

/* HEADER */
.quality-header{
    text-align:center;
    margin-bottom:70px;
}

.quality-header h1{
    font-size:54px;
    font-weight:700;
    margin-bottom:22px;
    color: #2c3e50;
}

.quality-header p{
    font-size:20px;
    line-height:2.1;
    max-width:1000px;
    margin:auto;
}

/* GRID 3 HÌNH */
.quality-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:60px;
    margin-bottom:40px;
}

.quality-grid img{
    width:100%;
    height:260px;
    object-fit:cover;
}

/* NỘI DUNG DƯỚI HÌNH */
.quality-content{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:60px;
    margin-top:10px;
}

.quality-item h3{
    font-size:36px;
    font-weight:700;
    margin-bottom:16px;
    color:#2c3e50;
}

.quality-item p{
    font-size:18px;
    line-height:2;
}

/* CONTACT CUỐI */
.quality-contact{
    margin-top:90px;
    padding-top:50px;
    border-top:1px solid #ddd;
    text-align:center;
}

.quality-contact h2{
    font-size:38px;
    font-weight:700;
    margin-bottom:18px;
}

.quality-contact p{
    font-size:18px;
    line-height:2;
    margin-bottom:25px;
}

/* KHUNG CÁC NÚT */
.contact-links{
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

/* TỪNG NÚT */
.contact-item{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 22px;
    text-decoration:none;
    color:#2c3e50;
    font-weight:600;
    font-size:17px;
    transition:all .25s ease;
}

/* ICON ĐỒNG KÍCH THƯỚC */
.contact-item img{
    width:26px;
    height:26px;
    object-fit:contain;
}


/* MOBILE */
@media(max-width:768px){
    .contact-links{
        flex-direction:column;
        align-items:center;
    }

    .contact-item{
        width:90%;
        justify-content:center;
    }
}

</style>

<div class="banner-suachua">
    <img src="{{ asset('upload/avatar/images/suachua4.jpg') }}" alt="">
</div>


<div class="quality-wrap">

    <!-- HEADER -->
    <div class="quality-header">
        <h1>Chất lượng Dịch vụ & Bảo dưỡng được đảm bảo</h1>
        <p>
            Chúng tôi cam kết mang đến sự an tâm tuyệt đối cho khách hàng trong suốt quá trình sử dụng xe.
            Đội ngũ kỹ thuật viên giàu kinh nghiệm cùng phụ tùng chính hãng giúp chiếc xe của bạn
            luôn vận hành ổn định và bền bỉ theo thời gian.
        </p>
    </div>

    <!-- 3 HÌNH -->
    <div class="quality-grid">
        <img src="{{ asset('upload/avatar/images/suachua1.jpg') }}" alt="">
        <img src="{{ asset('upload/avatar/images/suachua2.jpg') }}" alt="">
        <img src="{{ asset('upload/avatar/images/suachua3.jpg') }}" alt="">
    </div>

    <!-- NỘI DUNG -->
    <div class="quality-content">

        <div class="quality-item">
            <h3>Sự an tâm từ kiến thức chuyên môn</h3>
            <p>
                Kỹ thuật viên được đào tạo bài bản, am hiểu từng chi tiết kỹ thuật của xe,
                đảm bảo quy trình kiểm tra và bảo dưỡng chính xác tuyệt đối.
            </p>
        </div>

        <div class="quality-item">
            <h3>Dịch vụ chất lượng & phụ tùng chính hãng</h3>
            <p>
                Phụ tùng chính hãng giúp xe hoạt động ổn định, tăng tuổi thọ và
                đảm bảo hiệu suất vận hành tối ưu trong mọi điều kiện.
            </p>
        </div>

        <div class="quality-item">
            <h3>Chính sách bảo hành rõ ràng</h3>
            <p>
                Chính sách bảo hành minh bạch giúp khách hàng yên tâm tuyệt đối
                trong suốt quá trình sử dụng xe.
            </p>
        </div>

    </div>

    <!-- LIÊN HỆ -->
    <div class="quality-contact">
    <h2>Liên hệ tư vấn dịch vụ</h2>
    <p>
        Đội ngũ chuyên viên của hệ thống luôn sẵn sàng hỗ trợ bạn mọi thông tin về
        bảo dưỡng, sửa chữa và chính sách dịch vụ.
    </p>

    <div class="contact-links">
    <a href="tel:03552631245" class="contact-item">
        <img src="https://img.icons8.com/ios-filled/24/000000/phone.png" alt="Gọi điện">
        <span>Gọi ngay: 0355 263 1245</span>
    </a>

    <a href="https://zalo.me/03552631245" target="_blank" class="contact-item">
        <img src="https://img.icons8.com/ios-filled/50/0b1f66/chat.png" alt="Zalo">
        <span>Chat Zalo</span>
    </a>

    <a href="https://m.me/yourpage" target="_blank" class="contact-item">
        <img src="https://img.icons8.com/ios-filled/24/000000/facebook-messenger.png" alt="Messenger">
        <span>Messenger</span>
    </a>
</div>

</div>

@endsection