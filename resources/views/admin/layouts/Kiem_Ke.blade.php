<div class="admin-kiem-ke">
    <h2>Kiểm Kê</h2>
    <link rel="stylesheet" href="{{ asset('admin/css/admin_kiem_ke.css') }}">
    
    <div class="kiem_ke-sidebar">
        <a href="{{ url('/trang_admin/kiem_ke/doanh-thu') }}" class="{{ ($tab ?? 'tieu-dung') === 'doanh-thu' ? 'active' : '' }}">Doanh Thu</a>
        <a href="{{ url('/trang_admin/kiem_ke/tieu-dung') }}" class="{{ ($tab ?? 'tieu-dung') === 'tieu-dung' ? 'active' : '' }}">Tiêu Dùng</a>
    </div>

    @if(($tab ?? 'tieu-dung') === 'doanh-thu')
        <div class="thong-ke-doanh-thu">
            <p>Nội dung doanh thu sẽ được thêm ở đây sau.</p>
        </div>
    @else
        <div class="thong-ke-tieu-dung">
            <form method="get" action="{{ url('/trang_admin/kiem_ke/tieu-dung') }}" class="mb-20">
                <label>Ngày bắt đầu: <input type="date" name="from" value="{{ $from ?? '' }}"></label>
                <label>Ngày kết thúc: <input type="date" name="to" value="{{ $to ?? '' }}"></label>
                <label>Nhóm theo:
                    <select name="group">
                        <option value="ngay" {{ ($group ?? 'ngay') == 'ngay' ? 'selected' : '' }}>Ngày</option>
                        <option value="thang" {{ ($group ?? '') == 'thang' ? 'selected' : '' }}>Tháng</option>
                        <option value="nam" {{ ($group ?? '') == 'nam' ? 'selected' : '' }}>Năm</option>
                    </select>
                </label>
                <button type="submit">Cập nhật</button>
            </form>

            <h3>Số lượt đặt lịch lái thử</h3>
            <canvas id="chartLichTheoThoiGian" width="800" height="300"></canvas>
    
            <div style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <h3 style="text-align: center; margin-bottom: 15px;">Thống kê mật độ đặt lịch theo Khung giờ</h3>
                <canvas id="chartKhungGioCot" width="800" height="300"></canvas>
            </div>

            <div class="row" style="display:flex; align-items:center; gap:10px; margin: 20px 0;">
                <label style="margin-bottom:0;">Chọn ngày để xem khung giờ:</label>
                <input type="date" id="dateFilter" value="{{ $from ?? '' }}" style="padding:6px 10px; border:1px solid #cbd5e1; border-radius:6px;" />
                <button id="btnFetchByDate" type="button" style="padding:7px 14px; background:#2f80ed; color:#fff; border:none; border-radius:6px;">Xem theo ngày</button>
            </div>
                   
            <div id="chiTietKhungGio" style="display:none; margin-top:16px;">
                <h4 id="tieuDeKhungGio">Chi tiết khung giờ</h4>
                <table id="bangChiTietKhungGio" border="1" cellpadding="8" cellspacing="0" width="100%">
                    <thead><tr><th>Khung giờ</th><th>Loại xe</th><th>Tên xe</th><th>Thương hiệu</th><th>Màu xe</th><th>Số lần đặt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            <h3>Đặt Lịch Bảo Dưỡng</h3>
            <canvas id="chartLichBaoDuongTheoThoiGian" width="800" height="300"></canvas>

            <div class="row" style="display:flex; align-items:center; gap:10px; margin: 20px 0;">
                <label style="margin-bottom:0;">Chọn ngày bảo dưỡng:</label>
                <input type="date" id="baoDuongDateFilter" value="{{ $from ?? '' }}" style="padding:6px 10px; border:1px solid #cbd5e1; border-radius:6px;" />
                <button id="btnBaoDuongFetchByDate" type="button" style="padding:7px 14px; background:#16a34a; color:#fff; border:none; border-radius:6px;">Tra cứu ngày</button>
            </div>

            <div id="chiTietBaoDuong" style="display:none; margin-top:16px;">
                <h4 id="tieuDeBaoDuong">Chi tiết lịch bảo dưỡng</h4>
                <table id="bangChiTietBaoDuong" border="1" cellpadding="8" cellspacing="0" width="100%">
                    <thead><tr><th>Xe</th><th>Màu xe</th><th>Ngày bảo dưỡng</th><th>Ngày cập nhật</th><th>Gói bảo dưỡng</th><th>Số lượt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="row-charts" style="display: flex; gap: 20px; margin: 30px 0; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 320px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
                    <h4 style="margin-bottom: 15px; color: #1e293b; font-weight: 600;">Xu hướng theo Dòng xe</h4>
                    <div style="max-width: 260px; margin: auto;">
                        <canvas id="chartLoaiXeXuHuong"></canvas>
                    </div>
                </div>

                <div style="flex: 1; min-width: 320px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
                    <h4 style="margin-bottom: 15px; color: #1e293b; font-weight: 600;">Xu hướng theo Thương Hiệu</h4>
                    <div style="max-width: 260px; margin: auto;">
                        <canvas id="chartThuongHieuXuHuong"></canvas>
                    </div>
                </div>
            </div>

            <h3>Thống kê lịch bảo dưỡng</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Khoảng</th><th>Số lần đặt</th></tr></thead>
                <tbody>
                    @foreach($bieuDoBaoDuong ?? [] as $row)
                        <tr><td>{{ $row['nhom'] }}</td><td>{{ $row['so_lan_dat'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top xe được đặt lái thử nhiều nhất</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Xe</th><th>Số lượt đặt</th></tr></thead>
                <tbody>
                    @foreach($topXe ?? [] as $row)
                        <tr><td>{{ $row['Ten_Xe'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>
 <!-- ================= THƯƠNG HIỆU ================= -->
            <div style="background:#e0f2fe; padding:20px; border-radius:12px; margin-top:30px;">
                <h3 style="text-align:center; color:#0369a1;">Top thương hiệu xu hướng hành vi khách hàng</h3>
                <div style="display:flex; gap:20px;">
                    <div style="flex:1;">
                        <h4>Thương hiệu ưa thích</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Thương hiệu</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topThuongHieu ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Thuong_Hieu'] }}</td>
                                        <td>{{ $row['so_lan_lai_thu'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="flex:1;">
                        <h4>Thương hiệu được mua</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Thương hiệu</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topThuongHieuMua ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Thuong_Hieu'] }}</td>
                                        <td>{{ $row['so_lan_mua'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= LOẠI XE ================= -->
            <div style="background: Pink ; padding:20px; border-radius:12px; margin-top:30px;">
                <h3 style="text-align:center; color:#166534;">Top loại xe xu hướng  theo hành vi khách hàng</h3>
                <div style="display:flex; gap:20px;">
                    <div style="flex:1;">
                        <h4>Loại xe ưa thích</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Loại xe</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topLoaiXeUaChuong ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Loai_Xe'] }}</td>
                                        <td>{{ $row['so_lan_lai_thu'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="flex:1;">
                        <h4>Loại xe được mua</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Loại xe</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topLoaiXeMua ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Loai_Xe'] }}</td>
                                        <td>{{ $row['so_lan_mua'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= MÀU XE ================= -->
            <div style="background:#ffedd5; padding:20px; border-radius:12px; margin-top:30px;">
                <h3 style="text-align:center; color:#c2410c;">Top màu xe theo hành vi khách hàng</h3>
                <div style="display:flex; gap:20px;">
                    <div style="flex:1;">
                        <h4>Màu xe ưa thích</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Màu xe</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topMauXeUaChuong ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Mau'] }}</td>
                                        <td>{{ $row['so_lan_dat'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="flex:1;">
                        <h4>Màu xe được mua</h4>
                        <table border="1" width="100%">
                            <thead><tr><th>Màu xe</th><th>Lượt</th></tr></thead>
                            <tbody>
                                @foreach($topMauXeMua ?? [] as $row)
                                    <tr>
                                        <td>{{ $row['Ten_Mau'] }}</td>
                                        <td>{{ $row['so_lan_mua'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
            

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Cấu hình màu sắc & font chữ đen đậm
    const textColor = '#000000';
    const boldFont = { weight: 'bold', size: 13 };
    const palette = ['#C6DBDA', '#FFB5C5', '#FFA54F', '#FEF889', '#AFD788', '#C9B5D4', '#64B5F6', '#FF8A65'];

    const commonTooltip = {
        enabled: true,
        backgroundColor: 'rgba(0, 0, 0, 0.85)',
        titleFont: { weight: 'bold', size: 14 },
        bodyFont: { weight: 'bold', size: 13 },
        padding: 10,
        displayColors: true
    };

    // 1. Biểu đồ đường Lái thử
   // 1. Biểu đồ đường Lái thử
const lineData = @json($bieuDo ?? []);
const lineCtx = document.getElementById('chartLichTheoThoiGian')?.getContext('2d');
if (lineCtx && lineData.length > 0) {
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineData.map(i => i.nhom),
            datasets: [{
                label: 'Số lượt đặt lịch',
                data: lineData.map(i => parseInt(i.so_lan_dat)),
                borderColor: 'rgb(55, 131, 229)',
                backgroundColor: 'hsla(214, 69%, 54%, 0.15)',
                fill: true,
                tension: 0.3,
                borderWidth: 3,
                pointRadius: 4
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: textColor, font: { weight: 'bold' } } },
                tooltip: commonTooltip 
            },
            scales: {
                x: { 
                    ticks: { color: textColor, font: boldFont },
                    // THÊM CHÚ THÍCH TRỤC X
                    title: {
                        display: true,
                        text: 'Thời gian',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                },
                y: { 
                    beginAtZero: true, 
                    ticks: { color: textColor, font: boldFont, stepSize: 1 },
                    // THÊM CHÚ THÍCH TRỤC Y
                    title: {
                        display: true,
                        text: 'Số lượt đặt',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                }
            }
        }
    });
}
    // 2. Biểu đồ cột Khung giờ
   // 2. Biểu đồ cột Khung giờ
const kgData = @json($thongKeKhungGio ?? []);
const kgCtx = document.getElementById('chartKhungGioCot')?.getContext('2d');
if (kgCtx && kgData.length > 0) {
    new Chart(kgCtx, {
        type: 'bar',
        data: {
            labels: kgData.map(i => i.khung_gio),
            datasets: [{
                label: 'Số lượt đặt',
                data: kgData.map(i => i.so_lan_dat),
                backgroundColor: 'hsla(323, 93%, 78%, 0.80)',
                borderColor: 'hsl(320, 81%, 64%)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: textColor, font: { weight: 'bold' } } },
                tooltip: commonTooltip
            },
            scales: { //  scales tỉ lệ hình tránh  ẩn 
                x: { 
                    ticks: { color: textColor, font: boldFont },
                    title: { // Title phải nằm TRONG x
                        display: true,
                        text: 'Khung giờ',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                },
                y: { 
                    beginAtZero: true, 
                    ticks: { color: textColor, font: boldFont, stepSize: 1 },
                    title: { // Title phải nằm TRONG y
                        display: true,
                        text: 'Số lượt đặt',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                }
            }
        }
    });
}

   // 3. Biểu đồ Bảo dưỡng
const bdData = @json($bieuDoBaoDuong ?? []);
const bdCtx = document.getElementById('chartLichBaoDuongTheoThoiGian')?.getContext('2d');
if (bdCtx && bdData.length > 0) {
    new Chart(bdCtx, {
        type: 'line',
        data: {
            labels: bdData.map(i => i.nhom),
            datasets: [{
                label: 'Số lượt bảo dưỡng',
                data: bdData.map(i => parseInt(i.so_lan_dat)),
                borderColor: 'rgb(61, 230, 123)',
                backgroundColor: 'hsla(142, 75%, 31%, 0.15)',
                fill: true,
                borderWidth: 3
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: textColor, font: { weight: 'bold' } } },
                tooltip: commonTooltip
            },
            scales: {
                x: { 
                    ticks: { color: textColor, font: boldFont },
                    title: { // Nằm trong x
                        display: true,
                        text: 'Thời gian',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                },
                y: { 
                    beginAtZero: true, 
                    ticks: { color: textColor, font: boldFont, stepSize: 1 },
                    title: { // Nằm trong y
                        display: true,
                        text: 'Số lượt bảo dưỡng',
                        color: textColor,
                        font: { size: 14, weight: 'bold' }
                    }
                }
            }
        }
    });
}

    // 4. Biểu đồ tròn Loại xe (Chú thích chi tiết)
    const lxData = @json($topLoaiXeXuHuong ?? []);
    const lxCtx = document.getElementById('chartLoaiXeXuHuong')?.getContext('2d');
    if (lxCtx && lxData.length > 0) {
        new Chart(lxCtx, {
            type: 'pie',
            data: {
                labels: lxData.map(i => i.Ten_Loai_Xe),
                datasets: [{ data: lxData.map(i => i.tong_tuong_tac), backgroundColor: palette, borderWidth: 2 }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom', labels: { color: textColor, font: boldFont } },
                    tooltip: {
                        ...commonTooltip,
                        callbacks: {
                            label: function(context) {
                                const item = lxData[context.dataIndex];
                                return [
                                    ` Tổng cộng: ${item.tong_tuong_tac} lượt`,
                                    ` • Lái thử: ${item.so_luong_lai_thu}`,
                                    ` • Mua xe: ${item.so_luong_don_hang}`
                                ];
                            }
                        }
                    }
                }
            }
        });
    }

    // 5. Biểu đồ tròn Thương hiệu (Chú thích chi tiết)
    const thData = @json($topThuongHieuXuHuong ?? []);
    const thCtx = document.getElementById('chartThuongHieuXuHuong')?.getContext('2d');
    if (thCtx && thData.length > 0) {
        new Chart(thCtx, {
            type: 'pie',
            data: {
                labels: thData.map(i => i.Ten_Thuong_Hieu),
                datasets: [{ data: thData.map(i => i.tong_tuong_tac), backgroundColor: palette, borderWidth: 2 }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom', labels: { color: textColor, font: boldFont } },
                    tooltip: {
                        ...commonTooltip,
                        callbacks: {
                            label: function(context) {
                                const item = thData[context.dataIndex];
                                return [
                                    ` Tổng cộng: ${item.tong_tuong_tac} lượt`,
                                    ` • Lái thử: ${item.so_luong_lai_thu}`,
                                    ` • Mua xe: ${item.so_luong_don_hang}`
                                ];
                            }
                        }
                    }
                }
            }
        });
    }

    // HÀM FETCH CHI TIẾT THEO NGÀY
    window.fetchKhungGioTheoNgay = function(ngay) {
        fetch(`/trang_admin/kiem_ke/khunggio-theongay?ngay=${encodeURIComponent(ngay)}`)
            .then(r => r.json())
            .then(json => {
                const body = document.querySelector('#bangChiTietKhungGio tbody');
                document.getElementById('tieuDeKhungGio').textContent = 'Chi tiết khung giờ ngày ' + ngay;
                body.innerHTML = (json.khungGio || []).map(item => `
                    <tr><td>${item.khung_gio}</td><td>${item.loai_xe || '-'}</td><td>${item.ten_xe || '-'}</td><td>${item.ten_thuong_hieu || '-'}</td><td>${item.ten_mau || '-'}</td><td>${item.so_lan_dat}</td></tr>
                `).join('') || '<tr><td colspan="6">Không có dữ liệu</td></tr>';
                document.getElementById('chiTietKhungGio').style.display = 'block';
            });
    };

    window.fetchBaoDuongTheoNgay = function(ngay) {
        fetch(`/trang_admin/kiem_ke/bao-duong-theongay?ngay=${encodeURIComponent(ngay)}`)
            .then(r => r.json())
            .then(json => {
                const body = document.querySelector('#bangChiTietBaoDuong tbody');
                document.getElementById('tieuDeBaoDuong').textContent = 'Chi tiết bảo dưỡng ngày ' + ngay;
                body.innerHTML = (json.baoDuong || []).map(item => `
                    <tr><td>${item.ten_xe || '-'}</td><td>${item.ten_mau || '-'}</td><td>${item.ngay_bao_duong}</td><td>${item.ngay_cap_nhat}</td><td>${item.goi_bao_duong}</td><td>${item.so_lan_dat}</td></tr>
                `).join('') || '<tr><td colspan="6">Không có dữ liệu</td></tr>';
                document.getElementById('chiTietBaoDuong').style.display = 'block';
            });
    };

    document.getElementById('btnFetchByDate')?.addEventListener('click', () => {
        const val = document.getElementById('dateFilter').value;
        val ? fetchKhungGioTheoNgay(val) : alert('Vui lòng chọn ngày!');
    });

    document.getElementById('btnBaoDuongFetchByDate')?.addEventListener('click', () => {
        const val = document.getElementById('baoDuongDateFilter').value;
        val ? fetchBaoDuongTheoNgay(val) : alert('Vui lòng chọn ngày!');
    });
});
</script>