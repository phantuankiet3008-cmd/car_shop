@extends('user.layouts.user_index')

@section('content')

<style>
.img-wrapper {
    overflow: hidden; 
}
.hover-zoom {
    transition: transform 0.4s ease;
}
.card:hover .hover-zoom {
    transform: scale(1.08); 
}
</style>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center fw-bold text-danger">🔥 XE KHUYẾN MÃI 🔥</h2>

    <div class="row">
        @if(count($sanPham) > 0)

            @foreach($sanPham as $xe)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">

                        <div class="img-wrapper rounded-top-3">
                            <a href="{{ url('user/car_shop/chitietxe/' . $xe['id_Xe']) }}">
                                <img src="{{ $xe['Anh_Dai_Dien'] }}" 
                                     class="card-img-top hover-zoom"
                                     style="height:200px; object-fit:cover;">
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title fw-bold">
                                <a href="{{ url('user/car_shop/chitietxe/' . $xe['id_Xe']) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $xe['Ten_Xe'] }}
                                </a>
                            </h5>

                            <p class="text-danger fw-bold fs-5">
                                Giá: {{ number_format($xe['Gia_Mau']) }} VNĐ
                            </p>

                            <p class="text-muted small">
                                {{ \Illuminate\Support\Str::limit($xe['Mo_Ta'], 100) }}
                            </p>

                            <span class="badge bg-warning text-dark">Khuyến mãi</span>
                        </div>

                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ url('user/car_shop/chitietxe/' . $xe['id_Xe']) }}" 
                               class="btn btn-danger w-100 fw-bold">
                                Xem chi tiết
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        @else
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    Không có sản phẩm khuyến mãi nào hiện tại!
                </div>
            </div>
        @endif
    </div>
</div>

@endsection