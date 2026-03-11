@extends('user.layouts.user_index')

@section('content')

<div class="dat_coc_page">

<div class="dat_coc_container">

{{-- ===== XE ===== --}}
<div class="box">

<h2>Thông tin xe</h2>

<p><b>Tên xe:</b> {{ $xe['Ten_Xe'] }}</p>
<p><b>Màu:</b> {{ $xe['Ten_Mau'] }}</p>
<p><b>Thương hiệu:</b> {{ $xe['Ten_Thuong_Hieu'] }}</p>
<p><b>Loại xe:</b> {{ $xe['Ten_Loai_Xe'] }}</p>

</div>


{{-- ===== KHÁCH HÀNG ===== --}}
<div class="box">

<h2>Thông tin khách hàng</h2>

<p><b>Tên:</b> {{ $khach['Ho_Ten'] }}</p>
<p><b>SĐT:</b> {{ $khach['So_Dien_Thoai'] }}</p>

<p><b>Email:</b> {{ $khach['Email'] }}</p>
<p><b>Địa chỉ:</b> {{ $khach['Dia_Chi'] }}</p>

</div>


{{-- ===== THANH TOÁN ===== --}}
<div class="box">

<h2>Thông tin đặt cọc</h2>

<p>Giá xe: {{ number_format($gia) }} đ</p>
<p>Giảm giá: {{ number_format($giam) }} đ</p>

<hr>

<p><b>Tổng sau ưu đãi:</b> {{ number_format($tong) }} đ</p>

<p>
<b>Tiền cọc (1%):</b>
<span class="tien_coc">
{{ number_format($tien_coc) }} đ
</span>
</p>

<form action="{{ url('user/car_shop/xac_nhan_dat_coc') }}" method="POST">

@csrf

<input type="hidden" name="id_xe_mau" value="{{ $xe['id_Xe_Mau'] }}">
<input type="hidden" name="tien_coc" value="{{ $tien_coc }}">
<input type="hidden" name="tong_tien" value="{{ $tong }}">
<input type="hidden" name="giam" value="{{ $giam }}">


<button class="btn-thanh-toan">
Xác nhận đặt cọc
</button>

</form>

</div>

</div>

</div>

@endsection