<!DOCTYPE html>
<html>
<head>
    <title>Sửa Loại Xe</title>
 <style>
    /* Container chính bao phủ toàn bộ vùng nội dung */
    .admin-form-container {
        width: 100%; /* Chiếm hết chiều rộng vùng content */
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        min-height: calc(100vh - 150px); /* Kéo dài chiều cao cho bớt trống */
    }

    .admin-form-container h2 {
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 35px;
        border-left: 5px solid #6366f1; /* Thêm vạch tím cho sang */
        padding-left: 15px;
        text-transform: uppercase;
    }

    /* Bố cục form theo lưới (Grid) để tận dụng không gian rộng */
    .admin-form-container form {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Chia form làm 2 cột */
        gap: 25px;
    }

    /* Những ô cần kéo dài hết 2 cột (như Mô tả) */
    .admin-form-container .full-width {
        grid-column: span 2;
    }

    .admin-form-container .input-group {
        display: flex;
        flex-direction: column;
    }

    .admin-form-container label {
        font-weight: 600;
        font-size: 14px;
        color: #475569;
        margin-bottom: 8px;
    }

    .admin-form-container input[type="text"],
    .admin-form-container textarea,
    .admin-form-container select {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 15px;
        background: #fcfcfc;
        transition: 0.3s;
    }

    .admin-form-container input:focus, 
    .admin-form-container textarea:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .admin-form-container textarea {
        min-height: 120px;
    }

    /* Nút bấm căn về phía cuối form */
    .btn-submit-modern {
        grid-column: span 2; /* Nút kéo dài hết chiều rộng */
        justify-self: start; /* Hoặc 'stretch' nếu muốn nút to hết cỡ */
        width: 200px;
        background: #6366f1;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        font-size: 16px;
    }

    .btn-submit-modern:hover {
        background: #4f46e5;
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.3);
    }

    /* Responsive cho màn hình nhỏ */
    @media (max-width: 1024px) {
        .admin-form-container form {
            grid-template-columns: 1fr;
        }
        .admin-form-container .full-width {
            grid-column: span 1;
        }
    }
</style>
</head>
<body>
    <div class="admin-form-container">
    <h2>Sửa Loại Xe</h2>

    <form method="POST" action="..." enctype="multipart/form-data">
        @csrf

        <div class="input-group">
            <label>Tên Loại Xe:</label>
            <input type="text" name="ten_loai" value="{{ $data['loai_xe']['Ten_Loai_Xe'] }}" required>
        </div>

        <div class="input-group">
            <label>Slug:</label>
            <input type="text" name="slug" value="{{ $data['loai_xe']['Slug'] }}">
        </div>

        <div class="input-group full-width"> <label>Mô Tả:</label>
            <textarea name="mo_ta">{{ $data['loai_xe']['Mo_Ta'] }}</textarea>
        </div>

        <div class="input-group">
            <label>Hình Ảnh:</label>
            <input type="file" name="hinh_anh">
            <div style="margin-top:10px">
                <img src="{{ $data['loai_xe']['Hinh_Anh_Loai'] }}" width="120" style="border-radius:8px">
            </div>
        </div>

        <div class="input-group">
            <label>Trạng Thái:</label>
            <select name="trang_thai">
                <option value="1" {{ $data['loai_xe']['Trang_Thai']==1?'selected':'' }}>Hiện</option>
                <option value="0" {{ $data['loai_xe']['Trang_Thai']==0?'selected':'' }}>Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn-submit-modern">CẬP NHẬT</button>
    </form>
</div>