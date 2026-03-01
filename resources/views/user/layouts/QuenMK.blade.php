<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('user/css/login_user.css') }}">
</head>

<body>

    <div class="auth-page">
        <div class="auth-container">
            <h2>Quên mật khẩu</h2>

            <div class="auth-box">

                <input type="text" id="phone" placeholder="Nhập số điện thoại">

                <button type="button" onclick="sendOTP()" class="btn">
                    Gửi OTP
                </button>

                <div id="otp-box" style="display:none;">
                    <input type="text" id="otp" placeholder="Nhập OTP">
                    <button type="button" onclick="verifyOTP()" class="btn">
                        Xác minh OTP
                    </button>
                </div>

            </div>
        </div>
    </div>

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
                alert(data.message);
                document.getElementById("otp-box").style.display = "block";
            });
    }

    function verifyOTP() {
        let otp = document.getElementById("otp").value;
        let phone = document.getElementById("phone").value;

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
                    window.location.href =
                        "{{ route('form.capnhatmk') }}" + "?phone=" + phone;
                }
            });
    }
    </script>

</body>

</html>