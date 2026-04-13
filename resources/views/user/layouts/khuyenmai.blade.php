@extends('user.layouts.user_index')

@section('content')

<style>
   body {
    margin: 0;
}

/* Banner full màn hình */
.banner-3 {
    width: 100vw;              /* full chiều rộng màn hình */
    height: 85vh;             /* full chiều cao màn hình */
    margin-left: calc(-50vw + 50%); /* 🔥 kéo ra khỏi container */
    
}

/* Ảnh */
.banner-3 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
    .container h2 {
    text-align: center;     /* text-center */
    color: #2c3e50;         /* đỏ đẹp hơn */
    font-weight: bold;      /* fw-bold */
    margin: 10px;    /* mb-4 */
 font-family: Arial, sans-serif;
    font-size: 32px;
    letter-spacing: 2px;
    position: relative;

}
/* ===== CARD ===== */
.card-xe {
    border-radius: 15px;
    overflow: hidden;
    transition: 0.3s;
    background: #fff;
    width: 40%;
    height: 40%;
}
.card-xe:hover {
    transform: translateY(-6px);
}

/* ===== ẢNH ===== */
.car-img-box {
    position: relative; /* QUAN TRỌNG để badge nằm trên ảnh */
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 10px;
}

.car-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== BADGE ƯU ĐÃI ===== */
.badge-sale {
    position: absolute;
    top: 10px;
    left: 10px;
    background: red;
    color: #fff;
    padding: 5px 10px;
    font-weight: bold;
    border-radius: 6px;
    font-size: 13px;
}

/* ===== BODY ===== */
.card-body {
    padding: 15px;
}

/* ===== TÊN XE ===== */
.ten-xe {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 5px;
}

/* ===== GIÁ ===== */
.price-box {
    margin-top: 8px;
}


.price-new {
    color: red;
    font-size: 22px;
    font-weight: bold;
}

.price-old {
    text-decoration: line-through;
    color: #888;
    font-size: 14px;
}

.sale-text {
    font-size: 13px;
    color: green;
    font-weight: 500;
}

/* ===== TAG ===== */
.tag {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    background: #00bcd4;
    color: white;
}

/* ===== BUTTON ===== */
.btn-detail {
    border: 2px solid #0d6efd;
    color: #0d6efd;
    font-weight: bold;
    border-radius: 8px;
    padding: 8px;
    text-align: center;
    display: block;
    text-decoration: none;
    transition: 0.3s;
}
.btn-detail:hover {
    background: #0d6efd;
    color: white;
}
</style>

<div class="banner-3">
    <img src="{{ asset('upload/avatar/images/uu_dai.jpg') }}" alt="Banner" style="width:100%; height:auto;">
</div>

<div class="container mt-5 mb-5">
    <h2 class="text-center text-danger fw-bold mb-4"> XE KHUYẾN MÃI </h2>

    <div class="row">
        @if(count($sanPham) > 0)

            @foreach($sanPham as $xe)

                @php
                    $giaGoc = $xe['Gia_Mau'];
                    $giam = $xe['Gia_Tri'] ?? 0;

                    if($xe['Loai'] == 'phan_tram'){
                        $giaMoi = $giaGoc - ($giaGoc * $giam / 100);
                    } else {
                        $giaMoi = $giaGoc - $giam;
                    }
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card-xe shadow-sm h-100">

                        {{-- ẢNH --}}
                        <div class="car-img-box">

                            <a href="{{ url('user/car_shop/chitietxe/' . $xe['id_Xe']) }}">
                                <img src="{{ $xe['Anh_Dai_Dien'] }}" class="car-img">
                            </a>

                            {{-- BADGE ƯU ĐÃI --}}
                            @if($giam > 0)
                                <div class="badge-sale">
                                    @if($xe['Loai'] == 'phan_tram')
                                        -{{ $giam }}%
                                    @else
                                        -{{ number_format($giam) }}đ
                                    @endif
                                </div>
                            @endif

                        </div>

                        {{-- BODY --}}
                        <div class="card-body">

                            {{-- TÊN XE --}}
                            <div class="ten-xe">
                                {{ $xe['Ten_Xe'] }}
                            </div>

                            {{-- GIÁ + ƯU ĐÃI --}}
@if($giam > 0)

    <div class="price-box">

        <div class="price-new">
    <span class="text-muted" style="font-size:17px;">Giá khuyến mãi:</span><br>
    {{ number_format($giaMoi) }} VNĐ
</div>

        <div class="price-old">
            Giá gốc: {{ number_format($giaGoc) }} VNĐ
        </div>

        <div class="sale-text">
    Ưu đãi: 
    {{ $xe['Ten_Uu_Dai'] ?? 'Giảm giá' }} 
    (
        @if($xe['Loai'] == 'phan_tram')
            -{{ $giam }}%
        @else
            -{{ number_format($giam) }} VNĐ
        @endif
    )
    
    <br>
    <small>
        Thời gian: 
        {{ \Carbon\Carbon::parse($xe['Ngay_Bat_Dau'])->format('d/m/Y') }} 
        - 
        {{ \Carbon\Carbon::parse($xe['Ngay_Ket_Thuc'])->format('d/m/Y') }}
    </small>
</div>
    </div>

@else

    <div class="price-new">
        Giá: {{ number_format($giaGoc) }} VNĐ
    </div>

@endif

                            {{-- TAG --}}
                            <div class="mb-2">
                                <span class="tag">Sedan</span>
                            </div>

                            {{-- BUTTON --}}
                            <a href="{{ url('user/car_shop/chitietxe/' . $xe['id_Xe']) }}" class="btn-detail">
                                Xem chi tiết
                            </a>

                        </div>

                    </div>
                </div>

            @endforeach

        @else
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    Không có sản phẩm khuyến mãi nào!
                </div>
            </div>
        @endif
    </div>
</div>

@endsection