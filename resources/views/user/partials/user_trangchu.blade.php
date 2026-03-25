@extends('user.layouts.user_index')

@section('content')
<!-- Trang chủ -->
     <link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">
<main>

    <!-- ===== Slider ===== -->
    <div class="slider">
        <div class="slides">
            @foreach($data['danh_sach_slider'] as $slider)
                <div class="slide" >
                    <a href="{{ url('user/car_shop/danhsachsanpham/' . $slider['id_Loai_Xe'] . '/0') }}" target="_blank">
                        <img src="{{ $slider['Hinh_Anh_Loai'] }}" alt="slide{{ $slider['Ten_Loai_Xe'] }}" class="slide-img">
                    </a>
                </div>
            @endforeach
            
        </div>

        <button class="prev" onclick="moveSlide(-1)">❮</button>
        <button class="next" onclick="moveSlide(1)">❯</button>
    </div>

   
   


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
</script>
@endsection