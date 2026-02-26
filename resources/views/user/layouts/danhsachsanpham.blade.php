
<?php

require_once(__DIR__ . '/../api/user.php');

$productApi = new Product();

$search = trim($_GET['search'] ?? '');
$MaLoai = (int)($_GET['MaLoai'] ?? 0);
$MaThuongHieu = (int)($_GET['MaThuongHieu'] ?? 0);

/* ==== LẤY DANH SÁCH XE ==== */
if ($MaLoai > 0 || $MaThuongHieu > 0) {
    $result = $productApi->locSanPham($MaLoai, $MaThuongHieu);
} else {
    $result = $productApi->getAllSanPham();
}
    
?>

<div class="product-list">
<?php if (!empty($result)): ?>
    <?php foreach ($result as $sp): ?>
        <div class="product-card">
            <img src="../upload/anh_dai_dien/<?= htmlspecialchars($sp['Anh_Dai_Dien']) ?>">
            <h3><?= htmlspecialchars($sp['Ten_Xe']) ?></h3>
            <small><?= htmlspecialchars($sp['Ten_Thuong_Hieu'] ?? 'N/A') ?> • <?= htmlspecialchars($sp['Ten_Loai_Xe'] ?? 'N/A') ?></small>
            <p><?= number_format($sp['Gia_Mau']) ?> ₫</p>
            <a href="index.php?key=chiTietSanPham&id=<?= $sp['id_Xe'] ?>" class="btn-gold">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center">Không có sản phẩm</p>
<?php endif; ?>
</div>
