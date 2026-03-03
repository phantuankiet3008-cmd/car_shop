<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @if(count($danhSachXe) > 0)
                    @foreach($danhSachXe as $xe)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset('upload/anh_dai_dien/' . $xe->Anh_Dai_Dien) }}" class="card-img-top" alt="{{ $xe->Ten_Xe }}">                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $xe->Ten_Xe }}</h5>
                                    <p class="text-danger fw-bold">Giá: {{ number_format($xe->Gia_Mau) }} VNĐ</p>
                                    <p class="card-text text-muted small">{{ Str::limit($xe->Mo_Ta, 100) }}</p>
                                    <span class="badge bg-info text-dark">{{ $xe->Ten_Loai_Xe }}</span>
                                    <span class="badge bg-secondary">{{ $xe->Ten_Thuong_Hieu }}</span>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <a href="{{ url('user/car_shop/chitietxe/' . $xe->id_Xe) }}" class="btn btn-primary w-100">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="alert alert-warning">Không tìm thấy chiếc xe nào phù hợp!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
    </head>

<body>

<div class="container">
    <div class="sidebar">
        <h3>LỌC SẢN PHẨM</h3>
        
        <form id="filterForm">
            
            <div class="form-group">
                <label>Tìm kiếm tên xe:</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Nhập tên xe..." value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label>Loại Xe:</label>
                <select id="loaiSelect" class="form-control">
                    <option value="0">-- Tất cả loại xe --</option>
                    @foreach($loaiXeList as $loai)

                        <option value="{{ $loai->id_Loai_xe }}" @selected(isset($IDloai) && $IDloai == $loai->id_Loai_xe)>

                            {{ $loai->Ten_Loai_Xe }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Thương Hiệu:</label>
                <select id="thuongHieuSelect" class="form-control">
                    <option value="0">-- Tất cả thương hiệu --</option>
                    @foreach($thuongHieuList as $th)
                        <option value="{{ $th->id_Thuong_Hieu }}" @selected(isset($thuongHieu) && $thuongHieu == $th->id_Thuong_Hieu)>
                            {{ $th->Ten_Thuong_Hieu }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="button" class="btn-filter" onclick="submitFilter()">ÁP DỤNG LỌC</button>
        </form>
    </div>
</div>


<script>
function submitFilter() {
    // 1. Lấy dữ liệu từ các input
    const loaiId = document.getElementById('loaiSelect').value;
    const thuongHieuId = document.getElementById('thuongHieuSelect').value;
    const searchValue = document.getElementById('searchInput').value.trim();

    // 2. Tạo URL theo chuẩn Route bạn đã cấu hình
    let url = `/user/car_shop/danhsachsanpham/${IDloai}/${IDTH}`;

    // 3. Nếu có nhập chữ để tìm, thì gắn thêm Query String
    if (searchValue !== '') {
        url += `?search=${encodeURIComponent(searchValue)}`;
    }

    // 4. Chuyển hướng trình duyệt
    window.location.href = url;
}
</script>

</body>
</html>
