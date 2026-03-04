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
        <p><strong>Tên xe:</strong> {{ $thongTinXe->Ten_Xe }}</p>
        <p><strong>Màu xe:</strong> {{ $thongTinXe->Ten_Mau }}</p>
        <p><strong>Loại xe:</strong> {{ $thongTinXe->Ten_Loai_Xe }}</p>
        <p><strong>Thương hiệu:</strong> {{ $thongTinXe->Ten_Thuong_Hieu }}</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ url('user/car_shop/dat_lich_lai_thu') }}" class="lai_thu_form">
        @csrf

        <!-- gửi id xe màu -->
        <input type="hidden" 
               name="id_xe_mau"
               id="id_xe_mau" 
               value="{{ $thongTinXe->id_Xe_Mau }}">

        <!-- Chọn ngày -->
        <div class="lai_thu_group">
        <label>Chọn ngày</label>
        <input type="date" 
           name="ngay_lai_thu" 
           id="ngay_lai_thu"
           class="lai_thu_input"
           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
           max="{{ date('Y-m-d', strtotime('+7 days')) }}"
           required>
        </div>

        <!-- Chọn giờ -->
        <div class="lai_thu_group">
            <label>Chọn giờ</label>

            <div id="danh_sach_khung_gio" class="khung_gio_wrapper">

                @foreach($khungGio as $kg)
                    <label class="khung_gio_item">
                        <input type="radio"
                               name="id_Khung_Gio"
                               value="{{ $kg['id_Khung_Gio'] }}"
                               required>

                        <span class="gio_text">
                            {{ substr($kg['Gio_Bat_Dau'],0,5) }}
                            -
                            {{ substr($kg['Gio_Ket_Thuc'],0,5) }}
                        </span>
                    </label>
                @endforeach

            </div>
        </div>

        <button type="submit" class="lai_thu_btn">
            ĐẶT LỊCH
        </button>

    </form>
    {{-- Thông báo lỗi --}}
@if(session('error'))
    <div style="color: white; background: #e74c3c; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif

{{-- Thông báo thành công --}}
@if(session('success'))
    <div style="color: white; background: #27ae60; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif
</div>


<script>


let tatCaKhungGio = document.querySelectorAll('input[name="id_Khung_Gio"]');
let ngayInput = document.getElementById('ngay_lai_thu');

// 1️⃣ Khi vào trang → disable toàn bộ khung giờ
tatCaKhungGio.forEach(input => {
    input.disabled = true;
    input.parentElement.classList.add('slot_mo'); // class làm mờ
});
 
// 2️⃣ Nếu bấm vào slot khi chưa chọn ngày
tatCaKhungGio.forEach(input => {
    input.addEventListener('click', function(e) {
        if (!ngayInput.value) {
            e.preventDefault();
            alert("Vui lòng chọn ngày trước");
        }
        else if (this.disabled) {
            e.preventDefault();
            alert("Khung giờ này đã có người đặt, vui lòng chọn khung giờ khác");
        }
    });
});

// 3️⃣ Khi chọn ngày
ngayInput.addEventListener('change', function() {

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

        // reset toàn bộ slot
        
        tatCaKhungGio.forEach(input => {
            input.disabled = false;
            input.checked = false;
            input.parentElement.classList.remove('slot_da_dat');
            input.parentElement.classList.remove('slot_mo');
        });

        // nếu tất cả khung giờ đều bị đặt
        if (data.length === tatCaKhungGio.length) {
            alert("Ngày này đã kín, vui lòng chọn ngày khác");

            // disable lại toàn bộ
            tatCaKhungGio.forEach(input => {
                input.disabled = true;
                input.parentElement.classList.add('slot_mo');
            });

            return;
        }

        // disable những slot đã đặt
        data.forEach(id => {
            let slot = document.querySelector(
                'input[name="id_Khung_Gio"][value="' + id + '"]'
            );

            if (slot) {
                slot.disabled = true;
                slot.parentElement.classList.add('slot_da_dat');
            }
        });

    });

});

</script>

</body>
</html>