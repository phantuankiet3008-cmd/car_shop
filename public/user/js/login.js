document.addEventListener('DOMContentLoaded', function () {

    const isLogin = sessionStorage.getItem('isLogin');

    const icon = document.getElementById('user-icon');
    const textLogin = document.getElementById('text-login');
    const userLink = document.getElementById('user-link');
    const logoutLink = document.getElementById('logout-link');

    if (!icon || !textLogin || !userLink) return;

    // ===== ĐÃ ĐĂNG NHẬP =====
    if (isLogin === 'true') {
        icon.className = 'fa-solid fa-circle-user';
        textLogin.textContent = 'Tài khoản';
        userLink.href = 'car_shop/trangcanhan';
    }
    // ===== CHƯA ĐĂNG NHẬP =====
    else {
        icon.className = 'fa-solid fa-user';
        textLogin.textContent = 'Đăng nhập';
        userLink.href = 'car_shop/dangnhap';
    }

    // ===== LOGOUT =====
    if (logoutLink) {
        logoutLink.addEventListener('click', function () {
            sessionStorage.setItem('isLogin', 'false');
        });
    }

});
