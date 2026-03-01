<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Xe - Showroom</title>
    <style>
        /* --- ĐỊNH DẠNG KHUNG CHUNG --- */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { display: flex; max-width: 1200px; margin: auto; gap: 20px; }

        /* --- CỘT TRÁI: BỘ LỌC --- */
        .sidebar { width: 25%; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: fit-content; }
        .sidebar h3 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;}
        .form-control { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-filter { width: 100%; padding: 10px; background: #111; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s;}
        .btn-filter:hover { background: #d4af37; color: black; }

        /* --- CỘT PHẢI: LƯỚI SẢN PHẨM --- */
        .main-content { width: 75%; }
        .product-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .product-card { background: white; border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .product-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 5px; margin-bottom: 10px; }
        .product-card h3 { font-size: 16px; margin: 10px 0; color: #333; height: 40px; overflow: hidden; }
        .product-card p { font-size: 18px; color: #d9534f; font-weight: bold; margin: 10px 0; }
        .product-card small { color: #777; display: block; margin-bottom: 10px;}
        .btn-gold { display: inline-block; padding: 8px 15px; background: #d4af37; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-gold:hover { background: #b5952f; }
        
        /* Phân trang */
        .pagination { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h3>LỌC SẢN PHẨM</h3>
        <form action="{{ url('/danhsachsanpham') }}" method="GET">
            
            <div class="form-group">
                <label>Tìm kiếm tên xe:</label>
                <input type="text" name="search" class="form-control" placeholder="Nhập tên xe..." value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label>Loại Xe:</label>
                <select name="MaLoai" class="form-control">
                    <option value="0">-- Tất cả loại xe --</option>
                    @foreach($loaiXeList as $loai)
                        <option value="{{ $loai->id_Loai_xe }}" {{ request('MaLoai') == $loai->id_Loai_xe ? 'selected' : '' }}>
                            {{ $loai->Ten_Loai_Xe }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Thương Hiệu:</label>
                <select name="MaThuongHieu" class="form-control">
                    <option value="0">-- Tất cả thương hiệu --</option>
                    @foreach($thuongHieuList as $th)
                        <option value="{{ $th->id_Thuong_Hieu }}" {{ request('MaThuongHieu') == $th->id_Thuong_Hieu ? 'selected' : '' }}>
                            {{ $th->Ten_Thuong_Hieu }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-filter">ÁP DỤNG LỌC</button>
        </form>
    </div>

    <div class="main-content">
        <div class="product-list">
            @forelse ($danhSachXe as $sp)
            <div class="product-card">
                <img src="{{ asset('upload/anh_dai_dien/' . $sp->Anh_Dai_Dien) }}" alt="{{ $sp->Ten_Xe }}">
                
                <h3>{{ $sp->Ten_Xe }}</h3>
                <small>{{ $sp->Ten_Thuong_Hieu ?? 'N/A' }} • {{ $sp->Ten_Loai_Xe ?? 'N/A' }}</small>
                <p>{{ number_format($sp->Gia_Mau ?? 0) }} đ</p>
                
                <a href="{{ url('/chi-tiet-san-pham/' . $sp->id_Xe) }}" class="btn-gold">Xem chi tiết</a>
            </div>
            @empty
                <p style="text-align:center; width: 100%; grid-column: 1 / -1;">Rất tiếc, không tìm thấy chiếc xe nào phù hợp với yêu cầu của bạn!</p>
            @endforelse
        </div>

        <div class="pagination">
            {{ $danhSachXe->withQueryString()->links() }}
        </div>
    </div>
</div>

</body>
</html>