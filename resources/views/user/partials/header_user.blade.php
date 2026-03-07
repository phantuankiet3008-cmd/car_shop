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
            <form action="{{ route('home') }}" method="GET">
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
                @auth
                    <a href="{{ url('/user/profile') }}">
                        <i class="fa-solid fa-circle-user"></i>
                        <span>Tài khoản</span>
                    </a>
                @else
                    <a href="{{ route('dangnhap') }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Đăng nhập</span>
                    </a>
                @endauth
            </div>

            <!-- CART -->
            <a href="{{ route('donhang') }}" class="cart-link">
                <i class="fas fa-shopping-cart"></i>
                <span>Đơn Hàng</span>
            </a>

            <!-- LOGOUT -->
            @auth
                <a href="{{ url('/user/logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Đăng xuất
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @endauth

        </div>
    </div>
</header>