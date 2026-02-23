

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Ưu Đãi cho xe</title>
    <style>
       
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #17a2b8; color: white; }
        .btn-add { background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; font-weight: bold; display:inline-block; margin-bottom: 15px; border-radius: 4px;}
        .btn-delete { background-color: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block;}
        .btn-delete:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div style="margin-bottom: 20px;">
        <a href="{{ url('/trang_admin/uu_dai') }}" style="margin-right: 15px; text-decoration: none; color: #333;">⬅  Chương Trình Ưu Đãi </a>
        <span style="color: gray;">|</span>
        <b style="margin-left: 10px;">Quản lý ưu đãi cho xe</b>
    </div>

    <h2>DANH SÁCH XE ĐANG ĐƯỢC ÁP DỤNG ƯU ĐÃI</h2>
    <a href="{{ url('/trang_admin/xe_uu_dai/them') }}" class="btn-add">+ Áp Dụng Ưu Đãi Cho Xe</a>

    <table>
        <thead>
            <tr>
                <th>Mã Xe</th> <th>Tên Xe</th>
                <th>Chương Trình Ưu Đãi</th>
                <th>Mức Giảm</th>
                <th>Hạn Dùng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
       <tbody>
    @forelse($data['danh_sach'] as $row)
        <tr>
            <td>{{ $row['id_Xe'] }}</td>

            <td style="font-weight:bold;">
                {{ $row['Ten_Xe'] }}
            </td>

            <td>{{ $row['Ten_Uu_Dai'] }}</td>

            <td style="color:red; font-weight:bold;">
                -{{ number_format($row['Gia_Tri']) }}
                {{ $row['Loai'] == 'phan_tram' ? '%' : ' đ' }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse($row['Ngay_Ket_Thuc'])->format('d/m/Y') }}
            </td>

            <td>
                <a href="{{ url('/trang_admin/uu_dai_xe/xoa/'.$row['id_Xe'].'/'.$row['id_Uu_Dai']) }}"
                   class="btn-delete"
                   onclick="return confirm('Bạn chắc chắn muốn gỡ bỏ ưu đãi này khỏi xe?');">
                    Gỡ bỏ
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align:center; padding:20px; color:#666;">
                Chưa có xe nào được áp dụng ưu đãi.
            </td>
        </tr>
    @endforelse
</tbody>

    </table>
</body>
</html>