<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> body{ font-family: Arial; padding: 20px; } input, textarea { width: 100%; margin-bottom: 10px; padding: 8px; } </style>
</html>
</head>
<body>
<div class="main-content">
    <div class="card">
        <h2 class="page-title">THÊM THƯƠNG HIỆU MỚI</h2>

        <form method="POST"
              action="{{ url('/trang_admin/thuong_hieu/them') }}"
              enctype="multipart/form-data">
            @csrf

            <label>Tên Thương Hiệu:</label>
            <input type="text" name="ten_th" required>

            <label>Mã (Viết tắt):</label>
            <input type="text" name="ma_th">

            <label>Logo Thương Hiệu:</label>
            <input type="file" name="hinh_anh">

            <label>Trạng Thái:</label>
    <select name="trang_thai" style="width: 100%; padding: 8px;">
        <option value="1">Hiện</option>
        <option value="0">Ẩn</option>
    </select>

            <br><br>

            <button type="submit" class="btn btn-add" style="background: green;">
                LƯU LẠI
            </button>
        </form>
    </div>
</div>
</body>
</html>