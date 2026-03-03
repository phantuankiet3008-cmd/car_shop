<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lịch lái thử</title>
    <link rel="stylesheet" href="{{ asset('user/css/dangkilaithu.css') }}">
</head>
<body>

<div class="lai_thu_container">

    <div class="lai_thu_tieu_de">
        <h2>ĐẶT LỊCH LÁI THỬ</h2>
    </div>

    <!-- Thông tin xe -->
    <div class="lai_thu_thong_tin_xe">
        <p><strong>Tên xe:</strong> {{ $chitietsp->Ten_Xe }}</p>
        <p><strong>Màu xe:</strong> {{ $xeMau->Ten_Mau }}</p>
        <p><strong>Địa chỉ: </strong></p>
        <p><strong>Loại xe:</strong> {{ $chitietsp->Ten_Loai_Xe }}</p>
        <p><strong>Thương hiệu:</strong> {{ $chitietsp->Ten_Thuong_Hieu }}</p>
        <p><strong>Mã xe màu:</strong> {{ $xeMau->id_Xe_Mau }}</p>
    </div>

    <!-- Form -->
    <form method="POST" action="" class="lai_thu_form">
        @csrf

        <!-- Quan trọng: gửi id xe màu -->
        <input type="hidden" id="id_xe_mau" value="{{ $xeMau->id_Xe_Mau }}">

        <div class="lai_thu_group">
            <label>Chọn ngày</label>
            <input type="date" 
                   name="ngay_lai_thu" 
                   id="ngay_lai_thu"
                   class="lai_thu_input"
                   required>
        </div>

        <div class="lai_thu_group">
            <label>Chọn giờ</label>
            <input type="time" 
                   name="gio_lai_thu" 
                   id="gio_lai_thu"
                   class="lai_thu_input"
                   required>
        </div>

        <button type="submit" class="lai_thu_btn">
            ĐẶT LỊCH
        </button>

    </form>
</div>

<!-- JS bắt sự kiện chọn ngày -->
<script>
document.getElementById('ngay_lai_thu').addEventListener('change', function() {

    let ngay = this.value;
    let idXeMau = document.getElementById('id_xe_mau').value;

    fetch('/user/car_shop/lay_gio_da_dat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            ngay: ngay,
            id_xe_mau: idXeMau
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Giờ đã đặt:", data);
    });

});
</script>

</body>
</html>