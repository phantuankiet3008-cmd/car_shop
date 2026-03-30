@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>
    @if(session('success'))
    <div style="text-align: center; font-weight: bold; padding: 15px; background-color: #d4edda; color: #155724; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="text-align: center; font-weight: bold; padding: 15px; background-color: #f8d7da; color: #721c24; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif


<!-- ===== SLIDER TRÊN ===== -->
<div class="slider">
    <div class="slides"style ="margin: 0 -20px; id="slides">

        <div class="slide">
            <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
        </div>

        <div class="slide">
            <img src="https://thuexe4cho.vn/wp-content/uploads/2022/10/xe-hoi-ford-ranger.jpeg">
        </div>

        <div class="slide">
            <img src="https://www.studytienganh.vn/upload/2022/03/111207.jpg">
        </div>
    </div>
    <button class="prev" onclick="moveSlide(-1)">❮</button>
    <button class="next" onclick="moveSlide(1)">❯</button>
</div>      





<!-- ===== TABS ===== -->
<h2 class="tab-heading">Khám phá các dòng xe</h2>

<div class="tabs">
  <button class="tab active" onclick="showTab(event,'FORD')">FORD</button>
  <button class="tab" onclick="showTab(event,'TOYOTA')">TOYOTA</button>
  <button class="tab" onclick="showTab(event,'KIA')">KIA</button>
  <button class="tab" onclick="showTab(event,'MPV')">ĐA DỤNG</button>
  <button class="tab" onclick="showTab(event,'VINFAST')">VINFAST</button>
  <button class="tab" onclick="showTab(event,'HONDA')">HONDA</button>
</div>

<div class="banner">
  <div id="FORD" class="tab-content active">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg" alt="Ford Ranger">
        
        <div class="overlay-content">
            <h1>Dòng xe bán tải mạnh mẽ</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>
</div>

  <!-- TOYOTA Tab -->
  <div id="TOYOTA" class="tab-content">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/toyota-prius.jpg" alt="Toyota Prius">
        <div class="overlay-content">
            <h1>Dòng xe tiết kiệm nhiên liệu</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>

  <!-- KIA Tab -->
  <div id="KIA" class="tab-content">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/kia-seltos.jpg" alt="Kia Seltos">
        <div class="overlay-content">
            <h1>Dòng xe đa dụng tiện nghi</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>

  <!-- MPV Tab -->
  <div id="MPV" class="tab-content">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/mpv-car.jpg" alt="MPV">
        <div class="overlay-content">
            <h1>Dòng xe đa dụng gia đình</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>

  <!-- VINFAST Tab -->
  <div id="VINFAST" class="tab-content">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/vinfast-fadil.jpg" alt="VinFast Fadil">
        <div class="overlay-content">
            <h1>Dòng xe Việt hiện đại</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>

  <!-- HONDA Tab -->
  <div id="HONDA" class="tab-content">
    <div class="tab-image-container">
        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/honda-crv.jpg" alt="Honda CR-V">
        <div class="overlay-content">
            <h1>Dòng xe mạnh mẽ, an toàn</h1>
            <div class="buttons">
                <a href="#" class="btn-overlay">Xem chi tiết</a>
                <a href="#" class="btn-overlay">Đặt xe ngay</a>
            </div>
        </div>
    </div>
  </div>
</div>
</div>


<!-- ===== SLIDER GIỮA ===== -->
<section class="ford-section">
    <h2 class="h2">Điều gì đang xảy ra tại Ford</h2>
    <div class="slider-wrapper">
    <div class="brandcard-holder" id="slider">
        <div class="card-box">
            <div class="brandcard">
                    <a href="#">
                        <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                    </a>
            </div>

            <div class="text">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <!-- Nút bấm -->
                <a href="#" class="btn-link">Xem chi tiết</a>
            </div>

        </div>
        <div class="card-box">
            <div class="brandcard">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link">Xem chi tiết</a>
            </div>

        </div>
            
        <div class="card-box">

            <div class="brandcard">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link">Xem chi tiết</a>
            </div>

        </div>
        <div class="card-box">

            <div class="brandcard">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link">Xem chi tiết</a>
            </div>

        </div>
     </div>

        <button class="brand-previous"><i class="fa-solid fa-chevron-left"></i></button>

        <button class="brand-next"><i class="fa-solid fa-chevron-right"></i></button>

    </div>
</section>
<!-- ===== SLIDER DƯỚI ===== -->
<section class="ford-section-2">
    <h2 class="section-title">Dịch vụ và Chăm sóc khách hàng</h2>

    <div class="slider-wrapper-2">
        <div class="brandcard-holder-2" id="slider-2">

            <div class="card-box-2">

            <div class="brandcard-2">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text-2">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link-2">Xem chi tiết</a>
            </div>

        </div>
           <div class="card-box-2">

            <div class="brandcard-2">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text-2">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link-2">Xem chi tiết</a>
            </div>

        </div>
        <div class="card-box-2">

            <div class="brandcard-2">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text-2">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link-2">Xem chi tiết</a>
            </div>
        </div>

            <div class="card-box-2">

            <div class="brandcard-2">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text-2">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link-2">Xem chi tiết</a>
            </div>
            </div>

            <div class="card-box-2">

            <div class="brandcard-2">
                <a href="#">
                    <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg">
                </a>
            </div>

            <div class="text-2">
                <h3>Ford Transit</h3>
                <p>Dòng xe thương mại</p>
                <a href="#" class="btn-link-2">Xem chi tiết</a>
            </div>
        </div>

     </div>

        <button class="brand-previous-2"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="brand-next-2"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>


</main>
<script>
document.addEventListener("DOMContentLoaded", () => {

    // ===== SLIDER TRÊN =====
    let index = 0;

    window.moveSlide = function(step) {
        const slides = document.querySelectorAll(".slide");
        index += step;

        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        document.getElementById("slides").style.transform =
            `translateX(-${index * 100}%)`;
    }

    setInterval(() => {
        moveSlide(1);
    }, 3000);

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
    const slider= document.getElementById("slider");
    const nextBtn = document.querySelector(".brand-next");
    const prevBtn = document.querySelector(".brand-previous");
    const scrollAmount = 320;

    nextBtn.onclick = () => {
        slider.scrollBy({ left: scrollAmount, behavior: "smooth" });
    };
    prevBtn.onclick = () => {
        slider.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    };

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

});


</script>

<style>

/* ===== SLIDER TRÊN ===== */

.tab-heading {
    color: #2c3e50;
    font-size: 35px;
    margin: 5px;
    padding: 5px;
    font-family: Arial, Helvetica, sans-serif;
}
.slider {
    position: relative;
    overflow: hidden;
}

.slides {
    display: flex;
    transition: 0.5s;
}

.slide {
    min-width: 100%;
    height: 350px;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* nút slider trên */
.prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 25px;
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}

.prev { left: 10px; }
.next { right: 10px; }

/* ===== TABS ===== */



/* Xóa khoảng trắng mặc định */
body {
    margin: 0;
}

.banner {
    width: 100%;
}

/* KHUNG ẢNH */
.tab-image-container {
    position: relative;
    width: 100%;
    height: 500px; /* ❗ ĐỪNG dùng 100vh nữa */
    overflow: hidden;
}

/* ẢNH */
.tab-image-container img {
    width: 100%;
    height: 100%;
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

.h2 {
    margin: 5px;
    padding: 5px;
    font-size: 40px;
    font-family: Arial, Helvetica, sans-serif;
}

.ford-section {
    margin:0 -20px;
    background: #2c3e50;
    padding: 40px;
    color: white;
}

.slider-wrapper {
    position: relative;
}

/* khung slider */
.brandcard-holder {
    display: flex;
    gap: 20px;
    overflow-x: auto; /* QUAN TRỌNG */
    scroll-behavior: smooth;
    padding: 10px 0;
}

/* ẩn thanh scroll */
.brandcard-holder::-webkit-scrollbar {
    display: none;
}

/* card */
.brandcard {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.3s;
    dispaly: block;
}


.brandcard:hover {
    transform: scale(1.05);
}

.brandcard img  {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
    aspect-ratio: 1 / 1; /* 👈 vuông 100% */
  
}


/* ===== KHUNG CHA ===== */
.card-box {
    flex: 0 0 calc(100% / 2.2 - 20px); 
    /* 3 card / 1 hàng */
}
/* chữ */
.text {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 5px;
    padding: 5px;
    display: unset;
}

/* ===== NÚT ===== */
.brand-previous,
.brand-next {
    position: absolute; /* QUAN TRỌNG */
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

/* vị trí */
.brand-previous {
    left: -20px;
}

.brand-next {
    right: -20px;
}

/* hover đẹp hơn */
.brand-previous:hover,
.brand-next:hover {
    background: #34495e;
    transform: translateY(-50%) scale(1.1);
}

/* icon */
.brand-previous i,
.brand-next i {
    font-size: 18px;
}

.btn-link {
    display: inline-block;
    padding: 8px 16px;
    margin-top: 8px;
    background-color: #6195ca;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
    font-family: Arial, sans-serif;
}


/* ===== SLIDER DƯỚI-2 ===== */
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
    flex: 0 0 calc((100% - 60px) / 3.5); /* 3.5 card trên 1 hàng, trừ gap */
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