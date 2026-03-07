<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('user/css/login_user.css') }}">
</head>

<body>

    <h2>Đăng ký tài khoản</h2>

    @csrf

    <div class="form-group auth-box">
        <input type="text" id="phone" placeholder="Số điện thoại">
    </div>

    <button type="button" onclick="sendOTP()">Gửi OTP</button>

    <div id="otp-box" style="display:none;">
        <input id="otp" placeholder="Nhập OTP">
        <button type="button" onclick="verifyOTP()">Xác minh</button>
    </div>

    <form method="POST" action="{{ route('dangky') }}" id="registerForm" style="display:none;">
        @csrf

        <input type="hidden" name="SDT" id="sdt_hidden">

        <div class="form-group auth-box">
            <input type="text" name="HoTen" placeholder="Họ và tên" required>
        </div>

        <div class="form-group auth-box">
            <input type="text" name="DiaChi" placeholder="Địa Chỉ" required>
        </div>

        <div class="form-group auth-box">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group auth-box">
            <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
        </div>

        <button type="submit" class="btn">Đăng ký</button>
    </form>

    <script>
    function sendOTP() {
        let phone = document.getElementById("phone").value;

        fetch("{{ route('gui.otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    phone: phone
                })
            })
            .then(res => res.json())
            .then(data => {
                alert("OTP của bạn là: " + data.otp);

                document.getElementById("otp-box").style.display = "block";
            })
            .catch(error => {
                alert("Có lỗi khi gửi OTP");
            });
    }

    function verifyOTP() {
        let otp = document.getElementById("otp").value;

        fetch("{{ route('xacminh.otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    otp: otp
                })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);

                if (data.message.includes("thành công")) {
                    document.getElementById("registerForm").style.display = "block";
                    document.getElementById("sdt_hidden").value =
                        document.getElementById("phone").value;
                }
            })
            .catch(error => {
                alert("OTP sai hoặc hết hạn");
            });
    }
    </script>

</body>

</html>