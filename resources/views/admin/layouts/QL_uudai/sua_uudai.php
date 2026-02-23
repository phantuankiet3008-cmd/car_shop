

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Ưu Đãi</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; margin-top: 15px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #ffc107; color: black; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 20px; font-weight: bold; }
        .btn-back { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #666; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>SỬA ƯU ĐÃI: #<?php echo $row['id_Uu_Dai']; ?></h2>
        <form method="POST">
            <label>Tên Chương Trình:</label>
            <input type="text" name="ten" value="<?php echo $row['Ten_Uu_Dai']; ?>" required>

            <label>Loại Giảm Giá:</label>
            <select name="loai">
                <option value="phan_tram" <?php if($row['Loai']=='phan_tram') echo 'selected'; ?>>Giảm theo %</option>
                <option value="tien_mat" <?php if($row['Loai']=='tien_mat') echo 'selected'; ?>>Giảm tiền mặt</option>
            </select>

            <label>Giá Trị:</label>
            <input type="number" name="gia_tri" value="<?php echo $row['Gia_Tri']; ?>" required>

            <label>Ngày Bắt Đầu:</label>
            <input type="date" name="ngay_bd" value="<?php echo $row['Ngay_Bat_Dau']; ?>" required>

            <label>Ngày Kết Thúc:</label>
            <input type="date" name="ngay_kt" value="<?php echo $row['Ngay_Ket_Thuc']; ?>" required>

            <label>Trạng Thái:</label>
            <select name="trang_thai">
                <option value="1" <?php if($row['Trang_Thai']==1) echo 'selected'; ?>>Đang chạy</option>
                <option value="0" <?php if($row['Trang_Thai']==0) echo 'selected'; ?>>Tạm dừng</option>
            </select>

            <button type="submit" name="btn_update" class="btn-submit">CẬP NHẬT</button>
            <a href="quanly_uudai.php" class="btn-back">Hủy bỏ</a>
        </form>
    </div>
</body>
</html>