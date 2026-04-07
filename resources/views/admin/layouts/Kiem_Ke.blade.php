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

            {{-- ===== FORM LỌC THỜI GIAN ===== --}}
            <form method="get" action="{{ url('/trang_admin/kiem_ke/tieu-dung') }}">
                <label>Ngày bắt đầu: <input type="date" name="from" value="{{ $from ?? '' }}"></label>
                <label>Ngày kết thúc: <input type="date" name="to" value="{{ $to ?? '' }}"></label>
                <label>Nhóm theo:
                    <select name="group">
                        <option value="ngay"  {{ ($group ?? 'ngay') == 'ngay'  ? 'selected' : '' }}>Ngày</option>
                        <option value="thang" {{ ($group ?? '') == 'thang' ? 'selected' : '' }}>Tháng</option>
                        <option value="nam"   {{ ($group ?? '') == 'nam'   ? 'selected' : '' }}>Năm</option>
                    </select>
                </label>
                <button type="submit">Cập nhật</button>
            </form>

            {{-- ===== BIỂU ĐỒ ĐƯỜNG – LÁI THỬ ===== --}}
            <div class="chart-section">
                <div class="chart-header">
                    <div class="title-indicator"></div>
                    <h3> Đặt lịch lái thử theo thời gian </h3>
                </div>
                <div class="chart-wrapper h-main">
                    <canvas id="chartLichTheoThoiGian"></canvas>
                </div>
            </div>

            {{-- ===== BIỂU ĐỒ CỘT – KHUNG GIỜ ===== --}}
            <div class="chart-section chart-pink">
                <div class="chart-header">
                    <div class="title-indicator"></div>
                    <h3>Thống kê mật độ đặt lịch theo Khung giờ</h3>
                </div>
                <div class="chart-wrapper h-bar">
                    <canvas id="chartKhungGioCot"></canvas>
                </div>
            </div>

            {{-- ===== XEM CHI TIẾT KHUNG GIỜ ===== --}}
            <div class="date-filter-row">
                <label>📅 Chọn ngày xem chi tiết:</label>
                <input type="date" id="dateFilter" value="{{ $from ?? '' }}" />
                <button id="btnFetchByDate" type="button">
                    <span>🔍</span> Xem theo ngày
                </button>
            </div>
            <div id="chiTietKhungGio" style="display:none;">
                <h4 id="tieuDeKhungGio">Chi tiết khung giờ</h4>
                <table id="bangChiTietKhungGio">
                    <thead><tr><th>Khung giờ</th><th>Loại xe</th><th>Tên xe</th><th>Thương hiệu</th><th>Màu xe</th><th>Số lần đặt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            {{-- ===== BIỂU ĐỒ ĐƯỜNG – BẢO DƯỠNG ===== --}}
            <div class="chart-section chart-green" style="margin-top: 30px;">
                <div class="chart-header">
                    <div class="title-indicator"></div>
                    <h3>Đặt lịch bảo dưỡng theo thời gian  </h3>
                </div>
                <div class="chart-wrapper h-small">
                    <canvas id="chartLichBaoDuongTheoThoiGian"></canvas>
                </div>
            </div>

            {{-- ===== XEM CHI TIẾT BẢO DƯỠNG ===== --}}
            <div class="date-filter-row">
                <label>🛠️ Tra cứu lịch bảo dưỡng:</label>
                <input type="date" id="baoDuongDateFilter" value="{{ $from ?? '' }}" />
                <button id="btnBaoDuongFetchByDate" type="button" class="btn-green-gradient">
                    <span>⚡</span> Tra cứu ngày
                </button>
            </div>
            <div id="chiTietBaoDuong" style="display:none;">
                <h4 id="tieuDeBaoDuong">Chi tiết lịch bảo dưỡng</h4>
                <table id="bangChiTietBaoDuong">
                    <thead><tr><th>Xe</th><th>Màu xe</th><th>Ngày bảo dưỡng</th><th>Ngày cập nhật</th><th>Gói bảo dưỡng</th><th>Số lượt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            {{-- ===== BIỂU ĐỒ TRÒN – XU HƯỚNG ===== --}}
            <div class="pie-chart-grid">
                <div class="pie-chart-card pie-card-loai">
                    <div class="pie-title">🚗 Xu hướng theo Dòng xe</div>
                    <div class="donut-wrap">
                        <canvas id="chartLoaiXeXuHuong"></canvas>
                    </div>
                </div>
                <div class="pie-chart-card pie-card-thuonghieu">
                    <div class="pie-title">🏷️ Xu hướng theo Thương Hiệu</div>
                    <div class="donut-wrap">
                        <canvas id="chartThuongHieuXuHuong"></canvas>
                    </div>
                </div>
            </div>

            {{-- ===== BẢNG THỐNG KÊ BẢO DƯỠNG ===== --}}
            <div class="section-block section-baoduong-table">
                <div class="section-header">🔩 Thống kê lịch bảo dưỡng</div>
                <table>
                    <thead><tr><th>Khoảng</th><th>Số lần đặt</th></tr></thead>
                    <tbody>
                        @foreach($bieuDoBaoDuong ?? [] as $row)
                            <tr><td>{{ $row['nhom'] }}</td><td>{{ $row['so_lan_dat'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ===== TOP XE ===== --}}
            <div class="section-block section-top-xe">
                <div class="section-header">🏆 Top xe được đặt lái thử nhiều nhất</div>
                <table>
                    <thead><tr><th>Xe</th><th>Số lượt đặt</th></tr></thead>
                    <tbody>
                        @foreach($topXe ?? [] as $row)
                            <tr><td>{{ $row['Ten_Xe'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ===== THƯƠNG HIỆU ===== --}}
            <div class="section-block section-thuonghieu">
                <div class="section-header">🏷️ Top thương hiệu xu hướng hành vi khách hàng</div>
                <div class="table-duo">
                    <div>
                        <h4>Thương hiệu ưa thích</h4>
                        <table>
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
                    <div>
                        <h4>Thương hiệu được mua</h4>
                        <table>
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

            {{-- ===== LOẠI XE ===== --}}
            <div class="section-block section-loaixe">
                <div class="section-header">🚙 Top loại xe xu hướng theo hành vi khách hàng</div>
                <div class="table-duo">
                    <div>
                        <h4>Loại xe ưa thích</h4>
                        <table>
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
                    <div>
                        <h4>Loại xe được mua</h4>
                        <table>
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

            {{-- ===== MÀU XE ===== --}}
            <div class="section-block section-mauxe">
                <div class="section-header">🎨 Top màu xe theo hành vi khách hàng</div>
                <div class="table-duo">
                    <div>
                        <h4>Màu xe ưa thích</h4>
                        <table>
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
                    <div>
                        <h4>Màu xe được mua</h4>
                        <table>
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

        </div>{{-- end thong-ke-tieu-dung --}}
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const textColor = '#1e293b';
    const boldFont  = { weight: '700', size: 12 };

    // Bảng màu rực rỡ cho biểu đồ tròn
    const palette = [
        '#6366f1','#f59e0b','#10b981','#f43f5e','#3b82f6',
        '#a855f7','#14b8a6','#ef4444','#84cc16','#0ea5e9'
    ];

    const commonTooltip = {
        enabled: true,
        backgroundColor: 'rgba(15,23,42,0.88)',
        titleFont: { weight: 'bold', size: 14 },
        bodyFont:  { weight: '600',  size: 13 },
        padding: 12,
        cornerRadius: 10,
        displayColors: true
    };

    // ── 1. BIỂU ĐỒ ĐƯỜNG – LÁI THỬ ──────────────────────────────
    const lineData = @json($bieuDo ?? []);
    const lineCtx  = document.getElementById('chartLichTheoThoiGian')?.getContext('2d');
    if (lineCtx && lineData.length > 0) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineData.map(i => i.nhom),
                datasets: [{
                    label: 'Số lượt đặt lịch',
                    data: lineData.map(i => parseInt(i.so_lan_dat)),
                    borderColor: '#3b82f6',
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(59, 130, 246, 0)');
                        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.15)');
                        return gradient;
                    },
                    fill: true,
                    tension: 0.45,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#3b82f6',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        align: 'center', /* Căn giữa tiêu đề biểu đồ */
                        labels: { 
                            color: '#0f172a', /* Màu tối đậm cho nét chữ sắc sảo */
                            font: { family: 'Inter', size: 13, weight: '800' },
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            padding: 20
                        } 
                    },
                    tooltip: commonTooltip
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Thời gian',
                            color: '#0f172a',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        ticks: { color: '#0f172a', font: { family: 'Inter', size: 12, weight: '700' } },
                        grid: { display: false }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Số lượt',
                            color: '#0f172a',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        beginAtZero: true,
                        ticks: { color: '#0f172a', font: { family: 'Inter', size: 12, weight: '700' }, stepSize: 1 },
                        grid: { color: '#f1f5f9', borderDash: [4, 4], drawBorder: false }
                    }
                }
            }
        });
    }

    // ── 2. BIỂU ĐỒ CỘT – KHUNG GIỜ ──────────────────────────────
    const kgData = @json($thongKeKhungGio ?? []);
    const kgCtx  = document.getElementById('chartKhungGioCot')?.getContext('2d');
    if (kgCtx && kgData.length > 0) { // Chỉ vẽ biểu đồ nếu có dữ liệu
        new Chart(kgCtx, { 
            type: 'bar',
            data: {
                labels: kgData.map(i => i.khung_gio),
                datasets: [{
                    label: 'Số lượt đặt',
                    data: kgData.map(i => i.so_lan_dat),
                    backgroundColor: kgData.map((_, idx) => palette[idx % palette.length] + 'cc'),
                    hoverBackgroundColor: kgData.map((_, idx) => palette[idx % palette.length]),
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        align: 'center', /* Căn giữa */
                        labels: { 
                            color: '#0f172a', 
                            font: { family: 'Inter', size: 13, weight: '800' },
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            padding: 20
                        } 
                    },
                    tooltip: commonTooltip
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Khung giờ',
                            color: '#1e293b',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        ticks: { color: '#1e293b', font: { family: 'Inter', size: 12, weight: '700' } },
                        grid: { display: false }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Số lượt',
                            color: '#1e293b',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        beginAtZero: true,
                        ticks: { color: '#1e293b', font: { family: 'Inter', size: 12, weight: '700' }, stepSize: 1 },
                        grid: { color: '#f1f5f9', borderDash: [4, 4], drawBorder: false }
                    }
                }
            }
        });
    }

    // ── 3. BIỂU ĐỒ ĐƯỜNG – BẢO DƯỠNG ────────────────────────────
    const bdData = @json($bieuDoBaoDuong ?? []);
    const bdCtx  = document.getElementById('chartLichBaoDuongTheoThoiGian')?.getContext('2d');
    if (bdCtx && bdData.length > 0) {
        new Chart(bdCtx, {
            type: 'line',
            data: {
                labels: bdData.map(i => i.nhom),
                datasets: [{
                    label: 'Số lượt bảo dưỡng',
                    data: bdData.map(i => parseInt(i.so_lan_dat)),
                    borderColor: '#10b981',
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(16, 185, 129, 0)');
                        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.15)');
                        return gradient;
                    },
                    fill: true,
                    tension: 0.45,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        align: 'center', /* Căn giữa */
                        labels: { 
                            color: '#0f172a', 
                            font: { family: 'Inter', size: 13, weight: '800' },
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            padding: 20
                        } 
                    },
                    tooltip: commonTooltip
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Thời gian',
                            color: '#1e293b',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        ticks: { color: '#1e293b', font: { family: 'Inter', size: 12, weight: '700' } },
                        grid: { display: false }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Số lượt',
                            color: '#1e293b',
                            font: { family: 'Inter', size: 13, weight: '800' }
                        },
                        beginAtZero: true,
                        ticks: { color: '#1e293b', font: { family: 'Inter', size: 12, weight: '700' }, stepSize: 1 },
                        grid: { color: '#f1f5f9', borderDash: [4, 4], drawBorder: false }
                    }
                }
            }
        });
    }

    // ── 4. BIỂU ĐỒ TRÒN – LOẠI XE ───────────────────────────────
    const lxData = @json($topLoaiXeXuHuong ?? []);
    const lxCtx  = document.getElementById('chartLoaiXeXuHuong')?.getContext('2d');
    if (lxCtx && lxData.length > 0) {
        new Chart(lxCtx, {
            type: 'doughnut',
            data: {
                labels: lxData.map(i => i.Ten_Loai_Xe),
                datasets: [{
                    data: lxData.map(i => i.tong_tuong_tac),
                    backgroundColor: palette,
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 16
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '58%',
                layout: { padding: { bottom: 10 } },
                plugins: {
                    legend: {
                        position: 'bottom', 
                        labels: { 
                            color: '#1e293b',
                            font: { weight: '700', size: 11 },
                            padding: 10,
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...commonTooltip,
                        callbacks: {
                            label: function(ctx) {
                                const item = lxData[ctx.dataIndex];
                                return [
                                    ` Tổng: ${item.tong_tuong_tac} lượt`,
                                    ` • Lái thử: ${item.so_luong_lai_thu}`,
                                    ` • Mua xe:  ${item.so_luong_don_hang}`
                                ];
                            }
                        }
                    }
                }
            }
        });
    }

    // ── 5. BIỂU ĐỒ TRÒN – THƯƠNG HIỆU ───────────────────────────
    const thData = @json($topThuongHieuXuHuong ?? []);
    const thCtx  = document.getElementById('chartThuongHieuXuHuong')?.getContext('2d');
    if (thCtx && thData.length > 0) {
        new Chart(thCtx, {
            type: 'doughnut',
            data: {
                labels: thData.map(i => i.Ten_Thuong_Hieu),
                datasets: [{
                    data: thData.map(i => i.tong_tuong_tac),
                    backgroundColor: palette,
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 16
                }]
            },
            options: {
                responsive: true, 
                maintainAspectRatio: true,
                cutout: '58%',
                layout: { padding: { bottom: 10 } },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#1e293b',
                            font: { weight: '700', size: 11 },
                            padding: 10,
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...commonTooltip, 
                        callbacks: {
                            label: function(ctx) {
                                const item = thData[ctx.dataIndex];
                                return [
                                    ` Tổng: ${item.tong_tuong_tac} lượt`,
                                    ` • Lái thử: ${item.so_luong_lai_thu}`,
                                    ` • Mua xe:  ${item.so_luong_don_hang}`
                                ];
                            }
                        }
                    }
                }
            }
        });
    }   

    // ── FETCH CHI TIẾT THEO NGÀY ──────────────────────────────────
    window.fetchKhungGioTheoNgay = function(ngay) {
        fetch(`/trang_admin/kiem_ke/khunggio-theongay?ngay=${encodeURIComponent(ngay)}`)
            .then(r => r.json())
            .then(json => {
                const body = document.querySelector('#bangChiTietKhungGio tbody');
                document.getElementById('tieuDeKhungGio').textContent = 'Chi tiết khung giờ ngày ' + ngay;
                body.innerHTML = (json.khungGio || []).map(item => `
                    <tr><td>${item.khung_gio}</td><td>${item.loai_xe||'-'}</td><td>${item.ten_xe||'-'}</td><td>${item.ten_thuong_hieu||'-'}</td><td>${item.ten_mau||'-'}</td><td>${item.so_lan_dat}</td></tr>
                `).join('') || '<tr><td colspan="6" style="text-align:center;color:#94a3b8;">Không có dữ liệu</td></tr>';
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
                    <tr><td>${item.ten_xe||'-'}</td><td>${item.ten_mau||'-'}</td><td>${item.ngay_bao_duong}</td><td>${item.ngay_cap_nhat}</td><td>${item.goi_bao_duong}</td><td>${item.so_lan_dat}</td></tr>
                `).join('') || '<tr><td colspan="6" style="text-align:center;color:#94a3b8;">Không có dữ liệu</td></tr>';
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