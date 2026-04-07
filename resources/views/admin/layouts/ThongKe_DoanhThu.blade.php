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
            <span class="ic-trend t-up"><i class="fa-solid fa-arrow-trend-up"></i> +14.2%</span>
        </div>

        <div class="insight-card">
            <div class="ic-icon ic-usr"><i class="fa-solid fa-user-plus"></i></div>
            <span class="ic-title">Khách Hàng Mới</span>
            <h4 class="ic-value">{{ number_format($khachHangMoi ?? 0, 0, ',', '.') }}</h4>
            <span class="ic-trend t-up"><i class="fa-solid fa-arrow-trend-up"></i> +5.1%</span>
        </div>

        <div class="insight-card">
            <div class="ic-icon ic-ret"><i class="fa-solid fa-chart-line"></i></div>
            <span class="ic-title">Tỷ Lệ Giữ Chân</span>
            <h4 class="ic-value">68.4%</h4>
            <span class="ic-trend t-down"><i class="fa-solid fa-arrow-trend-down"></i> -2.4%</span>
        </div>

        <div class="insight-card">
            <div class="ic-icon ic-con"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
            <span class="ic-title">Tỷ Lệ Chuyển Đổi</span>
            <h4 class="ic-value">4.21%</h4>
            <span class="ic-trend t-up"><i class="fa-solid fa-arrow-trend-up"></i> +0.8%</span>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
                pointRadius: 0, // Ẩn điểm mặc định, chỉ hiện khi hover giống hình mẫu
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // Tạo đường lượn sóng mượt
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
                y: { display: false, beginAtZero: true }, // Ẩn cột Y giống mẫu
                x: {
                    grid: { display: false, drawBorder: false }, // Ẩn lưới nền
                    ticks: { color: '#94a3b8', font: { size: 12, weight: '600' } }
                }
            },
            interaction: { mode: 'index', intersect: false },
        }
    });
});
</script>