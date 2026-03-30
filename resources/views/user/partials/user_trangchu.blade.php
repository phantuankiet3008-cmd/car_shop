@extends('user.layouts.user_index')

@section('content')

<link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>

<!-- ===== SLIDER TRÊN ===== -->
<div class="slider">
    <div class="slides" id="slides">

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
<h2 class="tab-heading">KHÁM PHÁ CÁC DÒNG XE</h2>

<div class="tabs">
  <button class="tab active" onclick="showTab(event,'FORD')">FORD</button>
  <button class="tab" onclick="showTab(event,'TOYOTA')">TOYOTA</button>
  <button class="tab" onclick="showTab(event,'KIA')">KIA</button>
  <button class="tab" onclick="showTab(event,'MPV')">ĐA DỤNG</button>
  <button class="tab" onclick="showTab(event,'VINFAST')">VINFAST</button>
  <button class="tab" onclick="showTab(event,'HONDA')">HONDA</button>
</div>

<div class="content">
  <div id="FORD" class="tab-content active">Nội dung FORD</div>
  <div id="TOYOTA" class="tab-content">Nội dung TOYOTA</div>
  <div id="KIA" class="tab-content">Nội dung KIA</div>
  <div id="MPV" class="tab-content">Nội dung Đa dụng</div>
  <div id="VINFAST" class="tab-content">Nội dung VINFAST</div>
  <div id="HONDA" class="tab-content">Nội dung HONDA</div>
</div>


<!-- ===== SLIDER DƯỚI ===== -->
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
    </div>

</div>
        </div>

        <button class="brand-previous"><i class="fa-solid fa-chevron-left"></i></button>

        <button class="brand-next"><i class="fa-solid fa-chevron-right"></i></button>

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

    // ===== SLIDER DƯỚI =====
    const slider = document.getElementById("slider");
    const nextBtn = document.querySelector(".brand-next");
    const prevBtn = document.querySelector(".brand-previous");

    const scrollAmount = 320;

    nextBtn.onclick = () => {
        slider.scrollBy({
            left: scrollAmount,
            behavior: "smooth"
        });
    };

    prevBtn.onclick = () => {
        slider.scrollBy({
            left: -scrollAmount,
            behavior: "smooth"
        });
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
    color: #2c3e50;
}

.tab.active {
    border-bottom: 3px solid black;
    font-weight: bold;
}

.tab-content { display: none; padding: 20px; }
.tab-content.active { display: block; }

/* ===== SLIDER DƯỚI ===== */
.h2 {
    margin: 5px;
    padding: 5px;
    font-size: 40px;
    font-family: Arial, Helvetica, sans-serif;
}

.ford-section {

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

.brandcard img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
    aspect-ratio: 1 / 1; /* 👈 vuông 100% */
}

/* ===== KHUNG CHA ===== */
.card-box {
    flex: 0 0 calc(100% / 3 - 16px); 
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
    background: #007bff;
    transform: translateY(-50%) scale(1.1);
}

/* icon */
.brand-previous i,
.brand-next i {
    font-size: 18px;
}
</style>

@endsection