@extends('user.layouts.user_index')

@section('content')

<style>

.banner-giaoxe{
    margin:0 -20px;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
}

.banner-giaoxe img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.section{
    margin:unset;
    padding: unset;
}

.page-wrap{
    max-width: 1200px;
    margin: auto;
    padding: 100px 24px;
    font-family: Arial, Helvetica, sans-serif;
    color: #2c3e50;
}

/* ===== GIỚI THIỆU ===== */
.intro-section{
    margin-bottom: 140px;
}

.intro-section h1{
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 28px;
}

.intro-section p{
    font-size: 20px;
    line-height: 2.1;
    max-width: 880px;
    margin-bottom: 18px;
}

/* ===== GRID 2 BÊN ===== */
.delivery-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 130px;
    margin-bottom: 160px;
}

.delivery-item img{
    width: 100%;
    height: 400px;
    object-fit: cover;
    margin-bottom: 26px;
}

.delivery-item h3{
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 14px;
}

.delivery-item p{
    font-size: 19px;
    line-height: 2.05;
    max-width: 520px;
}

/* ===== FAQ ===== */
.faq-section{
    margin-bottom: 160px;
}

.faq-section h2{
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 55px;
}

.faq-item{
    margin-bottom: 45px;
    max-width: 820px;
}

.faq-item h3{
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 10px;
}

.faq-item p{
    font-size: 19px;
    line-height: 2.05;
}

/* ===== CTA dạng link ngang ===== */
.delivery-cta{
    border-top: 1px solid #e5e5e5;
    padding-top: 40px;
    text-align: center;
}

.delivery-cta p{
    margin-bottom: 25px;
}

.delivery-cta .contact-item{
    display: inline-flex;
    align-items: center;
    gap: 10px;

    margin: 0 35px;
    text-decoration: none;
    color: #2c3e50;

    font-size: 26px;
    font-weight: 700;
}

.delivery-cta .contact-item img{
    width: 26px;
    height: 26px;
}

.delivery-cta .contact-item:hover{
    opacity: 0.7;
}

/* ===== MOBILE ===== */
@media(max-width:768px){

    .page-wrap{
        padding: 60px 18px;
    }

    .intro-section h1{
        font-size: 32px;
    }

    .delivery-grid{
        grid-template-columns: 1fr;
        gap: 70px;
    }

    .delivery-item img{
        height: 240px;
    }

    .faq-section h2{
        font-size: 28px;
    }

    .delivery-cta .contact-item{
        display: flex;
        justify-content: center;
        margin: 12px 0;
        font-size: 20px;
    }
}

</style>

<div class="banner-giaoxe">
    <img src="{{ asset('upload/avatar/images/giaoxe6.jpg') }}" alt="">
</div>

<div class="page-wrap">

    <section class="intro-section">
        <h1>Giao xe tận nhà</h1>
        <p>
            Hệ thống xe cung cấp dịch vụ giao xe tận nhà trên toàn quốc,
            giúp khách hàng nhận xe nhanh chóng, thuận tiện và an tâm.
        </p>
        <p>
            Chúng tôi đảm bảo quy trình bàn giao chuyên nghiệp,
            minh bạch và đúng thời gian cam kết.
        </p>
    </section>

    <section class="delivery-grid">
        <div class="delivery-item">
            <img src="{{ asset('upload/avatar/images/4.png') }}" alt="">
            <h3>Quy trình giao xe chuyên nghiệp</h3>
            <p>
                Xe được kiểm tra kỹ lưỡng trước khi bàn giao,
                đảm bảo đầy đủ giấy tờ, phụ kiện và quà tặng kèm theo.
            </p>
        </div>

        <div class="delivery-item">
            <img src="{{ asset('upload/avatar/images/giaoxe5.png') }}" alt="">
            <h3>Hướng dẫn sử dụng tận nơi</h3>
            <p>
                Chuyên viên sẽ hướng dẫn chi tiết cách vận hành,
                sử dụng các tính năng và giải đáp mọi thắc mắc của bạn.
            </p>
        </div>
    </section>

    <section class="faq-section">
        <h2>Câu hỏi thường gặp</h2>

        <div class="faq-item">
            <h3>Thời gian giao xe mất bao lâu?</h3>
            <p>Thông thường từ 1–3 ngày sau khi hoàn tất thủ tục.</p>
        </div>

        <div class="faq-item">
            <h3>Giao xe có phát sinh chi phí không?</h3>
            <p>Chi phí sẽ được thông báo cụ thể tùy khu vực.</p>
        </div>

        <div class="faq-item">
            <h3>Tôi ở tỉnh xa có được hỗ trợ không?</h3>
            <p>Hỗ trợ giao xe trên toàn quốc.</p>
        </div>
    </section>

    <section class="delivery-cta">
        <h2>Đặt lịch giao xe ngay hôm nay</h2>
        <p>
            Liên hệ với chúng tôi để được tư vấn chi tiết về dịch vụ giao xe tận nhà.
        </p>

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
    </section>

</div>

@endsection