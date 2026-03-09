<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Khung chứa ảnh: Cắt phần ảnh bị dư ra khi phóng to để không mất góc bo tròn */
        .img-wrapper {
            overflow: hidden; 
        }
        /* Ảnh bên trong: Cài đặt thời gian phóng to mượt mà (0.4 giây) */
        .hover-zoom {
            transition: transform 0.4s ease;
        }
        /* Khi rớt chuột vào toàn bộ cái Card, ảnh sẽ tự động to lên 8% */
        .card:hover .hover-zoom {
            transform: scale(1.08); 
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-funnel-fill me-2"></i> LỌC SẢN PHẨM</h5>
                </div>
                <div class="card-body bg-white p-4">
                    <form id="filterForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Tìm kiếm tên xe:</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="Nhập tên xe..." value="{{ request('search') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Loại Xe:</label>
                            <select id="loaiSelect" class="form-select">
                                <option value="0">-- Tất cả loại xe --</option>
                                @foreach($loaiXeList as $loai)
                                    <option value="{{ $loai->id_Loai_xe }}" @selected(isset($maLoai) && $maLoai == $loai->id_Loai_xe)>
                                        {{ $loai->Ten_Loai_Xe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Thương Hiệu:</label>
                            <select id="thuongHieuSelect" class="form-select">
                                <option value="0">-- Tất cả thương hiệu --</option>
                                @foreach($thuongHieuList as $th)
                                    <option value="{{ $th->id_Thuong_Hieu }}" @selected(isset($IDTH) && $IDTH == $th->id_Thuong_Hieu)>
                                        {{ $th->Ten_Thuong_Hieu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary w-100 fw-bold py-2" onclick="submitFilter()">ÁP DỤNG LỌC</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                @if(count($danhSachXe) > 0)
                    @foreach($danhSachXe as $xe)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-3">
                               <div class="img-wrapper rounded-top-3">
                                    <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}">
                                        <img src="{{ asset('upload/anh_dai_dien/' . $xe->Anh_Dai_Dien) }}" class="card-img-top hover-zoom" alt="{{ $xe->Ten_Xe }}" style="object-fit: cover; height: 200px;">
                                     </a>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}" class="text-decoration-none text-dark">
                                            {{ $xe->Ten_Xe }}
                                        </a>
                                    </h5>
                                    <p class="text-danger fw-bold fs-5">Giá: {{ number_format($xe->Gia_Mau) }} VNĐ</p>
                                    <p class="card-text text-muted small">{{ Str::limit($xe->Mo_Ta, 100) }}</p>
                                    <div class="mt-2">
                                        <span class="badge bg-info text-dark me-1">{{ $xe->Ten_Loai_Xe }}</span>
                                        <span class="badge bg-secondary">{{ $xe->Ten_Thuong_Hieu }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 pb-3 pt-0">
                                    <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}" class="btn btn-outline-primary w-100 fw-bold">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center mt-5">
                        <div class="alert alert-warning shadow-sm border-0 py-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2"></i>
                            <strong>Rất tiếc!</strong> Không tìm thấy chiếc xe nào phù hợp với yêu cầu của bạn.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
    </head>

<body>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
