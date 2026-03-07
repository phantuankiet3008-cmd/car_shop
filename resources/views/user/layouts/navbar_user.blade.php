<nav class="main-nav">
<ul class="menu">

<li>
<a href="{{ route('home') }}">HÀNG MỚI</a>
</li>

<li class="nav-product">

<button class="product-btn" onclick="toggleMenu()">
🚗 SẢN PHẨM
</button>

<div class="product-panel" id="subMenu">

<div class="product-panel-header">
Lọc xe theo nhu cầu
</div>

<div class="product-filter">

<div class="filter-group">
<h4>🚙 Loại xe</h4>

@foreach($listLoai as $loai)

<a href="{{ url('/user/danhsachsanpham?MaLoai='.$loai['id_Loai_Xe']) }}"
class="{{ $MaLoai == $loai['id_Loai_Xe'] ? 'active' : '' }}">

{{ $loai['Ten_Loai_Xe'] }}

</a>

@endforeach

</div>

<div class="filter-group">

<h4>🏷️ Thương hiệu</h4>

@foreach($listThuongHieu as $th)

<a href="{{ url('/user/danhsachsanpham?MaLoai='.$MaLoai.'&MaThuongHieu='.$th['id_Thuong_Hieu']) }}"
class="{{ $MaThuongHieu == $th['id_Thuong_Hieu'] ? 'active' : '' }}">

{{ $th['Ten_Thuong_Hieu'] }}

</a>

@endforeach

</div>

</div>
</div>

</li>

<li>
<a href="#">MUA HÀNG</a>
</li>

<li>
<a href="#">HỖ TRỢ VÀ DỊCH VỤ</a>
</li>

</ul>
</nav>