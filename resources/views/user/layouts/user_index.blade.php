<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Cửa Hàng Point </title>

    <link rel="stylesheet" href="{{ asset('user/css/giaodien_user.css') }}">
</head>
<body>

    @include('user.partials.header_user')
    @include('user.layouts.navbar_user')
    <div class="content">
        @yield('content')
    </div>

    @include('user.partials.footer_user')

    <script src="{{ asset('js/slider.js') }}"></script>
</body>
</html>