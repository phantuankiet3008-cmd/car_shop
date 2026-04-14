 <style>
    /* Container chính bao phủ toàn bộ vùng nội dung */
    .admin-form-container {
        width: 100%; /* Chiếm hết chiều rộng vùng content */
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        min-height: calc(100vh - 150px); /* Kéo dài chiều cao cho bớt trống */
    }

    .admin-form-container h2 {
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 35px;
        border-left: 5px solid #6366f1; /* Thêm vạch tím cho sang */
        padding-left: 15px;
        text-transform: uppercase;
    }

    /* Bố cục form theo lưới (Grid) để tận dụng không gian rộng */
    .admin-form-container form {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Chia form làm 2 cột */
        gap: 25px;
    }

    /* Những ô cần kéo dài hết 2 cột (như Mô tả) */
    .admin-form-container .full-width {
        grid-column: span 2;
    }

    .admin-form-container .input-group {
        display: flex;
        flex-direction: column;
    }

    .admin-form-container label {
        font-weight: 600;
        font-size: 14px;
        color: #475569;
        margin-bottom: 8px;
    }

    .admin-form-container input[type="text"],
    .admin-form-container textarea,
    .admin-form-container select {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 15px;
        background: #fcfcfc;
        transition: 0.3s;
    }

    .admin-form-container input:focus, 
    .admin-form-container textarea:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .admin-form-container textarea {
        min-height: 120px;
    }

    /* Nút bấm căn về phía cuối form */
    .btn-submit-modern {
        grid-column: span 2; /* Nút kéo dài hết chiều rộng */
        justify-self: start; /* Hoặc 'stretch' nếu muốn nút to hết cỡ */
        width: 200px;
        background: #6366f1;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        font-size: 16px;
    }

    .btn-submit-modern:hover {
        background: #4f46e5;
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.3);
    }

    /* Responsive cho màn hình nhỏ */
    @media (max-width: 1024px) {
        .admin-form-container form {
            grid-template-columns: 1fr;
        }
        .admin-form-container .full-width {
            grid-column: span 1;
        }
    }
</style>
<div class="admin-form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-user-gear"></i> Chỉnh Sửa Khách Hàng</h2>
        <p>Cập nhật thông tin chi tiết và trạng thái hoạt động của tài khoản #{{ $data['khach_hang']['id_Khach_Hang'] }}</p>
    </div>

    {{-- Phần Thông báo Alert --}}
    @if(session('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    @if(session('error') || $errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            @if(session('error')) {{ session('error') }} @else Vui lòng kiểm tra lại dữ liệu nhập vào! @endif
            @if($errors->any())
                <ul style="margin-top: 5px; font-size: 13px;">
                    @foreach($errors->all() as $error) <li>- {{ $error }}</li> @endforeach
                </ul>
            @endif
        </div>
    @endif

    <form method="POST" action="{{ url('/trang_admin/khach_hang/sua/'.$data['khach_hang']['id_Khach_Hang']) }}">
        @csrf
        <input type="hidden" name="id_Khach_Hang" value="{{ $data['khach_hang']['id_Khach_Hang'] }}">

        <div class="input-group">
            <label>Họ và tên:</label>
            <input type="text" name="Ho_Ten" value="{{ old('Ho_Ten', $data['khach_hang']['Ho_Ten']) }}" required>
        </div>

        <div class="input-group">
            <label>Email:</label>
            <input type="email" name="Email" value="{{ old('Email', $data['khach_hang']['Email']) }}" required>
        </div>

        <div class="input-group">
            <label>Số điện thoại:</label>
            <input type="text" name="So_Dien_Thoai" value="{{ old('So_Dien_Thoai', $data['khach_hang']['So_Dien_Thoai']) }}">
        </div>

        <div class="input-group">
            <label>Địa chỉ:</label>
            <input type="text" name="Dia_Chi" value="{{ old('Dia_Chi', $data['khach_hang']['Dia_Chi']) }}">
        </div>

        <div class="input-group">
            <label>Mật khẩu mới:</label>
            <input type="password" name="Mat_Khau" placeholder="Để trống nếu không muốn đổi">
        </div>

        <div class="input-group">
            <label>Trạng thái:</label>
            <select name="Trang_Thai">
                <option value="1" {{ old('Trang_Thai', $data['khach_hang']['Trang_Thai']) == 1 ? 'selected' : '' }}>Kích hoạt</option>
                <option value="0" {{ old('Trang_Thai', $data['khach_hang']['Trang_Thai']) == 0 ? 'selected' : '' }}>Khoá</option>
            </select>
        </div>