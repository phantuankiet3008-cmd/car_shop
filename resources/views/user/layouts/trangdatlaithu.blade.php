@extends('user.layouts.user_index')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #e74c3c;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Tinh chỉnh bố cục chung */
    .product-page {
        padding: 40px 0;
        background-color: #f8f9fa;
    }

    /* Sidebar Filter - Style hiện đại */
    .filter-card {
        border: none;
        border-radius: 16px;
        position: sticky;
        top: 20px;
        background: #ffffff;
        box-shadow: var(--card-shadow);
    }

    .filter-header {
        background: var(--primary-color) !important;
        border-radius: 16px 16px 0 0 !important;
        letter-spacing: 1px;
    }

    .form-label {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25 margin-top:rgba(44, 62, 80, 0.1);
    }

    /* Product Card */
    .car-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        box-shadow: var(--card-shadow);
    }

    .car-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--hover-shadow);
    }

    .img-wrapper {
        position: relative;
        overflow: hidden;
        height: 220px;
    }

    .hover-zoom {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .car-card:hover .hover-zoom {
        transform: scale(1.1);
    }

    /* Giá tiền */
    .price-tag {
        color: var(--accent-color);
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    /* Badge tùy chỉnh */
    .badge-custom {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* Nút bấm */
    .btn-apply {
        background: var(--primary-color);
        border: none;
        border-radius: 10px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .btn-apply:hover {
        background: #1a252f;
        transform: scale(1.02);
    }

    .btn-test-drive {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-test-drive:hover {
        background: var(--primary-color);
        color: #fff;
    }

    /* Alert khi không tìm thấy xe */
    .empty-state {
        padding: 60px;
        background: #fff;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
    }
</style>

<div class="product-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card filter-card">
                    <div class="card-header filter-header text-white text-center py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-sliders2-vertical me-2"></i> BỘ LỌC TÌM KIẾM</h6>
                    </div>
                    <div class="card-body p-4">
                        <form id="filterForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Tên dòng xe</label>
                                <input type="text" id="searchInput" class="form-control" placeholder="Ví dụ: BMW, Camry..." value="{{ request('search') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Loại Xe</label>
                                <select id="loaiSelect" class="form-select">
                                    <option value="0">Tất cả phân khúc</option>
                                    @foreach($loaiXeList as $loai)
                                        <option value="{{ $loai->id_Loai_xe }}" @selected(isset($maLoai) && $maLoai == $loai->id_Loai_xe)>
                                            {{ $loai->Ten_Loai_Xe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Thương Hiệu</label>
                                <select id="thuongHieuSelect" class="form-select">
                                    <option value="0">Tất cả hãng xe</option>
                                    @foreach($thuongHieuList as $th)
                                        <option value="{{ $th->id_Thuong_Hieu }}" @selected(isset($IDTH) && $IDTH == $th->id_Thuong_Hieu)>
                                            {{ $th->Ten_Thuong_Hieu }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" class="btn btn-primary btn-apply w-100 fw-bold" onclick="submitFilter()">
                                ÁP DỤNG NGAY
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="row g-4">
                    @if(count($danhSachXe) > 0)
                        @foreach($danhSachXe as $xe)
                            <div class="col-xl-4 col-md-6">
                                <div class="card h-100 car-card">
                                    <div class="img-wrapper">
                                        <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}">
                                            <img src="{{ $xe->Anh_Dai_Dien }}" class="hover-zoom" alt="{{ $xe->Ten_Xe }}">
                                        </a>
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2">
                                            <span class="badge bg-light text-dark border badge-custom">{{ $xe->Ten_Thuong_Hieu }}</span>
                                        </div>
                                        <h5 class="card-title fw-bold mb-1">
                                            <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}" class="text-decoration-none text-dark">
                                                {{ $xe->Ten_Xe }}
                                            </a>
                                        </h5>
                                        <p class="price-tag">{{ number_format($xe->Gia_Mau) }} <small>VNĐ</small></p>
                                        
                                        <p class="card-text text-muted small flex-grow-1">
                                            {{ Str::limit($xe->Mo_Ta, 80) }}
                                        </p>
                                        
                                        <div class="mt-3 mb-3">
                                            <span class="text-secondary small"><i class="bi bi-tag me-1"></i>{{ $xe->Ten_Loai_Xe }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-0 pb-4">
                                        <a href="{{ url('user/car_shop/chitietxelaithu/' . $xe->id_Xe) }}" class="btn btn-test-drive w-100">
                                            ĐẶT LÁI THỬ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <div class="empty-state shadow-sm">
                                <i class="bi bi-search-heart text-muted display-1 mb-3"></i>
                                <h4 class="fw-bold">Không tìm thấy xe phù hợp</h4>
                                <p class="text-muted">Vui lòng thử lại với bộ lọc khác hoặc tên xe khác.</p>
                                <button class="btn btn-outline-secondary btn-sm mt-2" onclick="location.href='{{ url('user/car_shop/danhsachsanpham/0/0') }}'">Xóa tất cả bộ lọc</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitFilter() {
    const loaiId = document.getElementById('loaiSelect').value;
    const thuongHieuId = document.getElementById('thuongHieuSelect').value;
    const searchValue = document.getElementById('searchInput').value.trim();

    let baseUrl = "{{ url('user/car_shop/danhsachsanpham') }}";
    let finalUrl = baseUrl + '/' + loaiId + '/' + thuongHieuId;

    if (searchValue !== '') {
        finalUrl += '?search=' + encodeURIComponent(searchValue);
    }

    window.location.href = finalUrl;
}
</script>
@endsection