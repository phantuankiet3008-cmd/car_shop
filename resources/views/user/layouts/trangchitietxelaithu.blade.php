@extends('user.layouts.user_index')

@section('content')
{{-- Thông báo --}}
@if(session('success'))
    <div class="alert success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

<link rel="stylesheet" href="{{ asset('user/css/laithu.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="chi_tiet_san_pham">
    <div class="tieu_de_xe">
        <h1 class="ten_xe">{{ $chitietsp['Ten_Xe'] }}</h1>
        <div class="gia_xe" id="giaChinh">
            {{ number_format($gia_mac_dinh, 0, ',', '.') }} đ
        </div>
    </div>

    <div class="noi_dung_chinh">
        {{-- BÊN TRÁI --}}
        <div class="khu_trai">
            <div class="main-display-wrapper">
                <div id="vung_anh_xe" class="anh_sp_lon">
                    @if(!empty($anh_xe_mau))
                        <img id="mainImage" src="{{ $anh_xe_mau[0]['duong_dan'] }}" alt="{{ $chitietsp['Ten_Xe'] }}">
                    @else
                        <img src="{{ asset('upload/no-image.png') }}">
                    @endif
                </div>

                @if(!empty($chitietsp['Anh_3d']))
                    <button id="btn3D" class="btn-activate-3d" data-model="{{ asset($chitietsp['Anh_3d']) }}">
                        <i class="fa-solid fa-vr-cardboard"></i> XEM 3D
                    </button>
                @endif

                <div id="mo_hinh_3D" class="viewer3d hidden">
                    <div id="threeContainer"></div>
                    <button class="close3d"><i class="fa-solid fa-xmark"></i> Thoát 3D</button>
                </div>
            </div>

            <div class="anh_sp_nho">
                @foreach($anh_xe_mau as $index => $anh)
                    <img src="{{ $anh['duong_dan'] }}" 
                         class="thumb {{ $index == 0 ? 'active' : '' }}" 
                         data-mau="{{ $anh['id_Xe_Mau'] }}">
                @endforeach
            </div>
        </div>

        {{-- BÊN PHẢI --}}
        <div class="khu_phai">
            <div class="khu_mau_xe">
                <h4>Chọn màu ngoại thất</h4>
                <div class="ds_mau">
                    @foreach($mau_xe as $index => $m)
                        <label class="item_mau">
                            <input type="radio" name="chon_mau" 
                                @checked($index==0)
                                data-gia="{{ $m['Gia'] }}" 
                                data-mau="{{ $m['id_Xe_Mau'] }}"
                                data-soluong="{{ $m['So_Luong'] }}"
                                @disabled($m['So_Luong'] <= 0)>
                            
                            <div class="noi_dung" style="{{ $m['So_Luong'] <= 0 ? 'opacity: 0.5;' : '' }}">
                                <div class="trai">
                                    <span class="o_mau" style="background: {{ $m['Ma_Mau'] }}"></span>
                                    <div style="display: flex; flex-direction: column;">
                                        <span class="ten_mau">{{ $m['Ten_Mau'] }}</span>
                                        <small>Kho: {{$m['So_Luong'] }}</small>
                                    </div>
                                </div>
                                <span class="gia_mau">{{ number_format($m['Gia'], 0, ',', '.') }} đ</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Các ID ẩn để tránh lỗi JS --}}
            <div style="display:none">
                <span id="giaTomTat"></span>
                <span id="tongSauUuDai"></span>
                <span id="tienCoc"></span>
                <ul id="danhSachUuDai"></ul>
                <input type="hidden" id="input_id_xe_mau">
            </div>

            <div class="hanh_dong">
                <a id="btnDatLich" href="#" class="btn-dat-lich" style="display: none; justify-content: center; align-items: center; background: #000; color: #fff; padding: 15px; text-decoration: none; border-radius: 5px;">
                    <i class="fa-solid fa-calendar-check" style="margin-right: 8px;"></i> ĐẶT LỊCH LÁI THỬ
                </a>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainImage");
    const thumbs = document.querySelectorAll(".thumb");
    const radios = document.querySelectorAll('input[name="chon_mau"]');
    const giaChinh = document.getElementById("giaChinh");
    const btnDatLich = document.getElementById("btnDatLich");
    
    // Các phần tử có thể thiếu (kiểm tra an toàn)
    const giaTomTat = document.getElementById("giaTomTat");
    const tongSauUuDai = document.getElementById("tongSauUuDai");
    const tienCoc = document.getElementById("tienCoc");
    const inputIdXeMau = document.getElementById("input_id_xe_mau");
    const dsUuDai = document.querySelectorAll("#danhSachUuDai li");

    function updateState(selectedColor, price, soluong) {
        console.log("Cập nhật trạng thái cho màu ID:", selectedColor, "Số lượng:", soluong);

        // 1. Cập nhật ảnh Thumbnail
        let firstVisible = null;
        thumbs.forEach(img => {
            if (img.dataset.mau == selectedColor) {
                img.style.display = "inline-block";
                if (!firstVisible) firstVisible = img;
            } else {
                img.style.display = "none";
                img.classList.remove("active");
            }
        });
        if (firstVisible && mainImage) {
            mainImage.src = firstVisible.src;
            firstVisible.classList.add("active");
        }

        // 2. Cập nhật giá (Sử dụng try-catch hoặc check null)
        let formatPrice = Number(price).toLocaleString('vi-VN');
        if(giaChinh) giaChinh.innerText = formatPrice + " đ";
        if(giaTomTat) giaTomTat.innerText = formatPrice;

        // Tính toán ưu đãi (Chỉ chạy nếu có dữ liệu)
        let maxGiam = 0;
        if(dsUuDai.length > 0) {
            dsUuDai.forEach(item => {
                let loai = item.dataset.loai;
                let val = parseFloat(item.dataset.giaTri);
                let giam = (loai === 'phan_tram') ? (price * val / 100) : val;
                if (giam > maxGiam) maxGiam = giam;
            });
        }

        let total = Math.max(0, price - maxGiam);
        if(tongSauUuDai) tongSauUuDai.innerText = total.toLocaleString('vi-VN');
        if(tienCoc) tienCoc.innerText = (total * 0.01).toLocaleString('vi-VN');

        // 3. Xử lý nút Đặt Lịch Lái Thử
        if(inputIdXeMau) inputIdXeMau.value = selectedColor;

        if (soluong <= 0) {
            if (btnDatLich) btnDatLich.style.display = "none";
        } else {
            if (btnDatLich) {
                btnDatLich.style.display = "flex";
                // Tạo link động
                let urlAction = "{{ url('user/car_shop/dangkilaithu') }}/" + selectedColor;
                btnDatLich.setAttribute("href", urlAction);
                console.log("Link đặt lịch mới:", urlAction);
            }
        }
    }

    // Sự kiện khi chọn màu
    radios.forEach(r => {
        r.addEventListener("change", function() {
            updateState(this.dataset.mau, parseFloat(this.dataset.gia), parseInt(this.dataset.soluong));
        });
    });

    // Sự kiện click ảnh nhỏ
    thumbs.forEach(t => {
        t.addEventListener("click", function() {
            if(mainImage) mainImage.src = this.src;
            thumbs.forEach(x => x.classList.remove("active"));
            this.classList.add("active");
        });
    });

   
    const checked = document.querySelector('input[name="chon_mau"]:checked');
    if (checked) {
        updateState(checked.dataset.mau, parseFloat(checked.dataset.gia), parseInt(checked.dataset.soluong));
    }
});
</script>
@endsection