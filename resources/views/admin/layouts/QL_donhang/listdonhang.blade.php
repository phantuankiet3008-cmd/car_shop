<div class="right_container">
    <div class="header-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2><i class="fa-solid fa-boxes-packing"></i> Quản Lý Đơn Hàng</h2>
        <a href="{{ url('/trang_admin/don_hang/them') }}" class="btn-add" style="background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
            <i class="fa-solid fa-plus"></i> Tạo đơn mới
        </a>
    </div>

    <div class="search-section" style="background: #1e293b; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #334155;">
        <form action="{{ url('/trang_admin/don_hang') }}" method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="keyword" placeholder="Mã ĐH hoặc Tên khách..." value="{{ request('keyword') }}" 
                       style="width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
            </div>
            
            <select name="payment_status" style="padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                <option value="">-- Thanh toán --</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                <option value="expired"{{ request('payment_status') == 'expired' ? 'selected' : '' }}>hết hạn</option>
            </select>

            <select name="trang_thai" style="padding: 10px; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
                <option value="">-- Trạng thái ĐH --</option>
                <option value="new" {{ request('trang_thai') == 'new' ? 'selected' : '' }}>Mới</option>
                <option value="da_coc" {{ request('trang_thai') == 'da_coc' ? 'selected' : '' }}>Đã cọc</option>
                <option value="da_ky" {{ request('trang_thai') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                <option value="da_giao" {{ request('trang_thai') == 'da_giao' ? 'selected' : '' }}>Đã giao</option>
                <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
            </select>

            <button type="submit" class="btn-search" style="background: #6366f1; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                Lọc dữ liệu
            </button>
            <a href="{{ url('/trang_admin/don_hang') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px;">Xóa lọc</a>
        </form>
    </div>

    <div class="table-responsive" style="background: #1e293b; border-radius: 12px; overflow: hidden; border: 1px solid #334155;">
        <table class="table-admin" style="width: 100%; border-collapse: collapse; color: #e2e8f0;">
            <thead style="background: #334155;">
                <tr>
                    <th style="padding: 15px; text-align: left;">Mã ĐH</th>
                    <th style="padding: 15px; text-align: left;">Khách Hàng</th>
                    <th style="padding: 15px; text-align: left;">Mẫu Xe</th>
                    <th style="padding: 15px; text-align: left;">Tổng Tiền</th>
                    <th style="padding: 15px; text-align: left;">Cọc/Thanh Toán</th>
                    <th style="padding: 15px; text-align: left;">ngày tạo </th>
                    <th style="padding: 15px; text-align: left;">Trạng Thái</th>
                    <th style="padding: 15px; text-align: center;">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['list_don_hang'] as $dh)
                <tr style="border-bottom: 1px solid #334155; transition: 0.3s;" onmouseover="this.style.background='#2d3748'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px;"><span style="color: #94a3b8; font-weight: bold;">#{{ $dh['id_Don_Hang'] }}</span></td>
                    <td style="padding: 15px;">
                        <strong>{{ $dh['Ho_Ten'] }}</strong><br>
                        <small style="color: #64748b;">{{ $dh['So_Dien_Thoai'] }}</small>
                    </td>
                    <td style="padding: 15px;">
                        {{ $dh['Ten_Xe'] }} <br>
                        <small style="color: #94a3b8;">Màu: {{ $dh['Ten_Mau'] }}</small>
                    </td>
                    <td style="padding: 15px;">
                        <b style="color: #ef4444;">{{ number_format($dh['Tong_Tien']) }}đ</b>
                    </td>
                    <td style="padding: 15px;">
                        <small>Cọc: {{ number_format($dh['Tien_Coc']) }}đ</small><br>
                        <span class="badge-status {{ $dh['payment_status'] }}" style="font-size: 10px; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 5px; border: 1px solid;">
                            {{ strtoupper($dh['payment_status']) }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                <span style="font-size: 13px; color: #cbd5e1;">
                    <i class="fa-regular fa-calendar-days" style="margin-right: 5px; color: #64748b;"></i>
                    {{ date('d/m/Y', strtotime($dh['Ngay_Tao'])) }}
                </span><br>
                <small style="color: #64748b;">{{ date('H:i', strtotime($dh['Ngay_Tao'])) }}</small>
            </td>
                    <td style="padding: 15px;">
                        <span class="status-pill status-{{ $dh['Trang_Thai'] }}" style="padding: 5px 12px; border-radius: 20px; font-size: 12px; background: #0f172a; display: inline-block; border-left: 3px solid;">
                            {{ 
                            $dh['Trang_Thai'] == 'new' ? 'Mới' : 
                            ($dh['Trang_Thai'] == 'da_coc' ? 'Đã cọc' : 
                            ($dh['Trang_Thai'] == 'da_ky' ? 'Đã Ký' : 
                            ($dh['Trang_Thai'] == 'da_giao' ? 'Đã giao' : 'Từ chối'))) 
                            }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 10px; justify-content: center;">
                            <a href="{{ url('/trang_admin/don_hang/sua/'.$dh['id_Don_Hang']) }}" 
                               style="color: #3b82f6; background: rgba(59, 130, 246, 0.1); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none;" 
                               title="Chỉnh sửa">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <form action="{{ url('/trang_admin/don_hang/xoa/'.$dh['id_Don_Hang']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border: none; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 6px; cursor: pointer;" 
                                        title="Xóa đơn hàng">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Trạng thái thanh toán */
    .badge-status.paid { color: #10b981; border-color: #10b981; background: rgba(16, 185, 129, 0.1); }
    .badge-status.pending { color: #f59e0b; border-color: #f59e0b; background: rgba(245, 158, 11, 0.1); }
    .badge-status.failed { color: #ef4444; border-color: #ef4444; background: rgba(239, 68, 68, 0.1); }

    /* Trạng thái đơn hàng (Sửa class khớp với DB) */
    .status-new { color: #3b82f6 !important; border-left-color: #3b82f6 !important; }
    .status-da_coc { color: #8b5cf6 !important; border-left-color: #8b5cf6 !important; }
    .status-da_giao { color: #10b981 !important; border-left-color: #10b981 !important; }
    .status-tu_choi { color: #ef4444 !important; border-left-color: #ef4444 !important; }
</style>