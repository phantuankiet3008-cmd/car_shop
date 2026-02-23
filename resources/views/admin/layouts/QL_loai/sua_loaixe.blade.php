<!DOCTYPE html>
<html>
<head>
    <title>Sửa Loại Xe</title>
    <style> body{font-family: Arial; padding: 20px;} input, textarea, select {width: 100%; margin-bottom: 10px; padding: 8px;} </style>
</head>
<body>
<h2>SỬA LOẠI XE</h2>

<form method="POST"
      action="{{ url('/trang_admin/loai_xe/sua/' . $data['loai_xe']['id_Loai_xe']) }}"
      enctype="multipart/form-data">
    @csrf

    <label>Tên Loại Xe:</label>
    <input type="text" name="ten_loai"
           value="{{ $data['loai_xe']['Ten_Loai_Xe'] }}" required>

    <label>Slug:</label>
    <input type="text" name="slug"
           value="{{ $data['loai_xe']['Slug'] }}">

    <label>Mô Tả:</label>
    <textarea name="mo_ta">{{ $data['loai_xe']['Mo_Ta'] }}</textarea>

    <label>Hình Ảnh:</label>
    <input type="file" name="hinh_anh">
    <br>
    <img src="{{ asset('upload/anh_loai/' . $data['loai_xe']['Hinh_Anh_Loai']) }}"
         width="120">

    <label>Trạng Thái:</label>
    <select name="trang_thai">
        <option value="1" {{ $data['loai_xe']['Trang_Thai']==1?'selected':'' }}>Hiện</option>
        <option value="0" {{ $data['loai_xe']['Trang_Thai']==0?'selected':'' }}>Ẩn</option>
    </select>

    <br><br>
   <button type="submit" name="btn_update" style="padding: 10px 20px; background: orange; color: white; border: none;">CẬP NHẬT</button>
</form>
