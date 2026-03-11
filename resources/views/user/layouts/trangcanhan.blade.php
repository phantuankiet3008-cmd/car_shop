
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Trang khách hàng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profie.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css') }}">

</head>

<body>

<div class="container-fluid mt-4">
<div class="row">

<!-- MENU BÊN TRÁI -->
<div class="col-md-3">
<div class="card p-3 mb-3">

<div class="nav flex-column nav-pills">

<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#thongtin">
Thông tin khách hàng
</button>

<button class="nav-link" data-bs-toggle="pill" data-bs-target="#donhang">
Đơn hàng & Đặt cọc
</button>

<button class="nav-link" data-bs-toggle="pill" data-bs-target="#baoduong">
Đặt lịch bảo dưỡng
</button>

<button class="nav-link" data-bs-toggle="pill" data-bs-target="#giaodich">
Lịch sử giao dịch
</button>

<button class="nav-link" data-bs-toggle="pill" data-bs-target="#thongbao">
Thông báo
</button>

</div>

</div>
</div>


<!-- NỘI DUNG -->
<div class="col-md-9">

<div class="card p-4 mb-3">

<div class="text-center">

<div class="avatar-wrapper">

@if(empty($khachhang['Avatar']))
<img src="{{ asset('upload/avatar/avatar.png') }}" 
     class="avatar" id="avatarImg">
@else
<img src="{{ asset('upload/avatar/'.$khachhang['Avatar']) }}" 
     class="avatar" id="avatarImg"
     style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
@endif

<p style="text-align:center;font-weight:600;font-size:20px;color:#000;">
    {{ $khachhang['Ho_Ten'] ?? '' }}
</p>
<p style="text-align:center;font-weight:600;font-size:18px;color:#000;">
    {{ $khachhang['So_Dien_Thoai'] ?? '' }}
</p>

</div>

</div>


<!-- TAB CONTENT -->
<div class="tab-content mt-4">

<div class="tab-pane fade show active" id="thongtin">
    <iframe src="{{ url('user/car_shop/profile') }}" width="100%" height="600" style="border:none;"></iframe>
</div>

<div class="tab-pane fade" id="donhang">
    <div class="p-3">
        Nội dung đơn hàng
    </div>
</div>

<div class="tab-pane fade" id="baoduong">
    <div class="p-3">
        Nội dung bảo dưỡng
    </div>
</div>

<div class="tab-pane fade" id="giaodich">
    <div class="p-3">
        Nội dung lịch sử giao dịch
    </div>
</div>

<div class="tab-pane fade" id="thongbao">
    <div class="p-3">
        Nội dung thông báo
    </div>
</div>
</div>

</div>
</div>

</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>