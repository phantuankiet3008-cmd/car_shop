<
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

<div class="col-md-3">
<div class="card p-3 mb-3">
<nav>
<div class="nav flex-column nav-pills">

<button class="nav-link active">Thông tin khách hàng</button>
<button class="nav-link">Đơn hàng & Đặt cọc</button>
<button class="nav-link">Đặt lịch bảo dưỡng</button>
<button class="nav-link">Lịch sử giao dịch</button>
<button class="nav-link">Thông báo</button>

</div>
</nav>
</div>
</div>

<div class="col-md-9">

<div class="card p-4 mb-3">
<div class="text-center">

<div class="avatar-wrapper">

@if(empty($khachhang->Avatar))
    <img src="{{ asset('upload/avatar/avatar.png') }}"
         class="avatar col-md-3">
@else
    <img src="{{ asset('upload/avatar/'.$khachhang->Avatar) }}"
         class="avatar col-md-3">
@endif

</div>

<p>{{ $khachhang->Ho_Ten }}</p>
<p>{{ $khachhang->So_Dien_Thoai }}</p>

</div>
</div>

<div class="tab-content">
<div class="tab-pane fade show active">
    <iframe src="{{ url('profile') }}" width="100%" height="600" style="border:none;"></iframe>
</div>
</div>

</div>
</div>
</div>


</body>
</html>