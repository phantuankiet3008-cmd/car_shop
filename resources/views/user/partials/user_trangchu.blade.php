@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">

<!-- ===== SLIDER FULL ===== -->
<div class="slider">
    <div class="slides">
        @foreach($data['danh_sach_slider'] as $slider)
            <div class="slide">
                <a href="{{ url('user/car_shop/danhsachsanpham/' . $slider['id_Loai_Xe'] . '/0') }}" target="_blank">
                    <img src="{{ preg_match('/^https?:\/\//', $slider['Hinh_Anh_Loai']) ? $slider['Hinh_Anh_Loai'] : asset($slider['Hinh_Anh_Loai']) }}" class="slide-img">
                </a>
            </div>
        @endforeach
    </div>

    <!-- nút phải nằm TRONG slider -->
    <button class="prev" onclick="moveSlide(-1)">❮</button>
    <button class="next" onclick="moveSlide(1)">❯</button>
</div>

<!-- ===== CONTENT BÊN DƯỚI ===== -->
<main class="main-content">
    
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif


</main>

<!-- ===== TABS ===== -->
<h2 class="tab-heading">Khám phá các hãng xe</h2>

<div class="tabs">
  <button class="tab active" onclick="showTab(event,'FORD')">FORD</button>
  <button class="tab" onclick="showTab(event,'TOYOTA')">TOYOTA</button>
  <button class="tab" onclick="showTab(event,'HYUNDAI')">HYUNDAI</button>
  <button class="tab" onclick="showTab(event,'MITSUBISHI')">MITSUBISHI</button>
  <button class="tab" onclick="showTab(event,'VINFAST')">VINFAST</button>
  <button class="tab" onclick="showTab(event,'BMW')">BMW</button>
</div>

<div id="FORD" class="tab-content active">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['ford']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['ford']['Anh_Dai_Dien']) ? $thuongHieuData['ford']['Anh_Dai_Dien'] : asset($thuongHieuData['ford']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="Ford">

        <div class="overlay-content">
            <h1>Ford</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['ford']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['ford']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
          <div class="noi_dung">
    <h3>Khám phá dòng xe Ford 2026 mạnh mẽ, bền bỉ, phù hợp mọi địa hình.</h3>
</div>
        </div>
    </div>
</div>

  `<!-- TOYOTA Tab -->
<div id="TOYOTA" class="tab-content">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['toyota']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['toyota']['Anh_Dai_Dien']) ? $thuongHieuData['toyota']['Anh_Dai_Dien'] : asset($thuongHieuData['toyota']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="Toyota">

        <div class="overlay-content">
            <h1>Toyota</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['toyota']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['toyota']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
            <div class="noi_dung">
    <h3>Khám phá Toyota 2026 – tiết kiệm nhiên liệu, bền bỉ và đáng tin cậy.</h3>
</div>
        </div>
    </div>
</div>

  `<!-- Hyundai  Tab -->
<div id="HYUNDAI" class="tab-content">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['hyundai']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['hyundai']['Anh_Dai_Dien']) ? $thuongHieuData['hyundai']['Anh_Dai_Dien'] : asset($thuongHieuData['hyundai']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="Hyundai">
        <div class="overlay-content">
            <h1>Hyundai</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['hyundai']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['hyundai']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
            <div class="noi_dung">
    <h3>Hyundai 2026 – thiết kế trẻ trung, công nghệ hiện đại, giá hợp lý.</h3>
</div>
        </div>
    </div>
</div>

<!-- Mitsubishi Tab -->
<div id="MITSUBISHI" class="tab-content">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['mitsubishi']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['mitsubishi']['Anh_Dai_Dien']) ? $thuongHieuData['mitsubishi']['Anh_Dai_Dien'] : asset($thuongHieuData['mitsubishi']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="Mitsubishi">

        <div class="overlay-content">
            <h1>Mitsubishi</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['mitsubishi']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['mitsubishi']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
            <div class="noi_dung">
    <h3>Mitsubishi 2026 – vận hành ổn định, phù hợp gia đình và đường dài.</h3>
</div>
        </div>
    </div>
</div>

<!-- VINFAST Tab -->
<div id="VINFAST" class="tab-content">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['vinfast']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['vinfast']['Anh_Dai_Dien']) ? $thuongHieuData['vinfast']['Anh_Dai_Dien'] : asset($thuongHieuData['vinfast']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="VinFast">

        <div class="overlay-content">
            <h1>VinFast</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['vinfast']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['vinfast']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
            <div class="noi_dung">
    <h3>VinFast 2026 – xe điện thông minh, dẫn đầu xu hướng tương lai.</h3>
</div>
        </div>
    </div>
</div>

<!-- BMW Tab -->
<div id="BMW" class="tab-content">
    <div class="tab-image-container">
        <img src="{{ !empty($thuongHieuData['bmw']['Anh_Dai_Dien']) ? (preg_match('/^https?:\/\//', $thuongHieuData['bmw']['Anh_Dai_Dien']) ? $thuongHieuData['bmw']['Anh_Dai_Dien'] : asset($thuongHieuData['bmw']['Anh_Dai_Dien'])) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="BMW">

        <div class="overlay-content">
            <h1>BMW</h1>

            <div class="buttons">
                <a href="{{ url('/user/car_shop/chitietxe/' . ($thuongHieuData['bmw']['id_Xe'] ?? 0)) }}" class="btn-overlay">Đặt xe ngay</a>
                <a href="{{ url('user/car_shop/danhsachsanpham/0/' . ($thuongHieuData['bmw']['id_Thuong_Hieu'] ?? 0)) }}" class="btn-overlay">Xem chi tiết</a>
            </div>
            <div class="noi_dung">
    <h3>BMW 2026 – đẳng cấp, sang trọng, trải nghiệm lái thể thao đỉnh cao.</h3>
</div>
        </div>
    </div>
</div>


<!-- ===== SLIDER GIỮA ===== -->
 <section class="tools">
    <h2>CÔNG CỤ MUA HÀNG</h2>

    <div class="tool-list">

        <div class="tool-item" onclick="goTo('/user/car_shop/khuyenmai')">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png">
            <p>Khuyến mãi</p>
        </div>

        <div class="tool-item" onclick="goTo('/user/car_shop/baohanh')">
            <img src="https://cdn-icons-png.flaticon.com/512/743/743131.png">
            <p>Bảo hành</p>
        </div>


        <div class="tool-item" onclick="goTo('/user/car_shop/lai_thu/0/0')">
            <img src="https://cdn-icons-png.flaticon.com/512/171/171239.png">
            <p>Đăng ký lái thử </p>
        </div>
        
        <div class="tool-item" onclick="goToDealer()">
            <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png">
            <p>Tìm đại lý</p>
        </div>

    </div>
</section>

<!-- ===== SLIDER DƯỚI ===== -->
<section class="ford-section-2">
    <h2 class="section-title">Dịch vụ và Chăm sóc khách hàng</h2>

    <div class="slider-wrapper-2">
        <div class="brandcard-holder-2" id="slider-2">

            <div class="card-box-2">

            <div class="brandcard-2">
                   <img src="{{ asset('upload/avatar/images/Car%20dealership%20planning%20meeting.png') }}" alt="Desk scene">
            </div>

            <div class="text-2">
                <h3>Chat với chuyên viên</h3>
                <p>Nhận tư vấn từ chuyên gia để lựa chọn mẫu xe phù hợp nhất dành cho bạn.</p>
                <a href="{{ url('/user/car_shop/tuvan') }}" class="btn-link-2">Xem chi tiết</a>
            </div>

        </div>
           <div class="card-box-2">

            <div class="brandcard-2">
                    <img src="{{ asset('upload/avatar/images/dich%20vu%201.jpg') }}" alt="Desk scene">
            </div>

            <div class="text-2">
                <h3>Giao nhận xe tận nhà</h3>
                <p>Trải nghiệm dịch vụ giao xe tận nhà nhanh chóng, an toàn – giúp bạn nhận xe dễ dàng mà không cần di chuyển.</p>
                <a href="{{ url('/user/car_shop/giaoxe') }}" class="btn-link-2">Xem chi tiết</a>
            </div>

        </div>
        <div class="card-box-2">

            <div class="brandcard-2">
                    <img src="{{ asset('upload/avatar/images/dich%20vu%202.jpg') }}" alt="Service 2">
            </div>

            <div class="text-2">
                <h3>Đặt lịch dịch vụ trực tuyến</h3>
                <p>Đặt lịch dịch vụ trực tuyến chỉ trong vài bước đơn giản – tiết kiệm thời gian và chủ động lịch trình của bạn.</p>
                <a href="{{ url('/user/car_shop/tructuyen') }}" class="btn-link-2">Xem chi tiết</a>
            </div>
        </div>

            <div class="card-box-2">

            <div class="brandcard-2">
                        <img src="{{ asset('upload/avatar/images/dich%20vu%203.jpg') }}" alt="Service 3">
            </div>

            <div class="text-2">
                <h3>Dịch vụ và bảo dưỡng</h3>
                <p>Tận hưởng dịch vụ bảo dưỡng chuyên nghiệp với đội ngũ kỹ thuật giàu kinh nghiệm – giúp xe luôn vận hành bền bỉ và an toàn.</p>
                <a href="{{ url('/user/car_shop/suachua') }}" class="btn-link-2">Xem chi tiết</a>
            </div>
            </div>

     </div>

        <button class="brand-previous-2"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="brand-next-2"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>
</main>
<script>
    let currentSlide = 0;

    function moveSlide(direction) {
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        currentSlide += direction;

        if (currentSlide >= totalSlides) {
            currentSlide = 0;
        } else if (currentSlide < 0) {
            currentSlide = totalSlides - 1;
        }

        const offset = -currentSlide * 100;
        document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
    }
    
    // Tự động chuyển slide sau 5 giây
    setInterval(() => moveSlide(1), 5000);

    // ===== TABS =====
    window.showTab = function(event, id){
        document.querySelectorAll('.tab-content').forEach(el=>{
            el.classList.remove('active');
        });

        document.querySelectorAll('.tab').forEach(el=>{
            el.classList.remove('active');
        });

        document.getElementById(id).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    // ===== SLIDER GIỮA =====
    function goTo(link){
    window.location.href = link;
}

    // ===== SLIDER DƯỚI =====
   const slider2 = document.getElementById("slider-2");
    const nextBtn2 = document.querySelector(".brand-next-2");
    const prevBtn2 = document.querySelector(".brand-previous-2");
    const scrollAmount2 = 320;

    nextBtn2.onclick = () => {
        slider2.scrollBy({ left: scrollAmount2, behavior: "smooth" });
    };
    prevBtn2.onclick = () => {
        slider2.scrollBy({ left: -scrollAmount2, behavior: "smooth" });
    };

</script>

<script>
function goToDealer() {
    // Tọa độ trung tâm TP HCM
    const latitude = 10.7769;
    const longitude = 106.7009;
    const url = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`;
    window.open(url, '_blank'); // mở tab mới
}
</script>

<style>

/* ===== SLIDER TRÊN ===== */
/* ===== TABS ===== */
/* Xóa khoảng trắng mặc định */
body {
    margin: 0;
}

.banner {
    width: 100%;
}

.tab-heading {
    margin: 40px;
    padding: 5px;
    font-size: 40px;
    font-family: Arial, Helvetica, sans-serif;
    color: #2c3e50;
}

/* KHUNG ẢNH */
.tab-image-container {
    position: relative;
    width: 1200px;     /* 👈 giới hạn lại */
    max-width: 100%;   /* responsive */
    height: 500px;
    margin:30px auto;    /* căn giữa */
    overflow: hidden;
    border-radius: 10px; /* optional cho đẹp */
}

/* ẢNH */
.tab-image-container img {
    width: 100%;
    height: 500px;
    object-fit: cover;       /* giữ tỉ lệ */
    object-position: center; /* lấy وسط ảnh */
    display: block;
}
   

/* TEXT */
.overlay-content {
    position: absolute;
    bottom: 40px;
    left: 40px;
    color: white;
    z-index: 2;

}

/* LỚP TỐI */
.tab-image-container::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
}

.overlay-content h1 {
    font-size: 40px;
    margin-bottom: 20px;
}

/* Nút */
.buttons {
    display: flex;
    gap: 10px;
}

.btn-overlay {
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
}

.btn-overlay:first-child {
    background: #007bff;
    color: white;
}

.btn-overlay:last-child {
    border: 1px solid white;
    color: white;
}

/* Lớp tối nhẹ cho ảnh (giống web hãng) */
.tab-image-container::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
}
.tabs {
    display: flex;
    justify-content: center;
    gap: 50px;
    border-bottom: 2px solid #ddd;
    
}

.tab {
    padding: 12px 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 19px;
    font-family: Arial, Helvetica, sans-serif;
    color: #637688;
}

.tab.active {
    border-bottom: 3px solid #637688;
    font-weight: bold;
    color: #637688;
}

.tab-content { display: none; }
.tab-content.active { display: block; }

/* ===== slide dưới ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body{
    background:#fff;
}

/* TIÊU ĐỀ */
.tools{
    text-align:center;
    padding:60px 20px;
}

.tools h2{
    font-size:22px;
    font-weight:500;
    margin-bottom:50px;
    letter-spacing:1px;
}

/* DANH SÁCH */
.tool-list{
    display:flex;
    justify-content:center;
    align-items:center;
    max-width:900px;
    margin:auto;
    border:1px solid #637688;
   
}

/* ITEM */
.tool-item{
    flex:1;
    padding:30px 10px;
    cursor:pointer;
    transition:0.3s;
    border-right:1px solid #637688;
}

.tool-item:last-child{
    border-right:none;
}

/* ICON */
.tool-item img{
    width:40px;
    margin-bottom:15px;
    opacity:0.7;
}

/* TEXT */
.tool-item p{
    font-size:14px;
    color:#333;
}

/* HOVER GIỐNG WEB XỊN */
.tool-item:hover{
    background:#fafafa;
}

.tool-item:hover img{
    opacity:1;
    transform:scale(1.1);
}

/* RESPONSIVE */
@media (max-width:768px){
    .tool-list{
        flex-direction:column;
    }

    .tool-item{
        border-right:none;
        border-bottom:1px solid #eee;
        width:100%;
    }

    .tool-item:last-child{
        border-bottom:none;
    }
}

.icon-car {
    width: 60px;
    transition: transform 0.3s ease;
}

.icon-car:hover {
    transform: scale(1.3); /* phóng to nhưng không đẩy layout */
}

/* ===== SLIDER DƯỚI-2 ===== */
.text-2 h3 {
    font-size: 1.6rem;       
    font-weight: 700;        
    color: #2c3e50;          
}

.text-2 p {
    font-size: 1rem;          /* chữ dễ đọc */
    color: #2c3e50;              /* màu chữ dịu mắt */
}

.ford-section-2 {
    margin: 0 -20px;
    background: #ffffff;
    padding: 40px;
}

.slider-wrapper-2 {
    position: relative;
}

.brandcard-holder-2 {
    display: flex;
    gap: 20px; 
    overflow-x: auto; 
    scroll-behavior: smooth;
    padding: 10px 0;
}

.brandcard-holder-2::-webkit-scrollbar {
    display: none;
}

.card-box-2 {
    flex: 0 0 calc((100% - 60px) / 3); /* 4 card trên 1 hàng, trừ gap */
    box-sizing: border-box;
}

.brandcard-2 {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.3s;
    display: block;
}

.brandcard-2:hover {
    transform: scale(1.05);
}

.brandcard-2 img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
    aspect-ratio: 1 / 1;
}

.text-2 {
    display: block;
    margin-top: 8px;
    font-family: Arial, sans-serif;
    color: #2c3e50;
}

.btn-link-2 {
    display: inline-block;
    padding: 8px 16px;
    margin-top: 8px;
    background-color: #6195ca;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}

/* Nút slider */
.brand-previous-2,
.brand-next-2 {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    background: rgba(0,0,0,0.6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s;
}

.brand-previous-2 { left: -20px; }
.brand-next-2 { right: -20px; }

.brand-previous-2:hover,
.brand-next-2:hover {
    background: #34495e;
    transform: translateY(-50%) scale(1.1);
}

.brand-previous-2 i,
.brand-next-2 i {
    font-size: 18px;
}

/* Tiêu đề */
.section-title {
    margin: 5px;
    padding: 5px;
    font-size: 40px;
    font-family: Arial, Helvetica, sans-serif;
    color: #2c3e50;
}

</style>
@endsection