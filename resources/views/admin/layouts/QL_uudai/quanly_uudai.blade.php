<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Ưu Đãi</title>
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
    <a href="{{ url('/trang_admin/xe_uu_dai') }}">
        ⬅ Quản lý Chương Trình xe ưu Đãi
    </a>
    <b>Quản lý Xe Áp Dụng</b>
</div>

<h2>DANH SÁCH ƯU ĐÃI</h2>

<a href="{{ url('/trang_admin/uu_dai/them') }}"
   class="btn-add">
   + Thêm Ưu Đãi
</a>

<table>
    <thead>
        <tr>
            <th>Mã Ưu Đãi</th>
            <th>Tên Ưu Đãi</th>
            <th>Mức Giảm</th>
            <th>Ngày Bắt Đầu</th>
            <th>Ngày Kết Thúc</th>
            <th>Hành Động</th>
        </tr>
    </thead>

    <tbody>
       @forelse($data['danh_sach'] as $row)

            <tr>
                <td>{{ $row['id_Uu_Dai'] }}</td>

                <td>{{ $row['Ten_Uu_Dai'] }}</td>

                <td style="color:red; font-weight:bold;">
                    -{{ number_format($row['Gia_Tri']) }}
                    {{ $row['Loai'] == 'phan_tram' ? '%' : ' đ' }}
                </td>

                <td>{{ \Carbon\Carbon::parse($row['Ngay_Bat_Dau'])->format('d/m/Y') }}</td>

                <td>{{ \Carbon\Carbon::parse($row['Ngay_Ket_Thuc'])->format('d/m/Y') }}</td>

                <td>
                    <a href="{{ url('/trang_admin/uu_dai/xoa/'.$row['id_Uu_Dai']) }}"
                       class="btn-delete"
                       onclick="return confirm('Bạn chắc chắn muốn gỡ bỏ ưu đãi này?');">
                        Gỡ bỏ
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:20px;">
                    Chưa có ưu đãi nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
