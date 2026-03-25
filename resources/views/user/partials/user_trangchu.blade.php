@extends('user.layouts.user_index')

@section('content')
<!-- Trang chủ -->
     <link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">
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

    <!-- ===== Slider ===== -->
    <div class="slider">
        <div class="slides">
            <div class="slide">
                <img src="https://thanglongford.com.vn/wp-content/uploads/2019/06/19DRangerWildtrak039VNLHD_2001-637159932732125070.jpg" alt="slide1">
            </div>
            <div class="slide">
                <img src="https://thuexe4cho.vn/wp-content/uploads/2022/10/xe-hoi-ford-ranger.jpeg" alt="slide2">
            </div>
            <div class="slide">
                <img src="https://www.studytienganh.vn/upload/2022/03/111207.jpg" alt="slide3">
            </div>
        </div>

        <button class="prev" onclick="moveSlide(-1)">❮</button>
        <button class="next" onclick="moveSlide(1)">❯</button>
    </div>

    <!-- Hình giữa -->
    <img src="https://baomonamcali.com/wp-content/uploads/2022/09/xe-hang-Ford-2.jpeg"
         alt="hình mới"
         class="center-img"
         width="990">


</main>

@endsection