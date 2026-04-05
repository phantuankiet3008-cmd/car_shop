<div class="right_container" style="padding: 20px; color: #e2e8f0;">
    <div class="header-page" style="margin-bottom: 20px;">
        <h2><i class="fa-solid fa-pen-to-square"></i> Chỉnh Sửa Đơn Hàng #{{ $data['don_hang']['id_Don_Hang'] }}</h2>
    </div>

    <div class="form-container" style="background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155;">
        <form action="{{ url('/trang_admin/don_hang/cap-nhat/'.$data['don_hang']['id_Don_Hang']) }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Khách hàng</label>
                    <select name="id_khach_hang" required style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                        @foreach($data['ds_khach_hang'] as $kh)
                            <option value="{{ $kh['id_Khach_Hang'] }}" {{ $kh['id_Khach_Hang'] == $data['don_hang']['id_Khach_Hang'] ? 'selected' : '' }}>
                                {{ $kh['Ho_Ten'] }} - {{ $kh['So_Dien_Thoai'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Sản phẩm xe (Phiên bản màu)</label>
                    <select name="id_xe_mau" id="id_xe_mau" required style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                        @foreach($data['ds_xe_mau'] as $xm)
                            <option value="{{ $xm['id_Xe_Mau'] }}" data-gia="{{ $xm['Gia'] }}" {{ $xm['id_Xe_Mau'] == $data['don_hang']['id_Xe_Mau'] ? 'selected' : '' }}>
                                {{ $xm['Ten_Xe'] }} - {{ $xm['Ten_Mau'] }} ({{ number_format($xm['Gia']) }}đ)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Giá niêm yết</label>
                    <input type="number" name="gia_goc" id="gia_goc" value="{{ $data['don_hang']['Gia_Goc'] }}" readonly
                           style="width: 100%; padding: 10px; background: #334155; border: 1px solid #475569; color: #94a3b8; border-radius: 6px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Giảm giá (VNĐ)</label>
                    <input type="number" name="gia_giam" id="gia_giam" value="{{ $data['don_hang']['Gia_Giam'] }}"
                           style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Tiền đặt cọc</label>
                    <input type="number" name="tien_coc" value="{{ $data['don_hang']['Tien_Coc'] }}"
                           style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px;">Thanh toán</label>
                    <select name="payment_status" style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                        <option value="pending" {{ $data['don_hang']['payment_status'] == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="paid" {{ $data['don_hang']['payment_status'] == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="failed" {{ $data['don_hang']['payment_status'] == 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px;">Trạng thái đơn hàng</label>
                    <select name="trang_thai" style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                        <option value="new" {{ $data['don_hang']['Trang_Thai'] == 'new' ? 'selected' : '' }}>Mới (Đang tư vấn)</option>
                        <option value="da_coc" {{ $data['don_hang']['Trang_Thai'] == 'da_coc' ? 'selected' : '' }}>Đã cọc</option>
                        <option value="da_ky" {{ $data['don_hang']['Trang_Thai'] == 'da_ky' ? 'selected' : '' }}>Đã ký hợp đồng</option>
                        <option value="da_giao" {{ $data['don_hang']['Trang_Thai'] == 'da_giao' ? 'selected' : '' }}>Đã bàn giao xe</option>
                        <option value="tu_choi" {{ $data['don_hang']['Trang_Thai'] == 'tu_choi' ? 'selected' : '' }}>Hủy đơn</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" style="background: #10b981; color: white; border: none; padding: 12px 30px; border-radius: 8px; cursor: pointer; font-weight: bold;">
                    Lưu Thay Đổi
                </button>
                <a href="{{ url('/trang_admin/don_hang') }}" style="background: #475569; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none;"> Quay lại </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Tự động cập nhật giá niêm yết khi thay đổi xe
    document.getElementById('id_xe_mau').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var gia = selectedOption.getAttribute('data-gia');
        document.getElementById('gia_goc').value = gia;
    });
</script>