@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">


<style>

    .banner-tuvan{
    margin:0 -20px;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
}

.banner-tuvan img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.page-wrap{
    max-width: 1200px;
    margin: auto;
    padding: 90px 20px;
    font-family: Arial, Helvetica, sans-serif;
    color: #2c3e50;
}

/* ===== CHAT ===== */
.chat-section{
    margin-bottom: 110px;
}

.chat-section h2{
    font-size: 44px;
    font-weight: 700;
    margin-bottom: 28px;
}

.chat-section p{
    font-size: 20px;
    line-height: 2;
    max-width: 900px;
    margin-bottom: 18px;
}

/* ===== CONTACT ICON LINKS ===== */
.contact-links{
    margin-top: 35px;
    display: flex;
    gap: 60px;
    flex-wrap: wrap;
}

.contact-item{
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #2c3e50;
    font-size: 20px;
    font-weight: 600;
}

.contact-item img{
    width: 26px;
    height: 26px;
}


/* ===== GRID 2 BÊN ===== */
.expert-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 120px;
}

.expert-item img{
    width: 100%;
    height: 380px;
    object-fit: cover;
    margin-bottom: 25px;
}

.expert-item h3{
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.5;
}

.expert-item p{
    font-size: 19px;
    line-height: 2;
    margin-bottom: 12px;
    max-width: 520px;
}

.expert-item a{
    font-size: 19px;
    font-weight: 600;
    text-decoration: underline;
    color: #2c3e50;
}


/* ===== MOBILE ===== */
@media(max-width:768px){
    .expert-grid{
        grid-template-columns: 1fr;
        gap: 60px;
    }

    .chat-section h2{
        font-size: 30px;
    }

    .chat-section p,
    .expert-item p{
        font-size: 17px;
    }

    .expert-item img{
        height: 240px;
    }
}
</style>

<!-- Banner tách riêng -->
<div class="banner-tuvan">
    <img src="{{ asset('upload/avatar/images/3.png') }}" alt="Banner tuvan">
</div>

<div class="page-wrap">

    <!-- CHAT CHUYÊN VIÊN -->
    <section class="chat-section">
        <h2>Chat với chuyên viên bán xe</h2>

        <p>
            Nếu bạn cần tư vấn chi tiết về chính sách bảo hành, thông tin các dòng xe, giá lăn bánh,
            chương trình ưu đãi hoặc hỗ trợ trả góp, đội ngũ chuyên viên luôn sẵn sàng hỗ trợ.
        </p>

        <p>
            Chúng tôi cam kết cung cấp thông tin minh bạch, chính xác và phù hợp với nhu cầu thực tế của bạn.
        </p>

        <div class="contact-links">
            <a href="tel:03552631245" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/phone.png" alt="">
                <span>Gọi ngay: 0355 263 1245</span>
            </a>

            <a href="https://zalo.me/0900000000" target="_blank" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/chat.png" alt="">
                <span>Chat Zalo</span>
            </a>

            <a href="https://m.me/yourpage" target="_blank" class="contact-item">
                <img src="https://img.icons8.com/ios-filled/50/0b1f66/facebook-messenger.png" alt="">
                <span>Messenger</span>
            </a>
        </div>
    </section>


    <!-- 2 KHỐI GIỐNG FORD -->
    <section class="expert-grid">

        <div class="expert-item">
            <img src="{{ asset('upload/avatar/images/1.png') }}" alt="" style="width:100%;height:380px;object-fit:cover;">
            <h3>Bạn đang phân vân giữa các phiên bản xe?</h3>
            <p>
                Chuyên viên ABC sẽ dựa trên nhu cầu sử dụng, ngân sách và thông số kỹ thuật
                để giúp bạn lựa chọn phiên bản xe phù hợp nhất.
            </p>
        </div>

        <div class="expert-item">
            <img src="{{ asset('upload/avatar/images/2.jpg') }}" alt="" style="object-position: top;">
            <h3>Làm thế nào để sử dụng tính năng trên xe?</h3>
            <p>
                Liên hệ trực tiếp với chuyên viên để được hướng dẫn chi tiết cách sử dụng
                các tính năng và giải đáp về chính sách bảo hành.
            </p>
        </div>

    </section>

</div>

@endsection