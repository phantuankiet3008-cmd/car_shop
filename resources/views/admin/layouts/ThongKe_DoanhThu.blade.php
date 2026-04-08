<style>
    .insight-container { font-family: 'Inter', sans-serif; margin-top: 25px; }
    .insight-header { margin-bottom: 25px; }
    .insight-header h3 { font-size: 26px; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px; }
    .insight-header p { color: #94a3b8; font-size: 14px; margin-top: 4px; font-weight: 500; }
    
    .insight-cards { display: flex; gap: 20px; flex-wrap: wrap; }
    .insight-card { 
        background: #fff; border-radius: 20px; padding: 24px; flex: 1; min-width: 200px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f8fafc;
    }
    .ic-icon { 
        width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;
    }
    .ic-rev { background: #fff7ed; color: #f59e0b; }
    .ic-usr { background: #eff6ff; color: #3b82f6; }
    .ic-ret { background: #faf5ff; color: #a855f7; }
    .ic-con { background: #fff1f2; color: #ef4444; }

    .ic-title { color: #64748b; font-size: 14px; font-weight: 600; margin-bottom: 8px; display: block;}
    .ic-value { font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; letter-spacing: -0.5px;}
    .ic-trend { font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
    .t-up { color: #10b981; }
    .t-down { color: #ef4444; }

    .insight-chart-section {
        background: #fff; border-radius: 24px; padding: 30px; margin-top: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f8fafc;
    }
    .chart-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
    .chart-title h4 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;}
    .chart-title p { color: #64748b; font-size: 14px; margin: 4px 0 0 0; font-weight: 500; }
    .chart-tabs { display: flex; background: #f8fafc; padding: 4px; border-radius: 12px; }
    .chart-tabs span { padding: 6px 16px; font-size: 13px; font-weight: 700; color: #64748b; cursor: pointer; border-radius: 8px; transition: 0.3s; }
    .chart-tabs span.active { background: #fff; color: #0f172a; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
</style>

<div class="insight-container">
    <div class="insight-header">
        <h3>Trung Tâm Hiệu Suất</h3>
        <p>Trực quan hóa sự tăng trưởng hệ sinh thái năm {{ $namHienTai ?? date('Y') }}</p>
    </div>

    <div class="insight-cards">
        <div class="insight-card">
            <div class="ic-icon ic-rev"><i class="fa-solid fa-wallet"></i></div>
            <span class="ic-title">Tổng Doanh Thu</span>
            <h4 class="ic-value">{{ number_format($tongDoanhThu ?? 0, 0, ',', '.') }} đ</h4>
            <span class="ic-trend t-up"><i class="fa-solid fa-bolt"></i> Cập nhật tự động</span>
        </div>

        <div class="insight-card" onclick="openModalXeBan()" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            <div class="ic-icon ic-con"><i class="fa-solid fa-car"></i></div> 
            <span class="ic-title">Số Lượng Xe Bán Ra</span>
            <h4 class="ic-value">{{ $soLuongXeBanRa ?? 0 }}</h4>
            <span class="ic-trend t-up"><i class="fa-solid fa-hand-pointer"></i> Nhấn để xem chi tiết</span>
        </div>

        <div class="insight-card">
            <div class="ic-icon ic-usr"><i class="fa-solid fa-user-plus"></i></div>
            <span class="ic-title">Tổng Khách Hàng</span>
            <h4 class="ic-value">{{ number_format($khachHangMoi ?? 0, 0, ',', '.') }}</h4>
            <span class="ic-trend t-up"><i class="fa-solid fa-bolt"></i> Cập nhật tự động</span>
        </div>

        <div class="insight-card">
            <div class="ic-icon ic-ret"><i class="fa-solid fa-rotate-left"></i></div>
            <span class="ic-title">Tỷ Lệ Khách Mua Lại</span>
            <h4 class="ic-value">{{ $tyLeQuayLai ?? 0 }}%</h4>
            <span class="ic-trend {{ ($tyLeQuayLai ?? 0) > 0 ? 't-up' : 't-down' }}">
                <i class="fa-solid fa-chart-pie"></i> Dữ liệu thực tế
            </span>
        </div>
    </div>

    <div class="insight-chart-section">
        <div class="chart-top">
            <div class="chart-title">
                <h4>Dự Báo Tăng Trưởng</h4>
                <p>Kết quả thực tế và dự kiến cho năm {{ $namHienTai ?? date('Y') }}</p>
            </div>
            <div class="chart-tabs">
                <span>Tuần</span>
                <span class="active">Tháng</span>
                <span>Năm</span>
            </div>
        </div>
        
        <div style="height: 350px; width: 100%;">
            <canvas id="insightRevenueChart"></canvas>
        </div>
    </div>
</div>

<div id="modalXeBan" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div style="background-color: #fff; padding: 25px; border-radius: 16px; width: 80%; max-width: 800px; max-height: 80vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: #0f172a;">Chi Tiết Xe Đã Bán Năm {{ $namHienTai ?? date('Y') }}</h3>
            <span onclick="closeModalXeBan()" style="font-size: 24px; font-weight: bold; color: #64748b; cursor: pointer;">&times;</span>
        </div>
        
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; text-align: left; border-color: #e2e8f0;">
            <thead style="background-color: #f8fafc;">
                <tr>
                    <th>STT</th>
                    <th>Tên Xe</th>
                    <th>Màu Xe</th>
                    <th>Giá Bán (VNĐ)</th>
                    <th>Ngày Bán</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($chiTietXeBanRa) && count($chiTietXeBanRa) > 0)
                    @foreach($chiTietXeBanRa as $index => $xe)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-weight: 600; color: #3b82f6;">{{ $xe['Ten_Xe'] }}</td>
                            <td>{{ $xe['Ten_Mau'] }}</td>
                            <td style="font-weight: bold; color: #10b981;">{{ number_format($xe['Tong_Tien'], 0, ',', '.') }} đ</td>
                            <td>{{ date('d/m/Y', strtotime($xe['Ngay_Tao'])) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Chưa có dữ liệu xe bán ra.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Khởi tạo biểu đồ
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('insightRevenueChart').getContext('2d');
    
    // Tạo gradient màu xanh mờ dần xuống
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); 
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    const dataDoanhThu = {!! json_encode($bieuDoDoanhThu ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Th 1', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'Th 8', 'Th 9', 'Th 10', 'Th 11', 'Th 12'],
            datasets: [{
                label: 'Doanh Thu',
                data: dataDoanhThu,
                borderColor: '#3b82f6', 
                backgroundColor: gradient,
                borderWidth: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) { return context.raw.toLocaleString('vi-VN') + ' đ'; }
                    }
                }
            },
            scales: {
                y: { display: false, beginAtZero: true },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { color: '#94a3b8', font: { size: 12, weight: '600' } }
                }
            },
            interaction: { mode: 'index', intersect: false },
        }
    });
});

// Hàm xử lý Mở/Đóng Modal Chi tiết Xe
function openModalXeBan() {
    document.getElementById('modalXeBan').style.display = 'flex';
}

function closeModalXeBan() {
    document.getElementById('modalXeBan').style.display = 'none';
}

// Bấm ra ngoài vùng xám đen để đóng Modal
window.onclick = function(event) {
    let modal = document.getElementById('modalXeBan');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>