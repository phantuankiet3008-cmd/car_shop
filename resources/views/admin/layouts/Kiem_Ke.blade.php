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
                    <thead><tr><th>Khung giờ</th><th>Loại xe</th><th>Thương hiệu</th><th>Số lần đặt</th></tr></thead>
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
                    <thead><tr><th>Xe</th><th>Thương hiệu</th><th>Trạng thái</th><th>Số lượt</th></tr></thead>
                    <tbody></tbody>
                </table>
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
                <thead><tr><th>Xe</th><th>Số lần</th></tr></thead>
                <tbody>
                    @foreach($topXe ?? [] as $row)
                        <tr><td>{{ $row['Ten_Xe'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top thương hiệu được quan tâm</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Thương hiệu</th><th>Số lượt quan tâm </th></tr></thead>
                <tbody>
                    @foreach($topThuongHieu ?? [] as $row)
                        <tr><td>{{ $row['Ten_Thuong_Hieu'] }}</td><td>{{ $row['so_lan_lai_thu'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top loại xe mua nhiều nhất</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Loại xe</th><th>Số lần</th></tr></thead>
                <tbody>
                    @foreach($topLoaiXeMua ?? [] as $row)
                        <tr><td>{{ $row['Ten_Loai_Xe'] }}</td><td>{{ $row['so_lan_mua'] }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Top thương hiệu mua nhiều nhất</h3>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead><tr><th>Thương hiệu</th><th>Số lần</th></tr></thead>
                <tbody>
                    @foreach($topThuongHieuMua ?? [] as $row)
                        <tr><td>{{ $row['Ten_Thuong_Hieu'] }}</td><td>{{ $row['so_lan_mua'] }}</td></tr>
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
            bangChiTietBody.innerHTML = '<tr><td colspan="4" style="text-align:center;">Không có dữ liệu khung giờ</td></tr>';
        } else {
            items.forEach(function(item) {
                const row = document.createElement('tr');
                const td1 = document.createElement('td'); td1.textContent = item.khung_gio;
                const td2 = document.createElement('td'); td2.textContent = item.ten_xe || '-';
                const td3 = document.createElement('td'); td3.textContent = item.ten_thuong_hieu || '-';
                const td4 = document.createElement('td'); td4.textContent = item.so_lan_dat;
                row.appendChild(td1);
                row.appendChild(td2);
                row.appendChild(td3);
                row.appendChild(td4);
                bangChiTietBody.appendChild(row);
            });
        }

        chiTietBox.style.display = 'block';
    }

    if (!chartCanvas) {
        console.warn('Chart canvas not found (maybe tab khác không có canvas).');
    } else if (!Array.isArray(chartData) || chartData.length === 0) {
        chartCanvas.style.display = 'none';
        console.info('Không có dữ liệu biểu đồ để hiển thị.');
    } else {
        const ctx = chartCanvas.getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lần đặt lịch',
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

                    // chỉ còn gọi chi tiết khi nhóm ngày (group=ngay)
                    if (chartGroup !== 'ngay') {
                        alert('Chi tiết khung giờ chỉ khả dụng khi nhóm theo ngày. Vui lòng chọn nhóm Ngày hoặc dùng bộ lọc từ ngày đến ngày.');
                        return;
                    }

                    dateFilter.value = selectedDate;
                    fetchKhungGioTheoNgay(selectedDate);
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                }
            }
        });
    }
    const baoDuongData = @json($bieuDoBaoDuong ?? []);
    const baoDuongLabels = Array.isArray(baoDuongData) ? baoDuongData.map(i => i.nhom) : [];
    const baoDuongValues = Array.isArray(baoDuongData) ? baoDuongData.map(i => parseInt(i.so_lan_dat)) : [];
    const baoDuongCanvas = document.getElementById('chartLichBaoDuongTheoThoiGian');

    if (!baoDuongCanvas) {
        console.warn('Chart bảo dưỡng không tìm thấy canvas.');
    } else if (!Array.isArray(baoDuongData) || baoDuongData.length === 0) {
        baoDuongCanvas.style.display = 'none';
        console.info('Không có dữ liệu bảo dưỡng để hiển thị.');
    } else {
        const ctx2 = baoDuongCanvas.getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: baoDuongLabels,
                datasets: [{
                    label: 'Số lần đặt lịch bảo dưỡng',
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
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    function hienThiChiTietBaoDuong(ngay, items) {
        const chiTietBox = document.getElementById('chiTietBaoDuong');
        const tieuDe = document.getElementById('tieuDeBaoDuong');
        const body = document.querySelector('#bangChiTietBaoDuong tbody');
        if (!chiTietBox || !tieuDe || !body) return;

        tieuDe.textContent = 'Chi tiết lịch bảo dưỡng ngày ' + ngay;
        body.innerHTML = '';

        if (!items || items.length === 0) {
            body.innerHTML = '<tr><td colspan="4" style="text-align:center;">Không có dữ liệu bảo dưỡng</td></tr>';
        } else {
            items.forEach(function(item) {
                const row = document.createElement('tr');
                const c1 = document.createElement('td'); c1.textContent = item.ten_xe || '-';
                const c2 = document.createElement('td'); c2.textContent = item.ten_thuong_hieu || '-';
                const c3 = document.createElement('td'); c3.textContent = item.trang_thai || '-';
                const c4 = document.createElement('td'); c4.textContent = item.so_lan_dat;
                row.appendChild(c1); row.appendChild(c2); row.appendChild(c3); row.appendChild(c4);
                body.appendChild(row);
            });
        }
        chiTietBox.style.display = 'block';
    }

    const btnBaoDuongFetchByDate = document.getElementById('btnBaoDuongFetchByDate');
    const baoDuongDateFilter = document.getElementById('baoDuongDateFilter');

    btnBaoDuongFetchByDate.addEventListener('click', function () {
        if (!baoDuongDateFilter.value) {
            alert('Hãy chọn ngày để tra cứu lịch bảo dưỡng.');
            return;
        }
        fetchBaoDuongTheoNgay(baoDuongDateFilter.value);
    });

    function fetchBaoDuongTheoNgay(ngay) {
        fetch('/trang_admin/kiem_ke/bao-duong-theongay?ngay=' + encodeURIComponent(ngay))
            .then(r => r.json())
            .then(json => {
                if (json.baoDuong) {
                    hienThiChiTietBaoDuong(ngay, json.baoDuong);
                } else {
                    hienThiChiTietBaoDuong(ngay, []);
                }
            })
            .catch(err => {
                console.error(err);
                hienThiChiTietBaoDuong(ngay, []);
            });
    }

    const btnFetchByDate = document.getElementById('btnFetchByDate');
    const dateFilter = document.getElementById('dateFilter');

    // Nếu đã có ngày mặc định (từ filter), hiển thị chi tiết ngay lập tức
    if (dateFilter.value && chartGroup === 'ngay') {
        fetchKhungGioTheoNgay(dateFilter.value);
    }

    btnFetchByDate.addEventListener('click', function () {
        if (!dateFilter.value) {
            alert('Hãy chọn ngày cần tra khung giờ.');
            return;
        }
        fetchKhungGioTheoNgay(dateFilter.value);
    });

    function fetchKhungGioTheoNgay(ngay) {   // gọi API để lấy chi tiết khung giờ của ngày được chọn
        fetch('/trang_admin/kiem_ke/khunggio-theongay?ngay=' + encodeURIComponent(ngay))
            .then(r => r.json())
            .then(json => { 
                if (json.khungGio) {
                    hienThiChiTietKhungGio(ngay, json.khungGio);
                } else {
                    hienThiChiTietKhungGio(ngay, []);
                }
            })
            .catch(e => {
                console.error(e);
                hienThiChiTietKhungGio(ngay, []);
            });
    }
</script>      