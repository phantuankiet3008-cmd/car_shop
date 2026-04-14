@extends('user.layouts.user_index')

@section('content')
{{-- THÔNG BÁO --}}
@if(session('success'))
    <div class="alert success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert error">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ session('error') }}
    </div>
@endif

<link rel="stylesheet" href="{{ asset('user/css/chitietsp.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="chi_tiet_san_pham">
    {{-- Header: Tên và Giá --}}
    <div class="tieu_de_xe">
        <h1 class="ten_xe">{{ $chitietsp['Ten_Xe'] }}</h1>
        <div class="gia_xe" id="giaChinh">
            {{ number_format($gia_mac_dinh, 0, ',', '.') }} đ
        </div>
    </div>

    <div class="noi_dung_chinh">
        {{-- BÊN TRÁI: Ảnh và Thông tin --}}
        <div class="khu_trai">
            <div class="main-display-wrapper">
                {{-- Khu vực ảnh 2D --}}
                <div id="vung_anh_xe" class="anh_sp_lon">
                    @if(!empty($anh_xe_mau))
                        <img id="mainImage" src="{{ $anh_xe_mau[0]['duong_dan'] }}" alt="{{ $chitietsp['Ten_Xe'] }}">
                    @else
                        <img src="{{ asset('upload/no-image.png') }}">
                    @endif
                </div>

                {{-- Nút kích hoạt 3D --}}
                @if(!empty($chitietsp['Anh_3d']))
                    <button id="btn3D" class="btn-activate-3d" data-model="{{ asset($chitietsp['Anh_3d']) }}">
                        <i class="fa-solid fa-vr-cardboard"></i> XEM 3D
                    </button>
                @endif

                {{-- Khu vực 3D --}}
                <div id="mo_hinh_3D" class="viewer3d hidden">
                    <div id="threeContainer"></div>
                    <button class="close3d"><i class="fa-solid fa-xmark"></i> Thoát 3D</button>
                    <div class="instructions-3d">
                        <i class="fa-solid fa-hand-pointer"></i> Kéo để xoay • Cuộn để phóng to
                    </div>
                </div>
            </div>

            {{-- Thumbnails --}}
            <div class="anh_sp_nho">
                @foreach($anh_xe_mau as $index => $anh)
                    <img src="{{ $anh['duong_dan'] }}" 
                         class="thumb {{ $index == 0 ? 'active' : '' }}" 
                         data-mau="{{ $anh['id_Xe_Mau'] }}">
                @endforeach
            </div>

            <div class="khu_thong_tin_chi_tiet">
                <h3><i class="fa-solid fa-circle-info"></i> Đặc điểm nổi bật</h3>
                <p>{!! nl2br(e($chitietsp['Mo_Ta'])) !!}</p>
            </div>
        </div>

        {{-- BÊN PHẢI: Chọn màu và Thanh toán --}}
        <div class="khu_phai">
            <div class="khu_mau_xe">
                <h4>Chọn màu ngoại thất</h4>
                <div class="ds_mau">
                    @if(!empty($mau_xe))
                        @php $hasChecked = false; @endphp
                        @foreach($mau_xe as $index => $m)
                            <label class="item_mau">
                                <input type="radio" name="chon_mau" 
                                    @if($m['So_Luong'] > 0 && !$hasChecked) 
                                        checked @php $hasChecked = true; @endphp 
                                    @elseif($index == 0 && !$hasChecked)
                                        checked
                                    @endif
                                    data-gia="{{ $m['Gia'] }}" 
                                    data-mau="{{ $m['id_Xe_Mau'] }}"
                                    data-soluong="{{ $m['So_Luong'] }}"
                                    @disabled($m['So_Luong'] <= 0)>
                                
                                <div class="noi_dung" style="{{ $m['So_Luong'] <= 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                                    <div class="trai">
                                        <span class="o_mau" style="background: {{ $m['Ma_Mau'] }}"></span>
                                        <div style="display: flex; flex-direction: column;">
                                            <span class="ten_mau">{{ $m['Ten_Mau'] }}</span>
                                            <span class="so_luong">Kho: {{$m['So_Luong'] }}</span>
                                            @if($m['So_Luong'] <= 0)
                                                <small style="color: #ef4444; font-weight: bold;">Hết hàng</small>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="gia_mau">{{ number_format($m['Gia'], 0, ',', '.') }} đ</span>
                                </div>
                            </label>
                        @endforeach
                    @else
                        <p>Đang cập nhật màu...</p>
                    @endif
                </div>
            </div>

            <div class="tom_tat_don">
                <h4>Tóm tắt đơn đặt hàng</h4>
                <div class="chi_tiet_don">
                    <p>Xe: <strong>{{ $chitietsp['Ten_Xe'] }}</strong></p>
                    <p>Giá niêm yết: <span id="giaTomTat"></span> đ</p>
                    <div class="uu_dai_list">
                        <span>Ưu đãi áp dụng:</span>
                        <ul id="danhSachUuDai">
                            @foreach($uu_dai as $ud)
                                <li data-loai="{{ $ud['Loai'] }}" data-gia-tri="{{ $ud['Gia_Tri'] }}">
                                    <i class="fa-solid fa-tag"></i> 
                                    {{ $ud['Loai'] == 'phan_tram' ? $ud['Gia_Tri'].'%' : number_format($ud['Gia_Tri'], 0, ',', '.').' đ' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="tong_ket">
                    <p><span>Tổng sau giảm:</span> <strong id="tongSauUuDai">0</strong> đ</p>
                    <p class="coc"><strong>Đặt cọc (1%):</strong> <strong id="tienCoc">0</strong> đ</p>
                </div>

                <div class="hanh_dong">
                    @if(!empty($mau_xe))
                        <form id="formDatCoc" action="{{ route('datcoc')}}" method="POST">
                            @csrf
                            <input type="hidden" id="input_id_xe_mau" name="id_xe_mau" value="{{ $mau_xe[0]['id_Xe_Mau'] }}">
                            <button type="submit" class="btn-dat-hang">
                                <i class="fa-solid fa-cart-arrow-down"></i> TIẾN HÀNH ĐẶT CỌC
                            </button>
                        </form>
                        
                        <a id="btnDatLich" href="#" class="btn-dat-lich">
                            <i class="fa-solid fa-calendar-check"></i> ĐẶT LỊCH LÁI THỬ
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
    "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
  }
}
</script>
<script type="module" src="{{ asset('user/js/mo_hinh_3D.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainImage");
    const thumbs = document.querySelectorAll(".thumb");
    const radios = document.querySelectorAll('input[name="chon_mau"]');
    const giaChinh = document.getElementById("giaChinh");
    const giaTomTat = document.getElementById("giaTomTat");
    const tongSauUuDai = document.getElementById("tongSauUuDai");
    const tienCoc = document.getElementById("tienCoc");
    const dsUuDai = document.querySelectorAll("#danhSachUuDai li");
    
    const btnDatLich = document.getElementById("btnDatLich");
    const btnDatHang = document.querySelector(".btn-dat-hang");
    const inputIdXeMau = document.getElementById("input_id_xe_mau");

    function updateState(selectedColor, price, soluong) {
        // 1. Cập nhật ảnh
        let firstVisible = null;
        thumbs.forEach(img => {
            if (img.dataset.mau === selectedColor) {
                img.style.display = "inline-block";
                if (!firstVisible) firstVisible = img;
            } else {
                img.style.display = "none";
                img.classList.remove("active");
            }
        });
        if (firstVisible) {
            mainImage.src = firstVisible.src;
            firstVisible.classList.add("active");
        }

        // 2. Cập nhật giá
        let formatPrice = Number(price).toLocaleString('vi-VN');
        giaChinh.innerText = formatPrice + " đ";
        giaTomTat.innerText = formatPrice;

        let maxGiam = 0;
        dsUuDai.forEach(item => {
            let loai = item.dataset.loai;
            let val = parseFloat(item.dataset.giaTri);
            let giam = (loai === 'phan_tram') ? (price * val / 100) : val;
            if (giam > maxGiam) maxGiam = giam;
        });

        let total = Math.max(0, price - maxGiam);
        tongSauUuDai.innerText = total.toLocaleString('vi-VN');
        tienCoc.innerText = (total * 0.01).toLocaleString('vi-VN');

        // 3. Xử lý Logic Số lượng (Quan trọng)
        inputIdXeMau.value = selectedColor;

        if (soluong <= 0) {
            if (btnDatLich) btnDatLich.style.display = "none";
            if (btnDatHang) {
                btnDatHang.disabled = true;
                btnDatHang.style.opacity = "0.5";
                btnDatHang.style.cursor = "not-allowed";
                btnDatHang.innerHTML = '<i class="fa-solid fa-box-open"></i> TẠM HẾT HÀNG';
            }
        } else {
            if (btnDatLich) {
                btnDatLich.style.display = "flex";
                btnDatLich.href = "{{ url('user/car_shop/dangkilaithu') }}/" + selectedColor;
            }
            if (btnDatHang) {
                btnDatHang.disabled = false;
                btnDatHang.style.opacity = "1";
                btnDatHang.style.cursor = "pointer";
                btnDatHang.innerHTML = '<i class="fa-solid fa-cart-arrow-down"></i> TIẾN HÀNH ĐẶT CỌC';
            }
        }
    }

    radios.forEach(r => {
        r.addEventListener("change", function() {
            updateState(this.dataset.mau, parseFloat(this.dataset.gia), parseInt(this.dataset.soluong));
        });
    });

    thumbs.forEach(t => {
        t.addEventListener("click", function() {
            mainImage.src = this.src;
            thumbs.forEach(x => x.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Khởi tạo mặc định
    const checked = document.querySelector('input[name="chon_mau"]:checked');
    if (checked) {
        updateState(checked.dataset.mau, parseFloat(checked.dataset.gia), parseInt(checked.dataset.soluong));
    }
});
</script>
@endsection