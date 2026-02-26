<?php

namespace App\Services;

use Illuminate\Support\Facades\DB; 

class QL {
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $database = "car_shop";
    public $db;

    public function __construct(){
        $this->db = new \mysqli($this->hostname, $this->username, $this->password, $this->database);
        if($this->db->connect_error){
            die("Connection failed: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    // =========================
    // Tài khoản Admin
    // =========================
    function dang_nhap_ADM($TenDangNhap, $MatKhau) {

        $TenDangNhap = $this->db->real_escape_string($TenDangNhap);

        $sql = "SELECT * FROM admin WHERE UserName = '$TenDangNhap' LIMIT 1";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // ✔ So sánh bằng password_verify
            if (password_verify($MatKhau, $row['PassWord'])) {

                $_SESSION['admin_id']   = $row['id_Ad'];
                $_SESSION['admin_name'] = $row['UserName'];

                return true;
            }
        }
        return false;
    }

    function check_dang_nhap_ADM() {
        if (!isset($_SESSION['admin_id'])) {
            header("Location:index_AD.php");
            exit();
        }
    }

    function TKAD($username, $password, $trang_thai)
    {
        $username   = $this->db->real_escape_string($username);
        $trang_thai = (int)$trang_thai;
        $password   = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (UserName, PassWord, Trang_Thai)
                VALUES ('$username', '$password', $trang_thai)";
        return $this->db->query($sql);
    }
        // =========================
    // LOẠI XE
    // =========================

    // Lấy danh sách loại xe
    function DS_Loai_Xe() {
        $sql = "SELECT * FROM loai_xe ORDER BY id_Loai_Xe DESC";
        $result = $this->db->query($sql);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Thêm loại xe
    function Them_Loai_Xe( $ten_loai_xe,
            $slug,
            $mo_ta,
            $hinh_anh,
            $trang_thai) {
        $ten_loai_xe = $this->db->real_escape_string($ten_loai_xe);
        $slug        = $this->db->real_escape_string($slug);
        $mo_ta       = $this->db->real_escape_string($mo_ta);
        $hinh_anh    = $this->db->real_escape_string($hinh_anh);
        $trang_thai  = (int)$trang_thai;

        $sql = "INSERT INTO loai_xe (Ten_Loai_Xe, Slug, Mo_Ta, Hinh_Anh_Loai, Trang_Thai)
                VALUES ('$ten_loai_xe', '$slug', '$mo_ta', '$hinh_anh', $trang_thai)";
        return $this->db->query($sql);
    }

    // Lấy 1 loại xe theo ID
    function Lay_Loai_Xe_Theo_ID($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM loai_xe WHERE id_Loai_Xe = $id LIMIT 1";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    // Cập nhật loại xe
    function Cap_Nhat_Loai_Xe($id, $rten_loai, $rslug, $rmo_ta, $hinh_anh, $trang_thai) {
        $id          = (int)$id;
        $ten_loai_xe = $this->db->real_escape_string($rten_loai);
        $slug        = $this->db->real_escape_string($rslug);
        $hinh_anh    = $this->db->real_escape_string($hinh_anh);
        $trang_thai  = (int)$trang_thai;
        $mo_ta       = $this->db->real_escape_string($rmo_ta);

        $sql = "UPDATE loai_xe
                SET Ten_Loai_Xe = '$ten_loai_xe',
                    Slug = '$slug',
                    Hinh_Anh_Loai = '$hinh_anh',
                    Trang_Thai = $trang_thai,
                    Mo_Ta = '$mo_ta'
                WHERE id_Loai_Xe = $id";
        return $this->db->query($sql);
    }

    // Xóa loại xe
    function Xoa_Loai_Xe($id) {
        $id = (int)$id;
        $sql = "DELETE FROM loai_xe WHERE id_Loai_Xe = $id";
        return $this->db->query($sql);
    }
    // =========================
    // THƯƠNG HIỆU XE
    // =========================

    // Danh sách thương hiệu
    function DS_Thuong_Hieu_Xe() {
        $sql = "SELECT * FROM thuong_hieu_xe ORDER BY id_Thuong_Hieu DESC";
        $result = $this->db->query($sql);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Thêm thương hiệu
    function Them_Thuong_Hieu_Xe($ten_th,
            $ma_th,
            $hinh_anh,
            $trang_thai) {
        $ten_thuong_hieu = $this->db->real_escape_string($ten_th);
        $ma_thuong_hieu = $this->db->real_escape_string($ma_th);
        $hinh_anh        = $this->db->real_escape_string($hinh_anh);
        $trang_thai      = (int)$trang_thai;

        $sql = "INSERT INTO thuong_hieu_xe (Ten_Thuong_Hieu, Ma_Thuong_Hieu, Logo, Trang_Thai)
                VALUES ('$ten_thuong_hieu', '$ma_thuong_hieu', '$hinh_anh', $trang_thai)";
        return $this->db->query($sql);
    }

    // Lấy thương hiệu theo ID
    function Lay_Thuong_Hieu_Xe_Theo_ID($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM thuong_hieu_xe WHERE id_Thuong_Hieu = $id LIMIT 1";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    // Cập nhật thương hiệu
    function Cap_Nhat_Thuong_Hieu_Xe( $id,
        $ten_thuong_hieu,
        $ma_thuong_hieu,
        $hinh_anh,
        $trang_thai) {
        $id              = (int)$id;
        $ten_thuong_hieu = $this->db->real_escape_string($ten_thuong_hieu);
        $ma_thuong_hieu = $this->db->real_escape_string($ma_thuong_hieu);
        $hinh_anh        = $this->db->real_escape_string($hinh_anh);
        $trang_thai      = (int)$trang_thai;

        if ($hinh_anh != "") {
            $sql = "UPDATE thuong_hieu_xe
                    SET Ten_Thuong_Hieu = '$ten_thuong_hieu',
                        Ma_Thuong_Hieu = '$ma_thuong_hieu',
                        Logo = '$hinh_anh',
                        Trang_Thai = $trang_thai
                    WHERE id_Thuong_Hieu = $id";
        } else {
            $sql = "UPDATE thuong_hieu_xe
                    SET Ten_Thuong_Hieu = '$ten_thuong_hieu',
                        Ma_Thuong_Hieu = '$ma_thuong_hieu',
                        Trang_Thai = $trang_thai
                    WHERE id_Thuong_Hieu = $id";
        }

        return $this->db->query($sql);
    }

    // Xóa thương hiệu
    function Xoa_Thuong_Hieu_Xe($id) {
        $id = (int)$id;
        $sql = "DELETE FROM thuong_hieu_xe WHERE id_Thuong_Hieu = $id";
        return $this->db->query($sql);
    }
    // =========================
// SẢN PHẨM / XE
// =========================

// Lấy danh sách sản phẩm
function DanhSach_SanPham () {
    $sql = "
            SELECT
                sp.id_Xe,
                sp.Ten_Xe,
               
                sp.Anh_Dai_Dien,
                sp.Trang_Thai,
                lx.Ten_Loai_Xe,
                th.Ten_Thuong_Hieu
            FROM san_pham_xe sp
            LEFT JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            LEFT JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            ORDER BY sp.id_Xe DESC
        ";
        return $this->db->query($sql);
    }
function ten_sanpham(){
    $sql = "SELECT id_Xe, Ten_Xe FROM san_pham_xe ORDER BY id_Xe DESC";
    $result = $this->db->query($sql);

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Lấy sản phẩm theo ID
function SanPham_Theo_ID($id) {
    $id = (int)$id;
    $sql = "SELECT * FROM san_pham_xe WHERE id_Xe = $id LIMIT 1";
    return $this->db->query($sql)->fetch_assoc();
}
function List_MauXe(){
    $sql = "SELECT id_Mau, Ten_Mau, Ma_Mau FROM mau_xe ORDER BY id_Mau DESC";
    $result = $this->db->query($sql);

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
function Get_Mau_Theo_Xe($id_xe){
    $id_xe = (int)$id_xe;
    return $this->db->query("
        SELECT xm.id_Xe_Mau, xm.Gia, m.Ten_Mau, m.Ma_Mau
        FROM xe_mau xm
        JOIN mau_xe m ON xm.id_Mau = m.id_Mau
        WHERE xm.id_Xe = $id_xe
        ORDER BY xm.is_Default DESC
    ");
}

// Thêm sản phẩm
function Add_SanPham($ten_xe, $mo_ta, $anh_dai_dien, $anh_3d, $post, $files) {
    $ten_xe = $this->db->real_escape_string($ten_xe);
    $mo_ta = $this->db->real_escape_string($mo_ta);
    
    // Lấy ID từ mảng $post truyền vào
    $id_loai = (int)$post['loai_xe']; 
    $id_thuong_hieu = (int)$post['thuong_hieu'];

    // Upload ảnh chính
    $pathAnhDaiDien = public_path('upload/anh_dai_dien');

move_uploaded_file(
    $files['anh_dai_dien']['tmp_name'],
    $pathAnhDaiDien . '/' . $anh_dai_dien
);
    if (!empty($anh_3d)) {
    $pathAnh3D = public_path('upload/anh_3d');

    move_uploaded_file(
        $files['anh_3d']['tmp_name'],
        $pathAnh3D . '/' . $anh_3d
    );
}

    $sql = "INSERT INTO san_pham_xe (Ten_Xe, Mo_Ta, Anh_Dai_Dien, Anh_3d, id_Loai_Xe, id_Thuong_Hieu) 
VALUES ('$ten_xe', '$mo_ta', '$anh_dai_dien', '$anh_3d', $id_loai, $id_thuong_hieu)";

    
    if($this->db->query($sql)){
        $id_xe = $this->db->insert_id;

        if(isset($post['mau_xe'])){
            foreach($post['mau_xe'] as $i => $id_mau){
     $is_default = ($i === 0) ? 1 : 0;
    $gia_mau = (int) str_replace(['.', ','], '', $post['gia_mau'][$i]);

    $this->db->query("
        INSERT INTO xe_mau (id_Xe, id_Mau, is_Default, Gia) 
        VALUES ($id_xe, $id_mau, $is_default, $gia_mau)
    ");

                $id_xe_mau = $this->db->insert_id;

                // Xử lý upload mảng ảnh chi tiết
                if(!empty($files['anh_mau']['name'][$i])){
                    foreach($files['anh_mau']['name'][$i] as $k => $name){
                        if($files['anh_mau']['error'][$i][$k] == 0){
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $ten_anh_mau = time() . "_" . uniqid() . "." . $ext;
                            
                            $pathAnhXeMau = public_path('upload/anh_xe_mau');

                if (move_uploaded_file(
                    $files['anh_mau']['tmp_name'][$i][$k],
                     $pathAnhXeMau . '/' . $ten_anh_mau)) {    
                    $this->db->query("
                    INSERT INTO xe_mau_anh (id_Xe_Mau, Hinh_Anh_Xe_Mau)
                    VALUES ($id_xe_mau, '$ten_anh_mau')
                    ");
                        }

                        }
                    }
                }
            }
        }
        return true;
    }
    return false;
}
// Cập nhật sản phẩm
function Update_SanPham($id_xe, $post, $files) {

    $id_xe = (int)$id_xe;
    $ten_xe = $this->db->real_escape_string($post['ten_xe']);
    $mo_ta = $this->db->real_escape_string($post['mo_ta']);
    $id_loai = (int)$post['id_loai'];
    $id_thuong_hieu = (int)$post['id_thuong_hieu'];

    /* ================= CẬP NHẬT THÔNG TIN XE ================= */

    $sql = "UPDATE san_pham_xe SET 
                Ten_Xe = '$ten_xe',
                Mo_Ta = '$mo_ta',
                id_Loai_Xe = $id_loai,
                id_Thuong_Hieu = $id_thuong_hieu
            WHERE id_Xe = $id_xe";

    $result = $this->db->query($sql);
    if(!$result) return false;

    /* ================= CẬP NHẬT GIÁ THEO MÀU ================= */

   // === CẬP NHẬT GIÁ THEO MÀU (LUÔN CHẠY) ===
if(isset($post['gia_mau'])){
    foreach($post['gia_mau'] as $id_xe_mau => $gia){
        $gia = (int)str_replace(['.', ','], '', $gia);
        $this->db->query("UPDATE xe_mau SET Gia = $gia WHERE id_Xe_Mau = $id_xe_mau");
    }
}


    /* ================= CẬP NHẬT ẢNH ĐẠI DIỆN ================= */

    if (!empty($files['new_anh_dai_dien']['name'])) {

        // Lấy ảnh cũ
        $old = $this->db->query("SELECT Anh_Dai_Dien FROM san_pham_xe WHERE id_Xe = $id_xe")->fetch_assoc();
        if ($old && file_exists("../upload/anh_dai_dien/" . $old['Anh_Dai_Dien'])) {
            unlink("../upload/anh_dai_dien/" . $old['Anh_Dai_Dien']);
        }

        // Upload ảnh mới
        $new_name = time() . "_" . preg_replace('/\s+/', '_', $files['new_anh_dai_dien']['name']);
        $path = public_path('upload/anh_dai_dien');

if ($old && file_exists($path.'/'.$old['Anh_Dai_Dien'])) {
    unlink($path.'/'.$old['Anh_Dai_Dien']);
}

move_uploaded_file(
    $files['anh_dai_dien']['tmp_name'],
    $path.'/'.$new_name
);
    }

    return true;
}
function Get_ChiTietXe($id){
    $id = (int)$id;

    $sql = "
        SELECT 
            sp.*,
            lx.Ten_Loai_Xe,
            th.Ten_Thuong_Hieu
        FROM san_pham_xe sp
        LEFT JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
        LEFT JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
        WHERE sp.id_Xe = $id
        LIMIT 1
    ";

    $rs = $this->db->query($sql);

    if(!$rs){
        echo '<pre style="color:red">SQL ERROR: '.$this->db->error.'</pre>';
        return false;
    }

    if($rs->num_rows == 0){
        return false;
    }

    return $rs->fetch_assoc();
}
function Get_AnhTheoMau($id_xe) {
    $id_xe = (int)$id_xe;

    $sql = "
        SELECT 
            xm.id_Xe_Mau,
            xm.Gia,
            xm.is_Default,
            m.id_Mau,
            m.Ten_Mau,
            m.Ma_Mau,
            xma.Hinh_Anh_Xe_Mau
        FROM xe_mau xm
        JOIN mau_xe m ON xm.id_Mau = m.id_Mau
        LEFT JOIN xe_mau_anh xma ON xm.id_Xe_Mau = xma.id_Xe_Mau
        WHERE xm.id_Xe = $id_xe
        ORDER BY xm.is_Default DESC, xm.id_Xe_Mau
    ";

    return $this->db->query($sql);
}
// Xóa sản phẩm
public function Delete_SanPham($id_xe)
{
    $id_xe = (int)$id_xe;

    // ===== 1. Lấy thông tin xe =====
    $res = $this->db->query("
        SELECT Anh_Dai_Dien, Anh_3d 
        FROM san_pham_xe 
        WHERE id_Xe = $id_xe
    ");

    if (!$res || $res->num_rows == 0) {
        return false; // không có xe
    }

    $xe = $res->fetch_assoc();

    // ===== 2. Xóa ảnh đại diện & ảnh 3D =====
    $pathAnhDaiDien = public_path('upload/anh_dai_dien/' . $xe['Anh_Dai_Dien']);
    if (!empty($xe['Anh_Dai_Dien']) && file_exists($pathAnhDaiDien)) {
        unlink($pathAnhDaiDien);
    }

    $pathAnh3D = public_path('upload/anh_3d/' . $xe['Anh_3d']);
    if (!empty($xe['Anh_3d']) && file_exists($pathAnh3D)) {
        unlink($pathAnh3D);
    }

    // ===== 3. Xóa ảnh xe màu =====
    $res_anh = $this->db->query("
        SELECT xma.Hinh_Anh_Xe_Mau
        FROM xe_mau_anh xma
        JOIN xe_mau xm ON xma.id_Xe_Mau = xm.id_Xe_Mau
        WHERE xm.id_Xe = $id_xe
    ");

    if ($res_anh) {
        while ($anh = $res_anh->fetch_assoc()) {
            $pathAnhXeMau = public_path('upload/anh_xe_mau/' . $anh['Hinh_Anh_Xe_Mau']);
            if (!empty($anh['Hinh_Anh_Xe_Mau']) && file_exists($pathAnhXeMau)) {
                unlink($pathAnhXeMau);
            }
        }
    }

    // ===== 4. Xóa DB (ON DELETE CASCADE xử lý bảng con) =====
    return $this->db->query("
        DELETE FROM san_pham_xe 
        WHERE id_Xe = $id_xe
    ");
}


// =========================
// ẢNH XE MÀU
// =========================

// Lấy danh sách màu theo xe
function DanhSach_Xe_Mau($id_xe) {
    $id_xe = (int)$id_xe;
    $sql = "SELECT * FROM xe_mau WHERE id_Xe = $id_xe";
    return $this->db->query($sql);
}

// Thêm màu xe
function Add_Xe_Mau($id_xe, $ten_mau, $is_default = 0) {
    $id_xe = (int)$id_xe;
    $ten_mau = $this->db->real_escape_string($ten_mau);
    $is_default = (int)$is_default;

    $sql = "INSERT INTO xe_mau (id_Xe, Ten_Mau, is_Default)
            VALUES ($id_xe, '$ten_mau', $is_default)";

    return $this->db->query($sql);
}

// Xóa màu xe
function Delete_Xe_Mau($id_xe_mau) {
    $id_xe_mau = (int)$id_xe_mau;
    $sql = "DELETE FROM xe_mau WHERE id_Xe_Mau = $id_xe_mau";
    return $this->db->query($sql);
}
// =========================
// ĐƠN HÀNG
// =========================

// Danh sách đơn hàng
function DanhSach_Don_Hang() {
    $sql = "SELECT * FROM don_hang ORDER BY id_Don_Hang DESC";
    return $this->db->query($sql);
}

// Chi tiết đơn hàng
function ChiTiet_Don_Hang($id) {
    $id = (int)$id;
    $sql = "SELECT * FROM don_hang WHERE id_Don_Hang = $id LIMIT 1";
    return $this->db->query($sql)->fetch_assoc();
}

// Cập nhật trạng thái đơn hàng
function Update_TrangThai_DonHang($id, $trang_thai) {
    $id = (int)$id;
    $trang_thai = (int)$trang_thai;

    $sql = "UPDATE don_hang SET Trang_Thai = $trang_thai WHERE id_Don_Hang = $id";
    return $this->db->query($sql);
}

// Xóa đơn hàng
function Delete_Don_Hang($id) {
    $id = (int)$id;
    $sql = "DELETE FROM don_hang WHERE id_Don_Hang = $id";
    return $this->db->query($sql);
}
// =========================
// ƯU ĐÃI
// =========================

// Danh sách ưu đãi
function DanhSach_Uu_Dai() {
    $sql = "SELECT * FROM uu_dai ORDER BY id_Uu_Dai DESC";
    return $this->db->query($sql);
}

// Thêm ưu đãi
function Add_Uu_Dai($Ten_Uu_Dai,
        $Loai,
        $Gia_Tri,
        $Ngay_Bat_Dau,
        $Ngay_Ket_Thuc,
        $Trang_Thai ,) {

    $ten = $this->db->real_escape_string($Ten_Uu_Dai);
    $loai = $this->db->real_escape_string($Loai);
    $gia_tri = (int)$Gia_Tri;
    $ngay_bd = $this->db->real_escape_string($Ngay_Bat_Dau);
    $ngay_kt = $this->db->real_escape_string($Ngay_Ket_Thuc);
    $trang_thai = (int)$Trang_Thai;

   $sql = "INSERT INTO uu_dai 
(Ten_Uu_Dai, Loai, Gia_Tri, Ngay_Bat_Dau, Ngay_Ket_Thuc, Trang_Thai)
VALUES 
('$ten', '$loai', $gia_tri, '$ngay_bd', '$ngay_kt', $trang_thai)";

    return $this->db->query($sql);
}

// Sửa ưu đãi
function Update_Uu_Dai($id, $ten, $gia_tri, $mo_ta, $trang_thai) {

    $id = (int)$id;
    $ten = $this->db->real_escape_string($ten);
    $mo_ta = $this->db->real_escape_string($mo_ta);
    $gia_tri = (int)$gia_tri;
    $trang_thai = (int)$trang_thai;

    $sql = "UPDATE uu_dai SET
            Ten_Uu_Dai = '$ten',
            Gia_Tri = $gia_tri,
            Mo_Ta = '$mo_ta',
            Trang_Thai = $trang_thai
            WHERE id_Uu_Dai = $id";

    return $this->db->query($sql);
}

// Xóa ưu đãi
function Delete_Uu_Dai($id)
{
    $id = (int)$id;

    // 1️⃣ Kiểm tra xem có xe đang dùng ưu đãi này không
    $checkSql = "SELECT COUNT(*) as total 
                 FROM xe_uu_dai 
                 WHERE id_Uu_Dai = $id";

    $result = $this->db->query($checkSql);
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        // Có xe đang dùng → không cho xoá
        return [
            'status' => false,
            'message' => 'Không thể xoá! Ưu đãi này đang được áp dụng cho xe.'
        ];
    }

    // 2️⃣ Nếu không có xe nào → cho xoá
    $deleteSql = "DELETE FROM uu_dai WHERE id_Uu_Dai = $id";
    $this->db->query($deleteSql);

    return [
        'status' => true,
        'message' => 'Xoá ưu đãi thành công.'
    ];
}

// =========================
// XE ƯU ĐÃI
// =========================

// Danh sách xe trong ưu đãi
 function DanhSach_Xe_Uu_Dai(){
        $sql = "SELECT xu.id_Xe, xu.id_Uu_Dai, sp.Ten_Xe, ud.Ten_Uu_Dai, ud.Gia_Tri, ud.Loai, ud.Ngay_Ket_Thuc
                FROM xe_uu_dai xu
                JOIN san_pham_xe sp ON xu.id_Xe = sp.id_Xe
                JOIN uu_dai ud ON xu.id_Uu_Dai = ud.id_Uu_Dai
                ORDER BY xu.id_Xe DESC";
        return $this->db->query($sql);
    }

// Thêm xe vào ưu đãi
function Add_Xe_Uu_Dai($id_xe, $id_uudai) {
    $id_xe = (int)$id_xe;
    $id_uudai = (int)$id_uudai;

    $sql = "INSERT INTO xe_uu_dai (id_Xe, id_Uu_Dai)
            VALUES ($id_xe, $id_uudai)";
    return $this->db->query($sql);
}

// Xóa xe khỏi ưu đãi
function Delete_Xe_Uu_Dai($id_xe, $id_uudai) {
    $id_xe = (int)$id_xe;
    $id_uudai = (int)$id_uudai;
    $sql = "DELETE FROM xe_uu_dai WHERE id_Xe = $id_xe AND id_Uu_Dai = $id_uudai";
    return $this->db->query($sql);
}
// =========================
// LÁI THỬ
// =========================

// Danh sách lái thử
function DanhSach_Lai_Thu() {
    $sql = "SELECT * FROM dat_lich_lai_thu ORDER BY id_Lai_Thu DESC";
    return $this->db->query($sql);
}

// Cập nhật trạng thái lái thử
function Update_Lai_Thu($id, $trang_thai) {
    $id = (int)$id;
    $trang_thai = (int)$trang_thai;

    $sql = "UPDATE dat_lich_lai_thu SET Trang_Thai = $trang_thai WHERE id_Lai_Thu = $id";
    return $this->db->query($sql);
}
// =========================
// BẢO DƯỠNG
// =========================

function DanhSach_Bao_Duong() {
    $sql = "SELECT * FROM dat_lich_bao_duong ORDER BY id_Bao_Duong DESC";
    return $this->db->query($sql);
}

// =========================
// LẤY XE
// =========================

function DanhSach_Lay_Xe() {
    $sql = "SELECT * FROM dat_lich_lay_xe ORDER BY id_Lay_Xe DESC";
    return $this->db->query($sql);
}

// =========================
// KHÁCH HÀNG
// =========================

// Danh sách khách hàng
function DanhSach_Khach_Hang() {

    $sql = "SELECT * FROM khach_hang ORDER BY id_Khach_Hang DESC";
    $result = $this->db->query($sql);

    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;   // ✅ trả về array
}


// Lấy 1 khách hàng theo ID
function ChiTiet_Khach_Hang($id) {
    $id = (int)$id;
    $sql = "SELECT * FROM khach_hang WHERE id_Khach_Hang = $id LIMIT 1";
    return $this->db->query($sql)->fetch_assoc();
}

// Thêm khách hàng
function Add_Khach_Hang($ten, $email, $sdt, $dia_chi, $mat_khau, $trang_thai) {

    $ten = $this->db->real_escape_string($ten);
    $email = $this->db->real_escape_string($email);
    $sdt = $this->db->real_escape_string($sdt);
    $diachi = $this->db->real_escape_string($dia_chi);
    $matkhau = password_hash($mat_khau, PASSWORD_DEFAULT);
    $trangthai = (int)$trang_thai;

    $sql = "INSERT INTO khach_hang (Ho_Ten, Email,So_Dien_Thoai,  Mat_Khau, Dia_Chi, Trang_Thai)
            VALUES ('$ten', '$email', '$sdt', '$matkhau', '$diachi', $trangthai)";
    return $this->db->query($sql);
}

// Cập nhật khách hàng
function Update_Khach_Hang( $id,
        $Ho_Ten,
        $Email,
        $So_Dien_Thoai,
        $Mat_Khau,
        $Dia_Chi,
        $Trang_Thai  ) {

    $id        = (int)$id;
    $ten       = $this->db->real_escape_string($Ho_Ten);
    $sdt       = $this->db->real_escape_string($So_Dien_Thoai);
    $email     = $this->db->real_escape_string($Email);
    $dia_chi   = $this->db->real_escape_string($Dia_Chi);
    $mat_khau  = password_hash($Mat_Khau, PASSWORD_DEFAULT);
    $trang_thai = (int)$Trang_Thai;

    $sql = "UPDATE khach_hang SET
            Ho_Ten = '$ten',
            So_Dien_Thoai = '$sdt',
            Email = '$email',
            Dia_Chi = '$dia_chi',
            Mat_Khau = '$mat_khau',
            Trang_Thai = $trang_thai
            WHERE id_Khach_Hang = $id";

    return $this->db->query($sql);
}

// Xóa khách hàng
function Delete_Khach_Hang($id) {
    $id = (int)$id;
    $sql = "DELETE FROM khach_hang WHERE id_Khach_Hang = $id";
    return $this->db->query($sql);
}

// Tìm kiếm khách hàng theo tên / sdt
function TimKiem_Khach_Hang($keyword) {
    $keyword = $this->db->real_escape_string($keyword);

    $sql = "SELECT * FROM khach_hang 
            WHERE Ho_Ten LIKE '%$keyword%'
               OR So_Dien_Thoai LIKE '%$keyword%'
               OR Email LIKE '%$keyword%'
            ORDER BY id_Khach_Hang DESC";

    $result = $this->db->query($sql);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;   // ✅ trả về array

}





}