<div class="admin-kiem-ke">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_kiem_ke.css') }}">
    
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #1e293b; font-weight: 800; font-size: 1.8rem;">📊 Dashboard Kiểm Kê</h2>
        <div class="kiem_ke-sidebar" style="display: flex; gap: 10px;">
            <a href="{{ url('/trang_admin/kiem_ke/doanh-thu') }}" class="btn-update {{ ($tab ?? '') === 'doanh-thu' ? '' : 'outline' }}" style="text-decoration:none; padding: 10px 20px;">Doanh Thu</a>
            <a href="{{ url('/trang_admin/kiem_ke/tieu-dung') }}" class="btn-update {{ ($tab ?? 'tieu-dung') === 'tieu-dung' ? '' : 'outline' }}" style="text-decoration:none; padding: 10px 20px; background: #2563eb;">Tiêu Dùng</a>
        </div>
    </div>

    @if(($tab ?? 'tieu-dung') === 'tieu-dung')
        <div class="dashboard-card">
            <form method="get" action="{{ url('/trang_admin/kiem_ke/tieu-dung') }}" class="filter-box" style="margin-bottom: 0; border: none; box-shadow: none;">
                <label>Từ: <input type="date" name="from" value="{{ $from ?? '' }}"></label>
                <label>Đến: <input type="date" name="to" value="{{ $to ?? '' }}"></label>
                <label>Nhóm:
                    <select name="group">
                        <option value="ngay" {{ ($group ?? 'ngay') == 'ngay' ? 'selected' : '' }}>Theo Ngày</option>
                        <option value="thang" {{ ($group ?? '') == 'thang' ? 'selected' : '' }}>Theo Tháng</option>
                    </select>
                </label>
                <button type="submit" class="btn-update">Cập nhật báo cáo</button>
            </form>
        </div>

        <div class="dashboard-card">
            <h3 class="section-title">🕒 Phân tích Lưu lượng Khách & Giờ Cao Điểm</h3>
            <div class="grid-container">
                <div class="chart-item">
                    <p style="text-align: center; color: #64748b; font-weight: 600; margin-bottom: 15px;">Biến động đặt lịch lái thử</p>
                    <canvas id="chartLichTheoThoiGian" height="250"></canvas>
                </div>
                <div class="chart-item" style="border-left: 1px dashed #e2e8f0; padding-left: 20px;">
                    <p style="text-align: center; color: #ef4444; font-weight: 600; margin-bottom: 15px;">🔥 Thống kê Giờ vàng (Tất cả các ngày)</p>
                    <canvas id="chartKhungGioBar" height="250"></canvas>
                </div>
            </div>
            
            <div style="margin-top: 30px; padding: 20px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; gap: 20px;">
                <label style="font-weight: 600;">Tra cứu chi tiết theo ngày:</label>
                <input type="date" id="dateFilter" value="{{ $from ?? '' }}">
                <button id="btnFetchByDate" style="background: #2563eb; color: white;">Xem chi tiết khung giờ</button>
            </div>

            <div id="chiTietKhungGio" style="display:none; margin-top:20px;">
                <table id="bangChiTietKhungGio" class="modern-table">
                    <thead>
                        <tr><th>Giờ</th><th>Phân khúc</th><th>Tên Xe</th><th>Thương hiệu</th><th>Số lượt</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-card" style="background: #fdfdfd; border: 1px solid #dbeafe;">
            <h3 class="section-title">🔥 Phân tích Xu hướng: Ưa thích vs Thực tế Mua</h3>
            <div class="grid-container">
                <div class="table-container">
                    <h4 style="color: #2563eb; margin-bottom: 15px;">Top Dòng Xe (Tương tác)</h4>
                    <table class="modern-table">
                        <thead><tr><th>Dòng xe</th><th>Lượt Thích</th><th>Lượt Mua</th></tr></thead>
                        <tbody>
                            @foreach($topLoaiXeXuHuong ?? [] as $row)
                            <tr>
                                <td><strong>{{ $row['Ten_Loai_Xe'] }}</strong></td>
                                <td class="text-blue">{{ $row['so_luong_lai_thu'] }}</td>
                                <td class="text-green">{{ $row['so_luong_don_hang'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-container">
                    <h4 style="color: #10b981; margin-bottom: 15px;">Tỷ lệ phân bổ Thương hiệu</h4>
                    <canvas id="chartThuongHieuXuHuongPie"></canvas>
                </div>
            </div>
        </div>

        <div class="dashboard-card">
            <h3 class="section-title">🛠️ Thống kê Bảo Dưỡng Định Kỳ</h3>
            <canvas id="chartLichBaoDuongTheoThoiGian" height="120"></canvas>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Biểu đồ Đường - Xu hướng lái thử
    const dataLine = @json($bieuDo ?? []);
    new Chart(document.getElementById('chartLichTheoThoiGian'), {
        type: 'line',
        data: {
            labels: dataLine.map(i => i.nhom),
            datasets: [{
                label: 'Lượt đặt',
                data: dataLine.map(i => i.so_lan_dat),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true, tension: 0.3
            }]
        }
    });

    // 2. BIỂU ĐỒ CỘT - KHUNG GIỜ CAO ĐIỂM (THEO Ý SẾP)
    // Giả sử $bieuDoGio được Controller đếm số lượng bản ghi group theo khung_gio
    const dataGio = @json($bieuDoGio ?? []); 
    new Chart(document.getElementById('chartKhungGioBar'), {
        type: 'bar',
        data: {
            labels: dataGio.map(i => i.khung_gio),
            datasets: [{
                label: 'Số khách đặt',
                data: dataGio.map(i => i.so_lan_dat),
                backgroundColor: '#ef4444',
                borderRadius: 5
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // 3. Biểu đồ tròn - Thương hiệu
   // 3. Biểu đồ tròn - Thương hiệu (Cập nhật)
const dataTH = @json($topThuongHieuXuHuong ?? []);

// Kiểm tra xem có dữ liệu không để tránh lỗi vẽ biểu đồ trống
if (dataTH.length > 0) {
    new Chart(document.getElementById('chartThuongHieuXuHuongPie'), {
        type: 'doughnut',
        data: {
            // Lưu ý: Tên cột 'Ten_Thuong_Hieu' và 'tong_lan_lai_thu' 
            // phải khớp với kết quả trả về từ SQL trong Service QL
            labels: dataTH.map(i => i.Ten_Thuong_Hieu || 'Không xác định'),
            datasets: [{
                label: 'Lượt tương tác',
                data: dataTH.map(i => i.tong_lan_lai_thu || 0),
                backgroundColor: [
                    '#2563eb', // Blue
                    '#10b981', // Green
                    '#f59e0b', // Amber
                    '#ef4444', // Red
                    '#8b5cf6', // Violet
                    '#06b6d4'  // Cyan
                ],
                hoverOffset: 15, // Hiệu ứng nổi lên khi di chuột vào
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Giúp biểu đồ vừa khít với container
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true // Chấm tròn thay vì ô vuông ở chú thích
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return ` ${label}: ${value} lượt`;
                        }
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
} else {
    // Nếu không có dữ liệu, hiển thị thông báo thay vì để trắng
    document.getElementById('chartThuongHieuXuHuongPie').parentElement.innerHTML = 
        '<p style="text-align:center; padding-top:50px; color:#64748b;">Chưa có dữ liệu thương hiệu</p>';
}
    // 4. BIỂU ĐỒ BẢO DƯỠNG
    const dataBD = @json($bieuDoBaoDuong ?? []);
    new Chart(document.getElementById('chartLichBaoDuongTheoThoiGian'), {
        type: 'line',
        data: {
            labels: dataBD.map(i => i.nhom),
            datasets: [{
                label: 'Lượt bảo dưỡng',
                data: dataBD.map(i => i.so_lan_dat),
                borderColor: '#10b981',
                fill: false
            }]
        }
    });

    // logic Fetch API cho nút Xem chi tiết ngày
    document.getElementById('btnFetchByDate')?.addEventListener('click', function() {
        const d = document.getElementById('dateFilter').value;
        if(!d) return alert('Hãy chọn một ngày cụ thể!');
        
        fetch(`/trang_admin/kiem_ke/khunggio-theongay?ngay=${encodeURIComponent(d)}`)
            .then(r => r.json())
            .then(res => {
                const body = document.querySelector('#bangChiTietKhungGio tbody');
                body.innerHTML = '';
                if(res.khungGio.length === 0) {
                    body.innerHTML = '<tr><td colspan="5" style="text-align:center;">Ngày này chưa có lượt đặt nào</td></tr>';
                } else {

        res.khungGio.forEach(item => {
    body.innerHTML += `<tr>
        <td><span class="badge-hot">${item.khung_gio}</span></td>
        <td>${item.loai_xe}</td>
        <td><strong>${item.ten_xe}</strong></td>
        <td>${item.ten_thuong_hieu}</td>
        <td class="text-blue">${item.so_lan_dat}</td> 
    </tr>`; 
});
                }
                document.getElementById('chiTietKhungGio').style.display = 'block';
            });
    });
</script>