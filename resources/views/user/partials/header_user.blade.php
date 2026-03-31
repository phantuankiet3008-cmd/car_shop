<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<header class="top-header">
    <div class="container header-inner">

        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logoshop.png') }}" alt="Logo">
        </div>

        <!-- Search -->
<div class="search-box">
    <form action="{{ url('user/car_shop/danhsachsanpham/0/0') }}" method="GET">
        <input type="text"
               name="search"
               placeholder="Bạn đang tìm gì..."
               value="{{ request('search') }}">
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Right icons -->
<div class="header-icons">

    <!-- LOGIN / ACCOUNT -->
    <div class="login-info">
        @if(session('user_id'))
            <a href="{{ url('user/car_shop/trangcanhan') }}">
                <i class="fa-solid fa-circle-user"></i>
                <span>Tài khoản</span>
            </a>
        @else
            <a href="{{ url('user/car_shop/dangnhap') }}">
                <i class="fa-solid fa-user"></i>
                <span>Đăng nhập</span>
            </a>
        @endif
    </div>

    <!-- CART -->
    <a href="{{ url('user/car_shop/giohang') }}">
        <i class="fas fa-shopping-cart"></i>
        <span>Đơn Hàng</span>
    </a>

    <!-- LOGOUT -->
    @if(session('user_id'))
        <a href="{{ url('user/car_shop/dangxuat') }}">
            <i class="fas fa-sign-out-alt"></i>
            Đăng xuất
        </a>
    @endif

</div>

        </div>
    </div>
</header>