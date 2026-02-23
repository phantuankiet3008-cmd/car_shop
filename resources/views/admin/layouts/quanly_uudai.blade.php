

// Xử lý Xóa (SỬA: Nhận 2 ID để xóa chính xác)
if (isset($_GET['action']) && $_GET['action'] == 'xoa' && isset($_GET['xe']) && isset($_GET['ud'])) {
    $ql->Xoa_Xe_UuDai($_GET['xe'], $_GET['ud']);
    header("Location: index_AD.php?key=chitiet_uu_dai");
    exit;
}

$list = $ql->DanhSach_UuDai();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý  Ưu Đãi</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #17a2b8; color: white; }
        .btn-add { background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; font-weight: bold; display:inline-block; margin-bottom: 15px;}
        .btn-delete { background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px;}
    </style>
</head>
<body>
    <div style="margin-bottom: 20px;">
        <a href="index_AD.php?key=chitiet_uu_dai" style="margin-right: 15px;">⬅ Quản lý Chương Trình xe ưu Đãi</a>
        <b>Quản lý Xe Áp Dụng</b>
    </div>

    <h2>DANH SÁCH  ƯU ĐÃI</h2>
    <a href="index_AD.php?key=Add_Chi_Tiet_Uu_Dai" class="btn-add">+ Thêm Ưu Đãi </a>
    <table>
        <thead>
            <tr>
                <th>Mã Xe</th>
                <th>Tên Xe</th>
                <th>Chương Trình Ưu Đãi</th>
                <th>Mức Giảm</th>
                <th>Hạn Dùng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($list && $list->num_rows > 0): ?>
                <?php while ($row = $list->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_Uu_Dai']; ?></td>
                        
                        <td><?php echo $row['Ten_Uu_Dai']; ?></td>
                        <td style="color:red; font-weight:bold;">
                            -<?php echo number_format($row['Gia_Tri']); ?>
                            <?php echo ($row['Loai'] == 'phan_tram') ? '%' : ' đ'; ?>
                        </td>
                        <td><?php echo date("d/m/Y", strtotime($row['Ngay_Bat_Dau'])); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($row['Ngay_Ket_Thuc'])); ?></td>
                        <td>
                            <a href="index_AD.php?key=delete_Uu_Dai&action=xoa&ud=<?php echo $row['id_Uu_Dai']; ?>"
                       class="btn-delete"
                       onclick="return confirm('Bạn chắc chắn muốn gỡ bỏ ưu đãi này?');">
                        Gỡ bỏ
                    </a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; padding:20px;">Chưa có xe nào được áp dụng ưu đãi.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>