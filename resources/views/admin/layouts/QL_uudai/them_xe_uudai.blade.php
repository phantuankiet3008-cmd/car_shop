

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Áp Dụng Ưu Đãi</title>
    <style>
       
        .form-container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        select { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        .btn-submit { width: 100%; padding: 12px; background: #007bff; color: white; border: none; cursor: pointer; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="form-container">
    <h2 style="text-align:center">ÁP DỤNG ƯU ĐÃI CHO XE</h2>

    <form method="POST" action="{{ url('/trang_admin/xe_uu_dai/them') }}">
        @csrf

        <label>1. Chọn Xe:</label>
        <select name="id_xe" required>
            <option value="">-- Chọn xe muốn giảm giá --</option>
            @foreach($data['danh_sach_xe'] as $car)
                <option value="{{ $car['id_Xe'] }}">
                    {{ $car['Ten_Xe'] }} (ID: {{ $car['id_Xe'] }})
                </option>
            @endforeach
        </select>

        <label>2. Chọn Chương Trình Ưu Đãi:</label>
        <select name="id_uu_dai" required>
            <option value="">-- Chọn khuyến mãi --</option>
            @foreach($data['danh_sach_uudai'] as $d)
                <option value="{{ $d['id_Uu_Dai'] }}">
                    {{ $d['Ten_Uu_Dai'] }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-submit">LƯU & ÁP DỤNG</button>

        <br><br>

        <a href="{{ url('/trang_admin/xe_uu_dai') }}" style="display:block; text-align:center;">
            Quay lại danh sách
        </a>
    </form>
</div>
</body>
</html>