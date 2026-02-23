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

<h2>THÊM LOẠI XE MỚI</h2>

<form method="POST" action="{{ url('/trang_admin/loai_xe/them') }}" enctype="multipart/form-data">
    @csrf

    <label>Tên Loại Xe:</label>
    <input type="text" name="ten_loai" required>

    <label>Slug:</label>
    <input type="text" name="slug">

    <label>Mô Tả:</label>
    <textarea name="mo_ta" rows="4"></textarea>

    <label>Hình Ảnh:</label>
    <input type="file" name="hinh_anh">

    <label>Trạng Thái:</label>
    <select name="trang_thai" style="width: 100%; padding: 8px;">
        <option value="1">Hiện</option>
        <option value="0">Ẩn</option>
    </select>

    <br><br>
     <button type="submit" name="btn_submit" style="padding: 10px 20px; background: green; color: white; border: none;">LƯU LẠI</button>
</form>
</body>
</html>