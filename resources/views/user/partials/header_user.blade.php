<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;     /* tròn */
    object-fit: cover;      /* không méo ảnh */
    border: 2px solid #eee; /* viền nhẹ */
    transition: all 0.3s ease;
}

/* Hover cho đẹp */
.user-info:hover .avatar {
    transform: scale(1.1);
    border-color: #0d6efd;
}
.user-info {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
}
</style>
<header class="top-header">
    <div class="container header-inner">

        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('upload/avatar/images/logoshop.png') }}" alt="Logo">
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

        <!-- Right -->
        <div class="header-icons">

    @php
        $isLogin = session('user_id');
        $name = session('user_name');
        $avatar = session('Avatar');
        $defaultAvatar = 'https://i.pinimg.com/736x/bc/43/98/bc439871417621836a0eeea768d60944.jpg';
    @endphp

    <!-- ACCOUNT -->
    <div class="login-info">
        @if($isLogin)
            <a href="{{ url('user/car_shop/trangcanhan') }}" class="user-info">
                
                <img src="{{ !empty($avatar) ? $avatar : $defaultAvatar }}"
                     alt="avatar"
                     class="avatar"
                     >

                <span>{{ $name }}</span>
            </a>
        @else
            <a href="{{ url('user/car_shop/dangnhap') }}">
                <i class="fa-solid fa-user"></i>
                <span>Đăng nhập</span>
            </a>
        @endif
    </div>

    <!-- HỢP ĐỒNG -->
    @if($isLogin)
        <a href="{{ url('/user/car_shop/don_cua_toi') }}" class="menu-item">
            <i class="fas fa-file-contract"></i>
            <span>Hợp đồng</span>
        </a>
    @endif

    <!-- LOGOUT -->
    @if($isLogin)
        <a href="{{ url('user/car_shop/dangxuat') }}" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
        </a>
    @endif

</div>

    </div>
</header>