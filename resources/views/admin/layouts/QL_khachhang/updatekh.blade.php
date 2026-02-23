<div class="form-container">
    <h2>Sửa khách hàng</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <p class="msg success">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="msg error">{{ session('error') }}</p>
    @endif

    {{-- Lỗi validate --}}
    @if($errors->any())
        <div class="msg error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ url('/trang_admin/khach_hang/sua/'.$data['khach_hang']['id_Khach_Hang']) }}">

        @csrf

        <input type="hidden"
               name="id_Khach_Hang"
               value="{{ $data['khach_hang']['id_Khach_Hang'] }}">

        <label>Họ tên:</label>
        <input type="text"
               name="Ho_Ten"
               value="{{ old('Ho_Ten', $data['khach_hang']['Ho_Ten']) }}"
               required>

        <label>Email:</label>
        <input type="email"
               name="Email"
               value="{{ old('Email', $data['khach_hang']['Email']) }}"
               required>

        <label>Số điện thoại:</label>
        <input type="text"
               name="So_Dien_Thoai"
               value="{{ old('So_Dien_Thoai', $data['khach_hang']['So_Dien_Thoai']) }}">

        <label>Địa chỉ:</label>
        <input type="text"
               name="Dia_Chi"
               value="{{ old('Dia_Chi', $data['khach_hang']['Dia_Chi']) }}">

        {{-- Không hiển thị mật khẩu cũ --}}
        <label>Mật khẩu mới (để trống nếu không đổi):</label>
        <input type="password" name="Mat_Khau">

        <label>Trạng thái:</label>
        <select name="Trang_Thai">
            <option value="1"
                {{ old('Trang_Thai', $data['khach_hang']['Trang_Thai']) == 1 ? 'selected' : '' }}>
                Kích hoạt
            </option>
            <option value="0"
                {{ old('Trang_Thai', $data['khach_hang']['Trang_Thai']) == 0 ? 'selected' : '' }}>
                Khoá
            </option>
        </select>

        <label>Ngày tạo:</label>
        <input type="text"
               value="{{ $data['khach_hang']['Ngay_Tao'] }}"
               readonly>

        <label>Ngày cập nhật:</label>
        <input type="text"
               value="{{ $data['khach_hang']['Ngay_Cap_Nhat'] }}"
               readonly>

        <div class="form-actions">
            <button type="submit">Lưu thay đổi</button>

            <a href="{{ url('/trang_admin/khach_hang') }}"
               class="btn-back">
                Quay lại
            </a>
        </div>
    </form>
</div>
