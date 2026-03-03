<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('user/css/chitietsp.css') }}">
    <title>{{ $chitietsp['Ten_Xe'] }}</title>
</head>
<body>

<div class="chi_tiet_san_pham">

    <div class="tieu_de_xe">
        <h1 class="ten_xe">{{ $chitietsp['Ten_Xe'] }}</h1>

        <div class="gia_xe" id="giaChinh">
            {{ number_format($gia_mac_dinh, 0, ',', '.') }} đ
        </div>
    </div>

    <div class="noi_dung_chinh">

        {{-- ===== ẢNH XE ===== --}}
        <div class="khu_trai">

            @if(!empty($anh_xe_mau))
                <div class="anh_sp_lon">
                    <img id="mainImage"
                         src="{{ asset('upload/anh_xe_mau/'.$anh_xe_mau[0]['duong_dan']) }}">
                </div>

                <div class="anh_sp_nho">
                   @foreach($anh_xe_mau as $index => $anh)
    <img src="{{ asset('upload/anh_xe_mau/'.$anh['duong_dan']) }}"
         class="thumb"
         data-mau="{{ $anh['id_Xe_Mau'] }}">
@endforeach
                </div>
            @else
                <div class="anh_sp_lon">
                    <img src="{{ asset('upload/no-image.png') }}">
                </div>
            @endif


            {{-- ===== NÚT 3D ===== --}}
            <div class="khu_anh_3d">
                <button id="btn3D"
                        data-model="{{ asset('upload/anh_3d/'.$chitietsp['Anh_3d']) }}">
                    🔄 Xem mô hình xe 3D
                </button>
            </div>
            {{-- ===== KHUNG XEM 3D ===== --}}
    <div id="mo_hinh_3D" class="viewer3d hidden">
    <button class="close3d">✖</button>
    <div id="threeContainer" style="width:100%; height:500px;"></div>
    </div>
        

        <div>
            {{-- ===== thông tin chi tiết ===== --}}
            <div class="khu_thong_tin_chi_tiet">
                <h3>Thông tin chi tiết</h3>
                <p><strong>Loại xe:</strong> {{ $chitietsp['Ten_Loai_Xe'] }}</p>
                <p><strong>Thương hiệu:</strong> {{ $chitietsp['Ten_Thuong_Hieu'] }}</p>
                <p><strong>Mô tả:</strong> {{ $chitietsp['Mo_Ta'] }}</p>
        </div>

        </div>
        
</div>
    


        {{-- ===== PHẦN BÊN PHẢI ===== --}}
        <div class="khu_phai">

            {{-- ===== MÀU XE ===== --}}
            <div class="khu_mau_xe">
                <h4>Màu xe</h4>

                <div class="ds_mau">

                    @if(!empty($mau_xe))

                        @foreach($mau_xe as $index => $m)

                            <label class="item_mau">

                                <input type="radio"
       name="chon_mau"
       @checked($index==0)
       data-gia="{{ $m['Gia'] }}"
       data-mau="{{ $m['id_Xe_Mau'] }}">

                                <div class="noi_dung">
                                    <div class="trai">

                                        <span class="o_mau"
      style="background: {{ $m['Ma_Mau'] }}; width:20px; height:20px; display:inline-block; border:1px solid #ddd;"></span>

                                        <span class="ten_mau">
                                            {{ $m['Ten_Mau'] }}
                                        </span>
                                    </div>

                                    <span class="gia_mau">
                                        {{ number_format($m['Gia'], 0, ',', '.') }} đ
                                    </span>
                                </div>

                            </label>

                        @endforeach

                    @else
                        <p>Đang cập nhật màu...</p>
                    @endif

                </div>
            </div>


            {{-- ===== TÓM TẮT ĐƠN ===== --}}
            <div class="tom_tat_don">
                <h4>Tóm tắt đơn</h4>

                <p>Tên xe: {{ $chitietsp['Ten_Xe'] }}</p>

                <p>Giá gốc:
                <span id="giaTomTat"
                    data-gia-mac-dinh="{{ $gia_mac_dinh }}">
                    {{ number_format($gia_mac_dinh, 0, ',', '.') }}
                </span> đ
                </p>

                <p>Ưu đãi:</p>

                <ul id="danhSachUuDai">
                    @foreach($uu_dai as $ud)
                    <li 
                        data-loai="{{ $ud['Loai'] }}"
                        data-gia-tri="{{ $ud['Gia_Tri'] }}">
            
                    @if($ud['Loai'] == 'phan_tram')
                        {{ $ud['Gia_Tri'] }}%
                    @else
                        {{ number_format($ud['Gia_Tri'], 0, ',', '.') }} đ
                    @endif

                    </li>
                     @endforeach
                </ul>

                 <hr>

                 <p>
                <strong>
                 Tổng sau ưu đãi:
                    <span id="tongSauUuDai">
                       {{ number_format($gia_mac_dinh, 0, ',', '.') }}
                    </span> đ
                </strong>
                </p>
                 <p>
                <strong>
                Tiền cọc (1%):
                <span id="tienCoc">0</span> đ
                </strong>
                </p>
                
            <p><a href="{{ url('user/car_shop/dat_hang/'.$chitietsp['id_Xe']) }}" class="btn-dat-hang">ĐẶT CỌC</a></p>
            <a id="btnDatLich"
             href="{{ url('user/car_shop/dat_lich_lai_thu/'.$mau_xe[0]['id_Xe_Mau']) }}"
            class="btn-dat-lich">
            ĐẶT LỊCH LÁI THỬ
            </a>
            <p style="font-size:14px; margin-top:8px; color:#555;">
             Sau khi thanh toán 1% giá trị xe, showroom sẽ giữ quyền ưu tiên mua xe cho bạn trong vòng <strong>24 giờ</strong>.
             Đối với dòng xe cao cấp, chúng tôi khuyến khích khách hàng liên hệ trực tiếp để được tư vấn chi tiết trước khi đặt cọc.
            </p>
            </div>

        </div>
    </div>
</div>
{{-- ===== IMPORT THREE JS ===== --}}
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

    if (!mainImage) return;

    // ===== LỌC ẢNH THEO MÀU =====
    function filterImages(color) {

        let firstVisible = null;

        thumbs.forEach(img => {

            if (img.dataset.mau === color) {
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
    }

    // ===== CLICK THUMBNAIL =====
    thumbs.forEach(thumb => {
        thumb.addEventListener("click", function () {

            if (this.style.display === "none") return;

            mainImage.src = this.src;

            thumbs.forEach(t => t.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // ===== ĐỔI MÀU =====
    radios.forEach(radio => {

        radio.addEventListener("change", function () {

            const selectedColor = this.dataset.mau;
            filterImages(selectedColor);

        });

    });

    // ===== LOAD MẶC ĐỊNH =====
    const checked = document.querySelector('input[name="chon_mau"]:checked');
    if (checked) {
        filterImages(checked.dataset.mau);
    }

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const radios = document.querySelectorAll('input[name="chon_mau"]');
    const giaChinh = document.getElementById("giaChinh");
    const giaTomTat = document.getElementById("giaTomTat");
    const tongSauUuDai = document.getElementById("tongSauUuDai");
    const tienCoc = document.getElementById("tienCoc"); // thêm dòng này
    const dsUuDai = document.querySelectorAll("#danhSachUuDai li");
    // tính uu đãi
    function tinhGiaSauUuDai(gia) {

        let maxGiam = 0;

        dsUuDai.forEach(item => {

            let loai = item.dataset.loai;
            let value = parseFloat(item.dataset.giaTri);

            if (!value) return;

            let giam = 0;

            if (loai === 'phan_tram') {
                giam = gia * value / 100;
            } 
            else if (loai === 'tien') {
                giam = value;
            }

            if (giam > maxGiam) {
                maxGiam = giam;
            }

        });

        let tong = gia - maxGiam;

        if (tong < 0) tong = 0;

        return tong;
    }

    function capNhatGia(gia) {

        let giaFormat = Number(gia).toLocaleString('vi-VN');

        giaChinh.innerText = giaFormat + " đ";
        giaTomTat.innerText = giaFormat;

        let giaSauUuDai = tinhGiaSauUuDai(gia);

        tongSauUuDai.innerText =
            Number(giaSauUuDai).toLocaleString('vi-VN');

        //  TÍNH TIỀN CỌC 5%
        let tienCocValue = giaSauUuDai * 0.01;

        tienCoc.innerText =
            Number(tienCocValue).toLocaleString('vi-VN');
    }

    radios.forEach(radio => {
        radio.addEventListener("change", function () {

            let gia = parseFloat(this.dataset.gia);
            if (!gia) return;

            capNhatGia(gia);

        });
    });
    const btnDatLich = document.getElementById("btnDatLich");


    // Load mặc định
    const checked = document.querySelector('input[name="chon_mau"]:checked');
    if (checked) {
        capNhatGia(parseFloat(checked.dataset.gia));
    }
   


});
</script>