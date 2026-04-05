<div class="admin-kiem-ke">
    <h2>Kiểm Kê</h2>
<link rel="stylesheet" href="{{ asset('admin/css/admin_kiem_ke.css') }}">
    <div class="kiem_ke-sidebar">
        <a href="{{ url('/trang_admin/kiem_ke/doanh-thu') }}" class="{{ ($tab ?? 'tieu-dung') === 'doanh-thu' ? 'active' : '' }}">Doanh Thu</a>
        <a href="{{ url('/trang_admin/kiem_ke/tieu-dung') }}" class="{{ ($tab ?? 'tieu-dung') === 'tieu-dung' ? 'active' : '' }}">Tiêu Dùng</a>
    </div>

    @if(($tab ?? 'tieu-dung') === 'doanh-thu')
        <div class="thong-ke-doanh-thu">
            <p> thêm nội dung doanh thu ở đây sau.</p>
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

            <h3>Số lượt đặt lịch lái thử </h3>
            <div class="row" style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                <label style="margin-bottom:0;">Chọn ngày để xem khung giờ:</label>
                <input type="date" id="dateFilter" value="{{ $from ?? '' }}" style="padding:6px 10px; border:1px solid #cbd5e1; border-radius:6px;" />
                <button id="btnFetchByDate" type="button" style="padding:7px 14px; background:#2f80ed; color:#fff; border:none; border-radius:6px;">Xem theo ngày</button>
            </div>
            <canvas id="chartLichTheoThoiGian" width="800" height="300"></canvas>

            <div id="chiTietKhungGio" style="display:none; margin-top:16px;">
                <h4 id="tieuDeKhungGio">Chi tiết khung giờ của ngày </h4>
                <table id="bangChiTietKhungGio" border="1" cellpadding="8" cellspacing="0" width="100%">
                    <thead><tr><th>Khung giờ</th><th>Loại xe</th><th>Tên xe</th><th>Thương hiệu</th><th>Màu xe</th><th>Số lần đặt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            <h3> Đặt Lịch Bảo Dưỡng </h3>
            <div class="row" style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                <label style="margin-bottom:0;">Chọn ngày bảo dưỡng:</label>
                <input type="date" id="baoDuongDateFilter" value="{{ $from ?? '' }}" style="padding:6px 10px; border:1px solid #cbd5e1; border-radius:6px;" />
                <button id="btnBaoDuongFetchByDate" type="button" style="padding:7px 14px; background:#16a34a; color:#fff; border:none; border-radius:6px;">Tra cứu ngày</button>
            </div>
            <canvas id="chartLichBaoDuongTheoThoiGian" width="800" height="300"></canvas>

            <div id="chiTietBaoDuong" style="display:none; margin-top:16px;">
                <h4 id="tieuDeBaoDuong">Chi tiết lịch bảo dưỡng ngày </h4>
                <table id="bangChiTietBaoDuong" border="1" cellpadding="8" cellspacing="0" width="100%">
                    <thead><tr><th>Xe</th><th>Màu xe</th><th>Ngày bảo dưỡng</th><th>Ngày cập nhật</th><th>Gói bảo dưỡng</th><th>Số lượt</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="row-charts" style="display: flex; gap: 20px; margin: 30px 0; flex-wrap: wrap;">
     <div style="flex: 1; min-width: 320px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); text-align: center;">
        <h4 style="margin-bottom: 15px; color: #1e293b; font-weight: 600;"> Xu hướng theo Dòng xe </h4>
        <div style="max-width: 260px; margin: auto;">
            <canvas id="chartLoaiXeXuHuong"></canvas>
        </div>
    </div>

    <div style="flex: 1; min-width: 320px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); text-align: center;">
        <h4 style="margin-bottom: 15px; color: #1e293b; font-weight: 600;"> Xu hướng theo Thương Hiệu</h4>
        <div style="max-width: 260px; margin: auto;">
            <canvas id="chartThuongHieuXuHuong"></canvas>
        </div>
    </div>
</div>

            <h3>Thống kê lịch bảo dưỡng</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead>
                    <tr><th>Khoảng</th><th>Số lần đặt</th></tr>
                </thead>
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

            <h3>Top thương hiệu được ưa thích </h3> 
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Thương hiệu</th><th>  lượt ưa thích  </th></tr></thead>
                <tbody>
                    @foreach($topThuongHieu ?? [] as $row)
                        <tr><td>{{ $row['Ten_Thuong_Hieu'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top loại xe được ưa thích </h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Loại xe</th><th>  lượt ưa thích  </th></tr></thead>
                <tbody>
                    @foreach($topLoaiXeUaChuong ?? [] as $row)
                        <tr><td>{{ $row['Ten_Loai_Xe'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top loại xe mua nhiều nhất</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Loại xe</th><th>  lượt mua </th></tr></thead>
                <tbody>
                    @foreach($topLoaiXeMua ?? [] as $row)
                        <tr><td>{{ $row['Ten_Loai_Xe'] }}</td><td>{{ $row['so_lan_mua'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top thương hiệu mua nhiều nhất</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Thương hiệu</th><th>  lượt mua </th></tr></thead>
                <tbody>
                    @foreach($topThuongHieuMua ?? [] as $row)
                        <tr><td>{{ $row['Ten_Thuong_Hieu'] }}</td><td>{{ $row['so_lan_mua'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top màu xe được ưa thích </h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Màu xe</th><th> lượt ưa thích  </th></tr></thead>
                <tbody>
                    @foreach($topMauXeUaChuong ?? [] as $row)
                        <tr><td>{{ $row['Ten_Mau'] }}</td><td>{{ $row['so_lan_dat'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top màu xe được mua</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Màu xe</th><th> lượt  mua</th></tr></thead>
                <tbody>
                    @foreach($topMauXeMua ?? [] as $row)
                        <tr><td>{{ $row['Ten_Mau'] }}</td><td>{{ $row['so_lan_mua'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($bieuDo ?? []);
    const labels = Array.isArray(chartData) ? chartData.map(i => i.nhom) : [];
    const data = Array.isArray(chartData) ? chartData.map(i => parseInt(i.so_lan_dat)) : [];

    const chartCanvas = document.getElementById('chartLichTheoThoiGian');
    const chiTietBox = document.getElementById('chiTietKhungGio');
    const tieuDeChiTiet = document.getElementById('tieuDeKhungGio'); 
    const bangChiTietBody = document.querySelector('#bangChiTietKhungGio tbody');
    const chartGroup = @json($group ?? 'ngay'); 

    function hienThiChiTietKhungGio(ngay, items) {
        if (!chiTietBox || !tieuDeChiTiet || !bangChiTietBody) return;
        tieuDeChiTiet.textContent = 'Chi tiết khung giờ của ngày ' + ngay;
        bangChiTietBody.innerHTML = '';

        if (!items || items.length === 0) {
            bangChiTietBody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Không có dữ liệu khung giờ</td></tr>';
        } else {
            items.forEach(function(item) { 
                const row = document.createElement('tr');
                row.innerHTML = `<td>${item.khung_gio}</td>
                                 <td>${item.loai_xe || '-'}</td>
                                 <td>${item.ten_xe || '-'}</td>
                                 <td>${item.ten_thuong_hieu || '-'}</td>
                                 <td>${item.ten_mau || '-'}</td>
                                 <td>${item.so_lan_dat}</td>`;
                bangChiTietBody.appendChild(row);
            });
        }
        chiTietBox.style.display = 'block';
    }

    if (chartCanvas && Array.isArray(chartData) && chartData.length > 0) {
        const ctx = chartCanvas.getContext('2d'); 
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượt đặt lịch',
                    data: data,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.2,
                }]
            },
            options: {
                responsive: true,
                onClick: function(evt, activeEls) {
                    if (activeEls.length === 0) return;
                    const index = activeEls[0].index;
                    const selectedDate = this.data.labels[index];
                    if (chartGroup !== 'ngay') {
                        alert('Chi tiết khung giờ chỉ khả dụng khi nhóm theo ngày.');
                        return;
                    }
                    dateFilter.value = selectedDate;
                    fetchKhungGioTheoNgay(selectedDate); 
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Thời gian', font: { weight: 'bold' } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: value => Number.isInteger(value) ? value : ''
                        },
                        title: { display: true, text: 'Số lượt đặt', font: { weight: 'bold' } }
                    }
                }
            }
        });
    }

    const baoDuongData = @json($bieuDoBaoDuong ?? []);
    const baoDuongLabels = Array.isArray(baoDuongData) ? baoDuongData.map(i => i.nhom) : [];
    const baoDuongValues = Array.isArray(baoDuongData) ? baoDuongData.map(i => parseInt(i.so_lan_dat)) : [];
    const baoDuongCanvas = document.getElementById('chartLichBaoDuongTheoThoiGian');

    if (baoDuongCanvas && Array.isArray(baoDuongData) && baoDuongData.length > 0) {
        const ctx2 = baoDuongCanvas.getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: baoDuongLabels,
                datasets: [{
                    label: 'Số lượt đặt lịch bảo dưỡng',
                    data: baoDuongValues,
                    backgroundColor: 'rgba(34, 197, 94, 0.25)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                onClick: function(evt, activeEls) {
                    if (activeEls.length === 0) return;
                    const index = activeEls[0].index;
                    const selectedDate = this.data.labels[index];
                    if (chartGroup !== 'ngay') {
                        alert('Chi tiết bảo dưỡng theo ngày chỉ khả dụng khi nhóm theo ngày.');
                        return;
                    }
                    baoDuongDateFilter.value = selectedDate;
                    fetchBaoDuongTheoNgay(selectedDate);
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Thời gian', font: { weight: 'bold' } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        title: { display: true, text: 'Số lượt đặt', font: { weight: 'bold' } }
                    }
                }
            }
        });
    }
// Hàm để gọi API lấy chi tiết bảo dưỡng theo ngày 
    function fetchBaoDuongTheoNgay(ngay) {
        fetch('/trang_admin/kiem_ke/bao-duong-theongay?ngay=' + encodeURIComponent(ngay))
            .then(r => r.json())
            .then(json => hienThiChiTietBaoDuong(ngay, json.baoDuong || []))
            .catch(err => console.error(err));
    }

    function fetchKhungGioTheoNgay(ngay) {
        fetch('/trang_admin/kiem_ke/khunggio-theongay?ngay=' + encodeURIComponent(ngay))
            .then(r => r.json())
            .then(json => hienThiChiTietKhungGio(ngay, json.khungGio || []))
            .catch(e => console.error(e));
    }

    function hienThiChiTietBaoDuong(ngay, items) {
        const chiTietBoxBD = document.getElementById('chiTietBaoDuong');
        const tieuDeBD = document.getElementById('tieuDeBaoDuong');
        const bodyBD = document.querySelector('#bangChiTietBaoDuong tbody');
        if (!chiTietBoxBD || !bodyBD) return;
        tieuDeBD.textContent = 'Chi tiết lịch bảo dưỡng ngày ' + ngay; 
        bodyBD.innerHTML = items.length === 0 ? '<tr><td colspan="6" style="text-align:center;">Không có dữ liệu</td></tr>' : '';
        items.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${item.ten_xe || '-'}</td><td>${item.ten_mau || '-'}</td><td>${item.ngay_bao_duong}</td><td>${item.ngay_cap_nhat}</td><td>${item.goi_bao_duong}</td><td>${item.so_lan_dat}</td>`;
            bodyBD.appendChild(row);
        });
        chiTietBoxBD.style.display = 'block';
    }

    const btnBaoDuongFetchByDate = document.getElementById('btnBaoDuongFetchByDate'); //  nút tra cứu 
    const baoDuongDateFilter = document.getElementById('baoDuongDateFilter'); // input ngày bảo dưỡng
    btnBaoDuongFetchByDate?.addEventListener('click', () => baoDuongDateFilter.value ? fetchBaoDuongTheoNgay(baoDuongDateFilter.value) : alert('Hãy chọn ngày!')); 

    const btnFetchByDate = document.getElementById('btnFetchByDate');
    const dateFilter = document.getElementById('dateFilter');
    btnFetchByDate?.addEventListener('click', () => dateFilter.value ? fetchKhungGioTheoNgay(dateFilter.value) : alert('Hãy chọn ngày!'));
    
   // biểu đồ tròn //
const dataLoaiXe = @json($topLoaiXeXuHuong ?? []); // Đảm bảo biến này khớp với tên bạn truyền từ Controller
const palette = ['#2f80ed', '#16a34a', '#f2994a', '#eb5757', '#9b51e0', '#2196f3', '#56ccf2', '#f2c94c'];
const ctxLoaiXe = document.getElementById('chartLoaiXeXuHuong')?.getContext('2d');
if (ctxLoaiXe && dataLoaiXe.length > 0) {
    new Chart(ctxLoaiXe, {
        type: 'pie',
        data: {
            labels: dataLoaiXe.map(i => i.Ten_Loai_Xe),
            datasets: [{
                data: dataLoaiXe.map(i => i.tong_tuong_tac),
                backgroundColor: palette,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const item = dataLoaiXe[index];
                            return [
                                ` ${item.Ten_Loai_Xe}: ${item.tong_tuong_tac} lượt`,
                                `   • Đặt lịch lái thử: ${item.so_luong_lai_thu}`,
                                `   • Số lượng mua: ${item.so_luong_don_hang}`
                            ];
                        }
                    }
                }
            }
        }
    });
}

//  Biểu đồ  tròn Xu hướng theo Thương Hiệu
const dataThuongHieu = @json($topThuongHieuXuHuong ?? []); // Đảm bảo biến này khớp với Controller

const ctxThuongHieu = document.getElementById('chartThuongHieuXuHuong')?.getContext('2d');
if (ctxThuongHieu && dataThuongHieu.length > 0) {
    new Chart(ctxThuongHieu, {
        type: 'pie',
        data: {
            labels: dataThuongHieu.map(i => i.Ten_Thuong_Hieu),
            datasets: [{
                data: dataThuongHieu.map(i => i.tong_tuong_tac),
                backgroundColor: palette,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const item = dataThuongHieu[index];
                            return [
                                ` ${item.Ten_Thuong_Hieu}: ${item.tong_tuong_tac} lượt`,
                                `   • Đặt lịch lái thử: ${item.so_luong_lai_thu}`,
                                `   • Số lượng mua: ${item.so_luong_don_hang}`
                            ];
                        }
                    }
                }
            }
        }
    });
}
</script>