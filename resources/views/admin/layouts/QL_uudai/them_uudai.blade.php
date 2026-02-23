

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Ưu Đãi Mới</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; margin-top: 15px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        .btn-submit:hover { background-color: #218838; }
        .btn-back { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #666; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>+ THÊM ƯU ĐÃI</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/trang_admin/uu_dai/them') }}">
        @csrf

        <label>Tên Chương Trình:</label>
        <input type="text" name="ten" required placeholder="VD: Sale Tết 2026">

        <label>Loại Giảm Giá:</label>
        <select name="loai">
            <option value="phan_tram">Giảm theo %</option>
            <option value="tien_mat">Giảm tiền mặt (VNĐ)</option>
        </select>

        <label>Giá Trị (Số):</label>
        <input type="number" name="gia_tri" required placeholder="VD: 10 hoặc 500000">

        <label>Ngày Bắt Đầu:</label>
        <input type="date" name="ngay_bd" required>

        <label>Ngày Kết Thúc:</label>
        <input type="date" name="ngay_kt" required>

        <label>Trạng Thái:</label>
        <select name="trang_thai">
            <option value="1">Đang chạy</option>
            <option value="0">Tạm dừng</option>
        </select>

        <button type="submit" class="btn-submit">LƯU LẠI</button>

        <a href="{{ url('/trang_admin/uu_dai') }}" class="btn-back">
            Quay lại danh sách
        </a>
    </form>
</div>
</body>
