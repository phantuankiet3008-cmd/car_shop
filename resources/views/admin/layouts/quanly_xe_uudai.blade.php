

// Xử lý Xóa (Code chuẩn: Nhận 2 ID xe và uu_dai)
if (isset($_GET['action']) && $_GET['action'] == 'xoa' && isset($_GET['xe']) && isset($_GET['ud'])) {
    $ql->Xoa_Xe_UuDai($_GET['xe'], $_GET['ud']);
    header("Location: quanly_xe_uudai.php");
    exit;
}

$list = $ql->DanhSach_Xe_UuDai();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Ưu Đãi cho xe</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; }
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
        <a href="index_AD.php?key=uu_dai" style="margin-right: 15px; text-decoration: none; color: #333;">⬅  Chương Trình Ưu Đãi </a>
        <span style="color: gray;">|</span>
        <b style="margin-left: 10px;">Quản lý ưu đãi cho xe</b>
    </div>

    <h2>DANH SÁCH XE ĐANG ĐƯỢC ÁP DỤNG ƯU ĐÃI</h2>
    <a href="index_AD.php?key=Add_Uu_Dai" class="btn-add">+ Áp Dụng Ưu Đãi Cho Xe</a>

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
            <?php if ($list && $list->num_rows > 0): ?>
                <?php while ($row = $list->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_Xe']; ?></td>
                        
                        <td style="font-weight:bold;"><?php echo $row['Ten_Xe']; ?></td>
                        <td><?php echo $row['Ten_Uu_Dai']; ?></td>
                        
                        <td style="color:red; font-weight:bold;">
                            -<?php echo number_format($row['Gia_Tri']); ?>
                            <?php echo ($row['Loai'] == 'phan_tram') ? '%' : ' đ'; ?>
                        </td>
                        
                        <td><?php echo date("d/m/Y", strtotime($row['Ngay_Ket_Thuc'])); ?></td>
                        
                        <td>
                            <a href="index_AD.php?key=delete_Uu_Dai&action=xoa&xe=<?php echo $row['id_Xe'];?>&ud=<?php echo $row['id_Uu_Dai']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Bạn chắc chắn muốn gỡ bỏ ưu đãi này khỏi xe?');">Gỡ bỏ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; padding:20px; color: #666;">Chưa có xe nào được áp dụng ưu đãi.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>