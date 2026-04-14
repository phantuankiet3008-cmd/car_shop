<?php

namespace App\Services;

use Illuminate\Support\Facades\DB; 


// ============================
// 1. KẾT NỐI DATABASE VÀ CLASS QL
// ============================
class QL {
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $database = "car_shop";
    public $db;
protected $cloudinary;
    public function __construct(){
        $this->db = new \mysqli($this->hostname, $this->username, $this->password, $this->database,3308);
        if($this->db->connect_error){
            die("Connection failed: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    
    $this->cloudinary = new CloudinaryService();
    }

    // =========================
    // Tài khoản Admin
    // =========================
    function DangNhap($username, $password)
{
    $stmt = $this->db->prepare("
        SELECT id_Ad, UserName, PassWord, role_id 
        FROM admin 
        WHERE UserName = ? AND Trang_Thai = 1
        LIMIT 1
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        return false;
    }

    $row = $result->fetch_assoc();

    if (password_verify($password, $row['PassWord'])) {
        return [
            'id_Ad' => $row['id_Ad'],
            'UserName' => $row['UserName'],
            'role_id' => $row['role_id']
        ];
    }

    return false;
}

function TKAD($username, $password, $role_id, $trang_thai = 1)
{
    $username   = $this->db->real_escape_string($username);
    $role_id    = (int)$role_id;
    $trang_thai = (int)$trang_thai;
    $password   = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (UserName, PassWord, role_id, Trang_Thai)
            VALUES ('$username', '$password', '$role_id', '$trang_thai')";

    return $this->db->query($sql);
}
        // =========================
    // LOẠI XE
    // =========================

    // Lấy danh sách loại xe
    function DS_Loai_Xe() {
        $sql = "SELECT * FROM loai_xe ORDER BY id_Loai_xe DESC";
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
    function Them_Loai_Xe($ten_loai_xe, $slug, $mo_ta, $trang_thai, $files) {
    $ten_loai_xe = $this->db->real_escape_string($ten_loai_xe);
    $slug        = $this->db->real_escape_string($slug);
    $mo_ta       = $this->db->real_escape_string($mo_ta);
    $trang_thai  = (int)$trang_thai;

    // Tự xử lý upload ảnh nếu có file
    $hinh_anh = "";
    if (!empty($files['hinh_anh']['tmp_name'])) {
        $hinh_anh = $this->cloudinary->uploadImage($files['hinh_anh'], 'loai_xe');
    }

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
    function Cap_Nhat_Loai_Xe($id, $ten_loai, $slug, $mo_ta, $trang_thai, $files) {
    $id          = (int)$id;
    $ten_loai_xe = $this->db->real_escape_string($ten_loai);
    $slug        = $this->db->real_escape_string($slug);
    $trang_thai  = (int)$trang_thai;
    $mo_ta       = $this->db->real_escape_string($mo_ta);

    // Lấy dữ liệu cũ để xem có ảnh cũ không
    $old_data = $this->Lay_Loai_Xe_Theo_ID($id);
    $hinh_anh = $old_data['Hinh_Anh_Loai'] ?? "";

    // Nếu người dùng có chọn file mới
    if (!empty($files['hinh_anh']['name'])) {
        // Xóa ảnh cũ trên Cloudinary
        if (!empty($hinh_anh)) {
            $this->cloudinary->deleteImage($hinh_anh);
        }
        // Upload ảnh mới
        $hinh_anh = $this->cloudinary->uploadImage($files['hinh_anh'], 'loai_xe');
    }

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
    $data = $this->Lay_Loai_Xe_Theo_ID($id);
    
    if ($data && !empty($data['Hinh_Anh_Loai'])) {
        $this->cloudinary->deleteImage($data['Hinh_Anh_Loai']);
    }

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
    function Them_Thuong_Hieu_Xe($ten_th, $ma_th, $trang_thai, $files) {
    $ten_thuong_hieu = $this->db->real_escape_string($ten_th);
    $ma_thuong_hieu = $this->db->real_escape_string($ma_th);
    $trang_thai      = (int)$trang_thai;

    $hinh_anh = "";
    if (!empty($files['hinh_anh']['tmp_name'])) {
        $hinh_anh = $this->cloudinary->uploadImage($files['hinh_anh'], 'anh_logo');
    }

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
    function Cap_Nhat_Thuong_Hieu_Xe_V2($id, $ten_th, $ma_th, $trang_thai, $files) {
    $id              = (int)$id;
    $ten_thuong_hieu = $this->db->real_escape_string($ten_th);
    $ma_thuong_hieu  = $this->db->real_escape_string($ma_th);
    $trang_thai      = (int)$trang_thai;

    // Lấy thông tin cũ để xử lý ảnh
    $old = $this->Lay_Thuong_Hieu_Xe_Theo_ID($id);
    $hinh_anh = $old['Logo'] ?? "";

    if (!empty($files['hinh_anh']['name'])) {
        // Xóa ảnh cũ nếu tồn tại
        if (!empty($hinh_anh)) {
            $this->cloudinary->deleteImage($hinh_anh);
        }
        // Upload ảnh mới
        $hinh_anh = $this->cloudinary->uploadImage($files['hinh_anh'], 'anh_logo');
    }

    $sql = "UPDATE thuong_hieu_xe
            SET Ten_Thuong_Hieu = '$ten_thuong_hieu',
                Ma_Thuong_Hieu = '$ma_thuong_hieu',
                Logo = '$hinh_anh',
                Trang_Thai = $trang_thai
            WHERE id_Thuong_Hieu = $id";
    return $this->db->query($sql);
}

    // Xóa thương hiệu
    function Xoa_Thuong_Hieu_Xe($id) {
    $id = (int)$id;
    $data = $this->Lay_Thuong_Hieu_Xe_Theo_ID($id);

    if ($data && !empty($data['Logo'])) {
        $this->cloudinary->deleteImage($data['Logo']);
    }

    $sql = "DELETE FROM thuong_hieu_xe WHERE id_Thuong_Hieu = $id";
    return $this->db->query($sql);
}
    // =========================
// SẢN PHẨM / XE
// =========================

// Lấy danh sách sản phẩm
function DanhSach_SanPham($filters = []) {
    $where = " WHERE 1=1 "; // Điều kiện mặc định luôn đúng

    // Lọc theo tên (Tìm kiếm gần đúng)
    if (!empty($filters['ten'])) {
        $ten = addslashes($filters['ten']);
        $where .= " AND sp.Ten_Xe LIKE '%$ten%' ";
    }

    // Lọc theo loại xe
    if (!empty($filters['id_loai'])) {
        $id_loai = (int)$filters['id_loai'];
        $where .= " AND sp.id_Loai_Xe = $id_loai ";
    }

    // Lọc theo thương hiệu
    if (!empty($filters['id_thương_hieu'])) {
        $id_th = (int)$filters['id_thương_hieu'];
        $where .= " AND sp.id_Thuong_Hieu = $id_th ";
    }

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
        $where
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
        SELECT xm.id_Xe_Mau, xm.Gia,xm.So_Luong, m.Ten_Mau, m.Ma_Mau
        FROM xe_mau xm
        JOIN mau_xe m ON xm.id_Mau = m.id_Mau
        WHERE xm.id_Xe = $id_xe
        ORDER BY xm.is_Default DESC
    ");
}

// Thêm sản phẩm
public function Add_SanPham($ten_xe, $mo_ta, $post) {
    // 1. Lấy URLs từ các input ẩn đã được JS điền vào
    $anh_dai_dien = $this->db->real_escape_string($post['anh_dai_dien_url'] ?? '');
    $anh_3d       = $this->db->real_escape_string($post['anh_3d_url'] ?? '');
    
    $ten_xe = $this->db->real_escape_string($ten_xe);
    $mo_ta  = $this->db->real_escape_string($mo_ta);
    $id_loai = (int)$post['loai_xe']; 
    $id_thuong_hieu = (int)$post['thuong_hieu'];

    $sql = "INSERT INTO san_pham_xe (Ten_Xe, Mo_Ta, Anh_Dai_Dien, Anh_3d, id_Loai_Xe, id_Thuong_Hieu) 
            VALUES ('$ten_xe', '$mo_ta', '$anh_dai_dien', '$anh_3d', $id_loai, $id_thuong_hieu)";

    if($this->db->query($sql)){
        $id_xe = $this->db->insert_id;

        if(isset($post['mau_xe'])){
            foreach($post['mau_xe'] as $i => $mau_value){
                $id_mau_final = 0;
                if (strpos($mau_value, 'NEW|') === 0) {
                    $parts = explode('|', $mau_value);
                    $ten_m = $this->db->real_escape_string($parts[1]);
                    $ma_m  = $this->db->real_escape_string($parts[2]);
                    $this->db->query("INSERT INTO mau_xe (Ten_Mau, Ma_Mau) VALUES ('$ten_m', '$ma_m')");
                    $id_mau_final = $this->db->insert_id;
                } else {
                    $id_mau_final = (int)$mau_value;
                }

                $gia_mau = (int) str_replace(['.', ','], '', $post['gia_mau'][$i]);
                $so_luong = (int)$post['so_luong'][$i];
                $is_default = ($i === 0) ? 1 : 0;

                $this->db->query("INSERT INTO xe_mau (id_Xe, id_Mau, is_Default, Gia, So_Luong) 
                                 VALUES ($id_xe, $id_mau_final, $is_default, $gia_mau, $so_luong)");
                $id_xe_mau = $this->db->insert_id;

                // 2. Lưu mảng ảnh Album (Tốc độ ánh sáng vì chỉ là chuỗi)
                if(isset($post['anh_mau_urls'][$i])){
                    foreach($post['anh_mau_urls'][$i] as $link_anh){
                        $link_anh_esc = $this->db->real_escape_string($link_anh);
                        $this->db->query("INSERT INTO xe_mau_anh (id_Xe_Mau, Hinh_Anh_Xe_Mau) VALUES ($id_xe_mau, '$link_anh_esc')");
                    }
                }
            }
        }
        return true;
    }
    return false;
}
// Cập nhật sản phẩm
// Cập nhật hàm Update_SanPham trong class QL
public function Update_SanPham($id_xe, $post) {
    $id_xe = (int)$id_xe;

    $ten_xe = $this->db->real_escape_string($post['ten_xe']);
    $mo_ta = $this->db->real_escape_string($post['mo_ta']);
    $id_loai = (int)$post['id_loai'];
    $id_thuong_hieu = (int)$post['id_thuong_hieu'];

    // 🔥 TRANSACTION (QUAN TRỌNG)
    $this->db->begin_transaction();

    try {

        // 1. UPDATE THÔNG TIN XE
        $this->db->query("UPDATE san_pham_xe SET 
            Ten_Xe='$ten_xe', 
            Mo_Ta='$mo_ta', 
            id_Loai_Xe=$id_loai, 
            id_Thuong_Hieu=$id_thuong_hieu 
            WHERE id_Xe=$id_xe");

        // 2. UPDATE ẢNH (nếu có)
        if(!empty($post['new_anh_dai_dien_url'])) {
            $url = $this->db->real_escape_string($post['new_anh_dai_dien_url']);
            $this->db->query("UPDATE san_pham_xe SET Anh_Dai_Dien='$url' WHERE id_Xe=$id_xe");
        }

        if(!empty($post['new_anh_3d_url'])) {
            $url = $this->db->real_escape_string($post['new_anh_3d_url']);
            $this->db->query("UPDATE san_pham_xe SET Anh_3d='$url' WHERE id_Xe=$id_xe");
        }

        // 3. 🔥 XÓA MÀU (ĐÚNG VỊ TRÍ)
        $deletedColorIds = [];
        if (!empty($post['delete_color_ids'])) {
            $deletedColorIds = array_map('intval', explode(',', $post['delete_color_ids']));

            foreach ($deletedColorIds as $id_xm) {
                if ($id_xm > 0) {
                    // Xóa ảnh trước
                    $this->db->query("DELETE FROM xe_mau_anh WHERE id_Xe_Mau = $id_xm");

                    // Xóa màu
                    $this->db->query("DELETE FROM xe_mau WHERE id_Xe_Mau = $id_xm");
                }
            }
        }

        // 4. XÓA ẢNH RIÊNG LẺ
        if(!empty($post['delete_anh_ids'])) {
            foreach($post['delete_anh_ids'] as $id_anh) {
                if(!empty($id_anh)) {
                    $this->db->query("DELETE FROM xe_mau_anh WHERE id_Xe_Mau_Anh=".(int)$id_anh);
                }
            }
        }

        // 5. UPDATE MÀU CŨ + THÊM ẢNH
        if(isset($post['gia_mau'])) {
            foreach($post['gia_mau'] as $id_xm => $gia) {

                $id_xm = (int)$id_xm;

                // ❌ BỎ QUA nếu đã bị xóa
                if (in_array($id_xm, $deletedColorIds)) continue;

                $gia_clean = (int)str_replace(['.', ','], '', $gia);
                $sl = (int)$post['so_luong'][$id_xm];

                $this->db->query("UPDATE xe_mau SET So_Luong=$sl, Gia=$gia_clean WHERE id_Xe_Mau=$id_xm");

                // thêm ảnh mới vào màu cũ
                if(isset($post['more_anh_mau_urls'][$id_xm])) {
                    foreach($post['more_anh_mau_urls'][$id_xm] as $u) {
                        $u_e = $this->db->real_escape_string($u);
                        $this->db->query("INSERT INTO xe_mau_anh (id_Xe_Mau, Hinh_Anh_Xe_Mau) VALUES ($id_xm, '$u_e')");
                    }
                }
            }
        }

        // 6. THÊM MÀU MỚI
        if(isset($post['new_ten_mau'])) {
            foreach($post['new_ten_mau'] as $idx => $val_mau) {

                $id_m = 0;

                // tạo màu mới nhanh
                if (strpos($val_mau, 'NEW|') === 0) {
                    $parts = explode('|', $val_mau);
                    $ten_m = $this->db->real_escape_string($parts[1]);
                    $ma_m = $this->db->real_escape_string($parts[2]);

                    $this->db->query("INSERT INTO mau_xe (Ten_Mau, Ma_Mau) VALUES ('$ten_m', '$ma_m')");
                    $id_m = $this->db->insert_id;
                } else {
                    $id_m = (int)$val_mau;
                }

                if($id_m > 0) {
                    $gia_n = (int)str_replace(['.', ','], '', $post['new_gia_mau'][$idx]);
                    $sl_n = (int)$post['new_so_luong'][$idx];

                    $this->db->query("INSERT INTO xe_mau (id_Xe, id_Mau, Gia, So_Luong, is_Default) 
                                     VALUES ($id_xe, $id_m, $gia_n, $sl_n, 0)");

                    $new_id_xm = $this->db->insert_id;

                    // thêm album ảnh
                    if(isset($post['new_anh_mau_urls'][$idx])) {
                        foreach($post['new_anh_mau_urls'][$idx] as $u) {
                            $u_e = $this->db->real_escape_string($u);
                            $this->db->query("INSERT INTO xe_mau_anh (id_Xe_Mau, Hinh_Anh_Xe_Mau) VALUES ($new_id_xm, '$u_e')");
                        }
                    }
                }
            }
        }

        // ✅ COMMIT
        $this->db->commit();
        return true;

    } catch (\Exception $e) {
        // ❌ ROLLBACK nếu lỗi
        $this->db->rollback();
        return false;
    }
}
public function Delete_MauXe($id_Xe_Mau)
{
    $id_Xe_Mau = (int)$id_Xe_Mau;
    $cloudinary = new \App\Services\CloudinaryService();

    // ===== 1. Lấy danh sách ảnh của màu này trên Cloudinary =====
    $res = $this->db->query("
        SELECT Hinh_Anh_Xe_Mau 
        FROM xe_mau_anh 
        WHERE id_Xe_Mau = $id_Xe_Mau
    ");

    if ($res) {
        while ($row = $res->fetch_assoc()) {
            // Xóa từng ảnh màu trên Cloudinary
            if (!empty($row['Hinh_Anh_Xe_Mau'])) {
                $cloudinary->deleteImage($row['Hinh_Anh_Xe_Mau']);
            }
        }
    }

    // ===== 2. Xóa dữ liệu ảnh trong DB (Bảng xe_mau_anh) =====
    $this->db->query("
        DELETE FROM xe_mau_anh 
        WHERE id_Xe_Mau = $id_Xe_Mau
    ");

    // ===== 3. Xóa bản ghi màu xe (Bảng xe_mau) =====
    return $this->db->query("
        DELETE FROM xe_mau 
        WHERE id_Xe_Mau = $id_Xe_Mau
    ");
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
            xma.Hinh_Anh_Xe_Mau,
            xma.id_Xe_Mau_Anh 
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
    $cloudinary = new \App\Services\CloudinaryService();

    // ===== 1. Lấy thông tin xe (Ảnh chính & Ảnh 3D) =====
    $res = $this->db->query("
        SELECT Anh_Dai_Dien, Anh_3d 
        FROM san_pham_xe 
        WHERE id_Xe = $id_xe
    ");

    if (!$res || $res->num_rows == 0) return false;
    $xe = $res->fetch_assoc();

    // ===== 2. Xóa ảnh đại diện & ảnh 3D trên Cloudinary =====
    if (!empty($xe['Anh_Dai_Dien'])) {
        $cloudinary->deleteImage($xe['Anh_Dai_Dien']);
    }
    if (!empty($xe['Anh_3d'])) {
        $cloudinary->deleteImage($xe['Anh_3d']);
    }

    // ===== 3. Xóa toàn bộ ảnh chi tiết (xe_mau_anh) trên Cloudinary =====
    $res_anh = $this->db->query("
        SELECT xma.Hinh_Anh_Xe_Mau
        FROM xe_mau_anh xma
        JOIN xe_mau xm ON xma.id_Xe_Mau = xm.id_Xe_Mau
        WHERE xm.id_Xe = $id_xe
    ");

    if ($res_anh) {
        while ($anh = $res_anh->fetch_assoc()) {
            if (!empty($anh['Hinh_Anh_Xe_Mau'])) {
                $cloudinary->deleteImage($anh['Hinh_Anh_Xe_Mau']);
            }
        }
    }

    // ===== 4. Xóa Database (ON DELETE CASCADE sẽ tự xóa các bảng con) =====
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

function DanhSach_LaiThu($ngay = null, $idXe = null, $trangThai = null, $tenKhach = null)
{
    $sql = "
        SELECT dl.id_Dat_Lich,
               kh.Ho_Ten,
               kh.So_Dien_Thoai,
               sp.Ten_Xe,
               mx.Ten_Mau,
               dl.Ngay_Lai_Thu,
               CONCAT(kg.Gio_Bat_Dau, ' - ', kg.Gio_Ket_Thuc) AS Khung_Gio,
               dl.Trang_Thai
        FROM dat_lich_lai_thu dl
        JOIN khach_hang kh ON dl.id_Khach_Hang = kh.id_Khach_Hang
        JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
        JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
        JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
        JOIN khung_gio_lai_thu kg ON dl.id_Khung_Gio = kg.id_Khung_Gio
        WHERE 1=1
    ";

    if ($ngay) {
        $sql .= " AND dl.Ngay_Lai_Thu = '$ngay'";
    }

    if ($idXe) {
        $sql .= " AND sp.id_Xe = $idXe";
    }

    if ($trangThai !== null && $trangThai !== '') {
        $sql .= " AND dl.Trang_Thai = $trangThai";
    }

    if ($tenKhach) {
        $sql .= " AND kh.Ho_Ten LIKE '%$tenKhach%'";
    }

    $sql .= " ORDER BY dl.id_Dat_Lich DESC";

    return $this->db->query($sql);
}
public function CapNhatTrangThai_LaiThu($id, $trangThai)
{
    $sql = "UPDATE dat_lich_lai_thu 
            SET Trang_Thai = $trangThai 
            WHERE id_Dat_Lich = $id";

    return $this->db->query($sql);
}
public function Xoa_LaiThu($id)
{
    $sql = "DELETE FROM dat_lich_lai_thu 
            WHERE id_Dat_Lich = $id";

    return $this->db->query($sql);
}


// THỐNG KÊ TIÊU DÙNG (LÁI THỬ / BẢO DƯỠNG)//
public function thongKeKhungGioLaiThu($from = null, $to = null)
{
    $sql = "SELECT kg.id_Khung_Gio, CONCAT(kg.Gio_Bat_Dau, ' - ', kg.Gio_Ket_Thuc) as khung_gio, COUNT(*) as so_lan_dat 
            FROM dat_lich_lai_thu dl
            JOIN khung_gio_lai_thu kg ON dl.id_Khung_Gio = kg.id_Khung_Gio
            WHERE 1=1";

    if ($from) {
        $from = $this->db->real_escape_string($from);
        $sql .= " AND dl.Ngay_Lai_Thu >= '$from'";
    }
    if ($to) {
        $to = $this->db->real_escape_string($to);
        $sql .= " AND dl.Ngay_Lai_Thu <= '$to'";
    }

    $sql .= " GROUP BY kg.id_Khung_Gio, kg.Gio_Bat_Dau, kg.Gio_Ket_Thuc
              ORDER BY so_lan_dat DESC";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeXeLaiThu($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT sp.id_Xe, sp.Ten_Xe, COUNT(*) as so_lan_lai_thu
            FROM dat_lich_lai_thu dl
            JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            GROUP BY sp.id_Xe, sp.Ten_Xe
            ORDER BY so_lan_lai_thu DESC 
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeThuongHieuLaiThu($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT th.id_Thuong_Hieu, th.Ten_Thuong_Hieu, COUNT(*) as so_lan_lai_thu
            FROM dat_lich_lai_thu dl
            JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            GROUP BY th.id_Thuong_Hieu, th.Ten_Thuong_Hieu
            ORDER BY so_lan_lai_thu DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeKhungGioLaiThuTheoNgay($ngay)
{
    $ngay = $this->db->real_escape_string($ngay);
    $sql = "SELECT kg.id_Khung_Gio, CONCAT(kg.Gio_Bat_Dau, ' - ', kg.Gio_Ket_Thuc) as khung_gio, COUNT(*) as so_lan_dat\n"
         . "FROM dat_lich_lai_thu dl\n"
         . "JOIN khung_gio_lai_thu kg ON dl.id_Khung_Gio = kg.id_Khung_Gio\n"
         . "WHERE dl.Ngay_Lai_Thu = '$ngay'\n"
         . "GROUP BY kg.id_Khung_Gio, kg.Gio_Bat_Dau, kg.Gio_Ket_Thuc\n"
         . "ORDER BY so_lan_dat DESC";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeChiTietNgay($ngay)
{
    $ngay = $this->db->real_escape_string($ngay);
    $sql = "SELECT kg.id_Khung_Gio, CONCAT(kg.Gio_Bat_Dau, ' - ', kg.Gio_Ket_Thuc) as khung_gio, "
         . "lx.Ten_Loai_Xe as loai_xe, sp.Ten_Xe as ten_xe, th.Ten_Thuong_Hieu as ten_thuong_hieu, "
         . "xm.id_Mau as id_mau, mx.Ten_Mau as ten_mau, MIN(xma.Hinh_Anh_Xe_Mau) AS hinh_anh_mau, COUNT(DISTINCT dl.id_Dat_Lich) as so_lan_dat\n"
         . "FROM dat_lich_lai_thu dl\n"
         . "JOIN khung_gio_lai_thu kg ON dl.id_Khung_Gio = kg.id_Khung_Gio\n"
         . "JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau\n"
         . "JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau\n" 
         . "JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe\n"
         . "JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe\n"
         . "JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu\n"
         . "LEFT JOIN xe_mau_anh xma ON xm.id_Xe_Mau = xma.id_Xe_Mau\n"
         . "WHERE dl.Ngay_Lai_Thu = '$ngay'\n"
         . "GROUP BY kg.id_Khung_Gio, kg.Gio_Bat_Dau, kg.Gio_Ket_Thuc, lx.id_Loai_xe, lx.Ten_Loai_Xe, sp.id_Xe, sp.Ten_Xe, th.id_Thuong_Hieu, th.Ten_Thuong_Hieu, xm.id_Mau, mx.Ten_Mau\n" 
         . "ORDER BY kg.Gio_Bat_Dau, so_lan_dat DESC";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeChiTietBaoDuongTheoNgay($ngay)
{
    $ngay = $this->db->real_escape_string($ngay);
    $sql = "SELECT sp.Ten_Xe as ten_xe, mx.Ten_Mau as ten_mau, lb.ngay_bao_duong as ngay_bao_duong, lb.ngay_cap_nhat as ngay_cap_nhat, lb.trang_thai, gb.ten_goi as goi_bao_duong, COUNT(DISTINCT lb.id_lich) as so_lan_dat\n"
         . "FROM lich_bao_duong lb\n"
         . "JOIN xe_mau xm ON lb.id_Xe_Mau = xm.id_Xe_Mau\n"
         . "JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau\n"
         . "JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe\n"
         . "JOIN goi_bao_duong gb ON lb.id_goi = gb.id_goi\n"
         . "WHERE lb.ngay_bao_duong = '$ngay'\n"
         . "GROUP BY sp.id_Xe, mx.id_Mau, lb.ngay_bao_duong, lb.ngay_cap_nhat, lb.trang_thai, gb.id_goi, gb.ten_goi\n"
         . "ORDER BY so_lan_dat DESC"; 

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeLichTheoThoiGian($from = null, $to = null, $group = 'ngay')
{
    $groupField = 'DATE(dl.Ngay_Lai_Thu)';
    if ($group === 'thang') {
        $groupField = "CONCAT(YEAR(dl.Ngay_Lai_Thu), '-', LPAD(MONTH(dl.Ngay_Lai_Thu), 2, '0'))";
    } elseif ($group === 'nam') {
        $groupField = 'YEAR(dl.Ngay_Lai_Thu)';
    }

    $sql = "SELECT $groupField as nhom, COUNT(*) as so_lan_dat
            FROM dat_lich_lai_thu dl
            WHERE 1=1";

    if ($from) {
        $from = $this->db->real_escape_string($from);
        $sql .= " AND dl.Ngay_Lai_Thu >= '$from'";
    }
    if ($to) {
        $to = $this->db->real_escape_string($to);
        $sql .= " AND dl.Ngay_Lai_Thu <= '$to'";
    }

    $sql .= " GROUP BY $groupField ORDER BY nhom ASC"; 

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeLichBaoDuongTheoThoiGian($from = null, $to = null, $group = 'ngay')  //
{
    $groupField = 'DATE(lb.ngay_bao_duong)';
    if ($group === 'thang') {
        $groupField = "CONCAT(YEAR(lb.ngay_bao_duong), '-', LPAD(MONTH(lb.ngay_bao_duong), 2, '0'))";
    } elseif ($group === 'nam') {
        $groupField = 'YEAR(lb.ngay_bao_duong)';
    }

    $sql = "SELECT $groupField as nhom, COUNT(*) as so_lan_dat\n"
         . "FROM lich_bao_duong lb\n"
         . "WHERE 1=1";

    if ($from) {
        $from = $this->db->real_escape_string($from);
        $sql .= " AND lb.ngay_bao_duong >= '$from'";
    }
    if ($to) {
        $to = $this->db->real_escape_string($to);
        $sql .= " AND lb.ngay_bao_duong <= '$to'";
    }

    $sql .= " GROUP BY $groupField ORDER BY nhom ASC";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeLoaiXeMuaNhieu($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT lx.id_Loai_xe, lx.Ten_Loai_Xe, COUNT(*) as so_lan_mua
            FROM don_hang dh
            JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            WHERE dh.payment_status = 'paid'
            GROUP BY lx.id_Loai_xe, lx.Ten_Loai_Xe
            ORDER BY so_lan_mua DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeMauXeUaChuong($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT mx.id_Mau, mx.Ten_Mau, COUNT(*) as so_lan_dat
            FROM dat_lich_lai_thu dllt
            JOIN xe_mau xm ON dllt.id_Xe_Mau = xm.id_Xe_Mau
            JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
            GROUP BY mx.id_Mau, mx.Ten_Mau
            ORDER BY so_lan_dat DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeMauXeMua($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT mx.id_Mau, mx.Ten_Mau, COUNT(*) as so_lan_mua
            FROM don_hang dh
            JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
            JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
            WHERE dh.payment_status = 'paid'
            GROUP BY mx.id_Mau, mx.Ten_Mau
            ORDER BY so_lan_mua DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeThuongHieuMuaNhieu($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT th.id_Thuong_Hieu, th.Ten_Thuong_Hieu, COUNT(*) as so_lan_mua
            FROM don_hang dh
            JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            WHERE dh.payment_status = 'paid'
            GROUP BY th.id_Thuong_Hieu, th.Ten_Thuong_Hieu
            ORDER BY so_lan_mua DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeLoaiXeUaChuong($limit = 10)
{
    $limit = (int)$limit;
    $sql = "SELECT lx.id_Loai_xe, lx.Ten_Loai_Xe, COUNT(*) as so_lan_lai_thu
            FROM dat_lich_lai_thu dllt
            JOIN xe_mau xm ON dllt.id_Xe_Mau = xm.id_Xe_Mau
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            GROUP BY lx.id_Loai_xe, lx.Ten_Loai_Xe
            ORDER BY so_lan_lai_thu DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

public function thongKeLoaiXeXuHuong($limit = 10) // biểu đồ tròn  loại / dòng tổng đặt lịch và mua hàng 
{
    $limit = (int)$limit;
    $sql = "SELECT 
                lx.id_Loai_xe, 
                lx.Ten_Loai_Xe, 
                COALESCE(lai_thu.so_luong_lai, 0) as so_luong_lai_thu,
                COALESCE(don_hang.so_luong_mua, 0) as so_luong_don_hang,
                (COALESCE(lai_thu.so_luong_lai, 0) + COALESCE(don_hang.so_luong_mua, 0)) as tong_tuong_tac
            FROM loai_xe lx
            LEFT JOIN (
                SELECT sp.id_Loai_Xe, COUNT(*) as so_luong_lai
                FROM dat_lich_lai_thu dl
                JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
                JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
                GROUP BY sp.id_Loai_Xe
            ) lai_thu ON lx.id_Loai_xe = lai_thu.id_Loai_Xe
            LEFT JOIN (
                SELECT sp.id_Loai_Xe, COUNT(*) as so_luong_mua
                FROM don_hang dh
                JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
                JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
                WHERE dh.payment_status = 'paid'
                GROUP BY sp.id_Loai_Xe
            ) don_hang ON lx.id_Loai_xe = don_hang.id_Loai_Xe
            WHERE (lai_thu.so_luong_lai > 0 OR don_hang.so_luong_mua > 0)
            ORDER BY tong_tuong_tac DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
      return $data;
    }
}


// QL GÓI BẢO DƯỠNG
function danh_sach_goi(){

    $sql = "SELECT * FROM goi_bao_duong";

    $result = $this->db->query($sql);

    $data = [];
    if ($result) {
    while($row = $result->fetch_assoc()){
             $data[] = $row;
    }}
    return $data;
    }

public function list_thuong_hieu_theo_loai($MaLoai)
{
    $sql = "SELECT * 
            FROM thuong_hieu 
            WHERE id_Loai_xe = ?";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $MaLoai);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {

        $data[] = $row;
    }

    return $data;
}

        // thêm gói
        function them_goi($ten, $mo_ta, $gia){

            $ten = $this->db->real_escape_string($ten);
            $mo_ta = $this->db->real_escape_string($mo_ta);
            $gia = $this->db->real_escape_string($gia);
        
            $sql = "INSERT INTO goi_bao_duong(ten_goi, mo_ta, gia)
                    VALUES('$ten','$mo_ta','$gia')";
        
            return $this->db->query($sql);
        }

        // Sửa gói
    function lay_goi_id($id){
        $id = (int)$id;
        $sql = "SELECT * FROM goi_bao_duong WHERE id_goi = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // cập nhật
    function update_goi($id, $ten, $mo_ta, $gia){
        $id = (int)$id;
        $ten = $this->db->real_escape_string($ten);
        $mo_ta = $this->db->real_escape_string($mo_ta);
        $gia = $this->db->real_escape_string($gia);

        $sql = "UPDATE goi_bao_duong 
                SET ten_goi='$ten', mo_ta='$mo_ta', gia='$gia'
                WHERE id_goi = $id";

        return $this->db->query($sql);
    }
    
        // xóa gói
        public function thuc_hien_xoa($id) 
{
    // 1. Kiểm tra xem có xe nào đang dùng gói này không
    $check_sql = "SELECT * FROM lich_bao_duong WHERE id_goi = ?";
    $stmt_check = $this->db->prepare($check_sql);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        return false; // Không được xóa
    }

    // 2. Nếu không có xe nào dùng thì mới xóa
    $sql = "DELETE FROM goi_bao_duong WHERE id_goi = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
        
function DanhSach_DonHang($filters = []) {
    $where = " WHERE 1=1 ";

    if (!empty($filters['keyword'])) {
        $kw = $this->db->real_escape_string($filters['keyword']);
        $where .= " AND (kh.Ho_Ten LIKE '%$kw%' OR dh.id_Don_Hang = '$kw')";
    }

    if (!empty($filters['payment_status'])) {
        $ps = $this->db->real_escape_string($filters['payment_status']);
        $where .= " AND dh.payment_status = '$ps'";
    }

    if (!empty($filters['trang_thai'])) {
        $tt = $this->db->real_escape_string($filters['trang_thai']);
        $where .= " AND dh.Trang_Thai = '$tt'";
    }

    $sql = "
        SELECT 
            dh.*, 
            kh.Ho_Ten, 
            kh.So_Dien_Thoai, 
            sp.Ten_Xe,
            mx.Ten_Mau
        FROM don_hang dh
        LEFT JOIN khach_hang kh ON dh.id_Khach_Hang = kh.id_Khach_Hang
        LEFT JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
        LEFT JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
        LEFT JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
        $where
        ORDER BY dh.id_Don_Hang DESC
    ";
    
    return $this->db->query($sql);
}

// 2. Lấy chi tiết 1 đơn hàng
function Get_ChiTietDonHang($id) {
    $id = (int)$id;
    $sql = "SELECT * FROM don_hang WHERE id_Don_Hang = $id LIMIT 1";
    $result = $this->db->query($sql);
    return $result ? $result->fetch_assoc() : null;
}

// 3. Thêm mới đơn hàng
function Add_DonHang($data, $tong_tien) {
    $id_kh = (int)$data['id_khach_hang'];
    $id_xm = (int)$data['id_xe_mau'];
    $gia_goc = (int)$data['gia_goc'];
    $gia_giam = (int)($data['gia_giam'] ?? 0);
    $tien_coc = (int)($data['tien_coc'] ?? 0);
    $p_status = $this->db->real_escape_string($data['payment_status'] ?? 'pending');
    $trang_thai = $this->db->real_escape_string($data['trang_thai'] ?? 'new');
    $ngay = date('Y-m-d H:i:s');

    $sql = "INSERT INTO don_hang (id_Khach_Hang, id_Xe_Mau, Gia_Goc, Gia_Giam, Tong_Tien, Tien_Coc, payment_status, Trang_Thai, Ngay_Tao)
            VALUES ($id_kh, $id_xm, $gia_goc, $gia_giam, $tong_tien, $tien_coc, '$p_status', '$trang_thai', '$ngay')";
    
    return $this->db->query($sql);
}

// 4. Cập nhật đơn hàng
function Update_DonHang($id, $data, $tong_tien) {
    $id = (int)$id;
    $id_kh = (int)$data['id_khach_hang'];
    $id_xm = (int)$data['id_xe_mau'];
    $gia_goc = (int)$data['gia_goc'];
    $gia_giam = (int)($data['gia_giam'] ?? 0);
    $tien_coc = (int)($data['tien_coc'] ?? 0);
    $p_status = $this->db->real_escape_string($data['payment_status']);
    $trang_thai = $this->db->real_escape_string($data['trang_thai']);
    $ngay_up = date('Y-m-d H:i:s');

    $sql = "UPDATE don_hang SET 
                id_Khach_Hang = $id_kh, 
                id_Xe_Mau = $id_xm, 
                Gia_Goc = $gia_goc, 
                Gia_Giam = $gia_giam, 
                Tong_Tien = $tong_tien, 
                Tien_Coc = $tien_coc, 
                payment_status = '$p_status', 
                Trang_Thai = '$trang_thai',
                Ngay_Cap_Nhat = '$ngay_up'
            WHERE id_Don_Hang = $id";
            
    return $this->db->query($sql);
}

// 5. Xóa đơn hàng
function Delete_DonHang($id) {
    $id = (int)$id;
    $sql = "DELETE FROM don_hang WHERE id_Don_Hang = $id";
    return $this->db->query($sql);
}

// 6. Các hàm hỗ trợ xe & kho
function List_XeKemMau() {
    $sql = "
        SELECT xm.id_Xe_Mau, sp.Ten_Xe, mx.Ten_Mau, xm.Gia, xm.So_Luong
        FROM xe_mau xm
        JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
        JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
        WHERE sp.Trang_Thai = 1 AND xm.So_Luong > 0
    ";
    return $this->db->query($sql);
}

function list_sanpham(){
    $sql =" SELECT * FROM san_pham_xe ";
     return $this->db->query($sql);
}

function Tru_So_Luong_Xe($id_xe_mau) {
    $id_xe_mau = (int)$id_xe_mau;
    $sql = "UPDATE xe_mau SET So_Luong = So_Luong - 1 WHERE id_Xe_Mau = $id_xe_mau AND So_Luong > 0";
    return $this->db->query($sql);
}


// ==========================================================================
// NHÓM CHỨC NĂNG: QUẢN LÝ NHÂN VIÊN
// ==========================================================================

function DanhSach_Nhan_Vien($filters = []) {
    $where = " WHERE 1=1 ";

    if (!empty($filters['ten'])) {
        $ten = addslashes($filters['ten']);
        $where .= " AND ad.Ho_Ten LIKE '%$ten%' ";

    }

    if (!empty($filters['role_id'])) {
        $role = (int)$filters['role_id'];
        $where .= " AND ad.role_id = $role ";
    }
    

    if (!empty($filters['role_id'])) {
        $role = (int)$filters['role_id'];
        $where .= " AND ad.role_id = $role ";
    }
    $sql = "
        SELECT 
            ad.id_Ad,
            ad.UserName,
            ad.Ho_Ten,
            ad.Email,
            ad.So_Dien_Thoai,
            ad.Trang_Thai,
            ad.created_at,
            r.ten_role,
            ad.role_id
        FROM admin ad
        LEFT JOIN roles r ON ad.role_id = r.id
        $where
        ORDER BY ad.id_Ad DESC
    ";

    $result = $this->db->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;

    }
    return $data;
}


public function thongKeThuongHieuXuHuong($limit = 10) // biểu đồ tròn thương hiệu xu hướng tổng  đặt lịch và mua hàng 
{
    $limit = (int)$limit;
    $sql = "SELECT 
                th.id_Thuong_Hieu, 
                th.Ten_Thuong_Hieu, 
                COALESCE(lai_thu.so_luong_lai, 0) as so_luong_lai_thu,
                COALESCE(don_hang.so_luong_mua, 0) as so_luong_don_hang,
                (COALESCE(lai_thu.so_luong_lai, 0) + COALESCE(don_hang.so_luong_mua, 0)) as tong_tuong_tac
            FROM thuong_hieu_xe th
            LEFT JOIN (
                SELECT sp.id_Thuong_Hieu, COUNT(*) as so_luong_lai
                FROM dat_lich_lai_thu dl
                JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
                JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
                GROUP BY sp.id_Thuong_Hieu
            ) lai_thu ON th.id_Thuong_Hieu = lai_thu.id_Thuong_Hieu
            LEFT JOIN (
                SELECT sp.id_Thuong_Hieu, COUNT(*) as so_luong_mua
                FROM don_hang dh
                JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
                JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
                WHERE dh.payment_status = 'paid'
                GROUP BY sp.id_Thuong_Hieu
            ) don_hang ON th.id_Thuong_Hieu = don_hang.id_Thuong_Hieu
            WHERE (lai_thu.so_luong_lai > 0 OR don_hang.so_luong_mua > 0)
            ORDER BY tong_tuong_tac DESC
            LIMIT $limit";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function ChiTiet_Nhan_Vien($id) {
    $id = (int)$id;
    $sql = "SELECT * FROM admin WHERE id_Ad = $id";
    $result = $this->db->query($sql);
    return $result->fetch_assoc();
}

function Them_Nhan_Vien($request) {
    $hoTen  = addslashes($request->Ho_Ten);
    $user   = addslashes($request->UserName);
    $email  = addslashes($request->Email);
    $sdt    = addslashes($request->So_Dien_Thoai);
    $role   = (int)$request->role_id;
    $status = (int)$request->Trang_Thai;
    $password = password_hash($request->MatKhau, PASSWORD_DEFAULT);

    $sql = "
        INSERT INTO admin 
        (Ho_Ten, UserName, Email, So_Dien_Thoai, PassWord, role_id, Trang_Thai, created_at)
        VALUES 
        ('$hoTen', '$user', '$email', '$sdt', '$password', $role, $status, NOW())
    ";
    return $this->db->query($sql);
}

function CapNhat_Nhan_Vien($request, $id) {
    $hoTen  = addslashes($request->Ho_Ten);
    $user   = addslashes($request->UserName);
    $email  = addslashes($request->Email);
    $sdt    = addslashes($request->So_Dien_Thoai);
    $role   = (int)$request->role_id;
    $status = (int)$request->Trang_Thai;

    if (!empty($request->MatKhau)) {
        $password = password_hash($request->MatKhau, PASSWORD_DEFAULT);
        $sql = "
            UPDATE admin SET
                Ho_Ten = '$hoTen',
                UserName = '$user',
                Email = '$email',
                So_Dien_Thoai = '$sdt',
                PassWord = '$password',
                role_id = $role,
                Trang_Thai = $status
            WHERE id_Ad = $id
        ";
    } else {
        $sql = "
            UPDATE admin SET
                Ho_Ten = '$hoTen',
                UserName = '$user',
                Email = '$email',
                So_Dien_Thoai = '$sdt',
                role_id = $role,
                Trang_Thai = $status
            WHERE id_Ad = $id
        ";
    }

    return $this->db->query($sql);



    return $this->db->query($sql);
}



































// BẢO DƯỠNG ADMIN
function danh_sach_lich($request) {
    // 1. Lọc dữ liệu đầu vào
    $ten_khach = $this->db->real_escape_string($request->ten_khach);
    $sdt       = $this->db->real_escape_string($request->sdt);
    $ten_xe    = $this->db->real_escape_string($request->ten_xe);
    $goi       = $this->db->real_escape_string($request->goi);
    $ngay      = $this->db->real_escape_string($request->ngay_bao_duong);
    $trang_thai= $this->db->real_escape_string($request->trang_thai);

    // 2. SQL chuẩn theo cấu trúc database của bạn
    $sql = "
        SELECT 
            dl.id_lich,
            kh.Ho_Ten,
            kh.So_Dien_Thoai,
            dl.ngay_bao_duong,
            dl.ghi_chu,
            dl.trang_thai,
            dl.ngay_tao,
            dl.ngay_cap_nhat,
            sp.Ten_Xe AS ten_xe,
            mx.Ten_Mau AS mau_xe,
            gbd.ten_goi,
            gbd.gia
        FROM lich_bao_duong dl
        LEFT JOIN khach_hang kh ON dl.id_Khach_Hang = kh.id_Khach_Hang
        LEFT JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
        LEFT JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
        LEFT JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
        LEFT JOIN goi_bao_duong gbd ON dl.id_goi = gbd.id_goi
        WHERE 1=1
    ";

    // 3. Điều kiện lọc (Sửa lại alias dl. hoặc kh. cho đúng bảng)
    if (!empty($ten_khach)) { $sql .= " AND kh.Ho_Ten LIKE '%$ten_khach%'"; }
    if (!empty($sdt))       { $sql .= " AND kh.So_Dien_Thoai LIKE '%$sdt%'"; }
    if (!empty($ten_xe))    { $sql .= " AND sp.Ten_Xe LIKE '%$ten_xe%'"; }
    if (!empty($goi))       { $sql .= " AND gbd.ten_goi LIKE '%$goi%'"; }
    if (!empty($ngay))      { $sql .= " AND dl.ngay_bao_duong = '$ngay'"; }
    if (!empty($trang_thai)){ $sql .= " AND dl.trang_thai = '$trang_thai'"; }

    $sql .= " ORDER BY dl.id_lich DESC";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

    // Sửa
    function Get_ChiTietbaoduong($id)
{
    $stmt = $this->db->prepare("
        SELECT 
            lbd.*,
            kh.Ho_Ten,
            kh.So_Dien_Thoai,
            sp.Ten_Xe,
            m.Ten_Mau,
            g.ten_goi
        FROM lich_bao_duong lbd

        JOIN khach_hang kh 
            ON lbd.id_Khach_Hang = kh.id_Khach_Hang

        JOIN xe_mau xm 
            ON lbd.id_Xe_Mau = xm.id_Xe_Mau

        JOIN san_pham_xe sp 
            ON xm.id_Xe = sp.id_Xe

        JOIN mau_xe m 
            ON xm.id_Mau = m.id_Mau

        JOIN goi_bao_duong g 
            ON lbd.id_goi = g.id_goi

        WHERE lbd.id_lich = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function Get_All_GoiBaoDuong()
{
    $sql = "SELECT id_goi, ten_goi FROM goi_bao_duong";

    $result = $this->db->query($sql);

    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function Update_baoduong($id, $data)
{
    $id_goi = $data['id_goi'];
    $ngay = $data['ngay_bao_duong'];
    $trang_thai = $data['trang_thai'];
    $ghi_chu = $data['ghi_chu'];

    $stmt = $this->db->prepare("
        UPDATE lich_bao_duong 
        SET id_goi = ?, ngay_bao_duong = ?, trang_thai = ?, ghi_chu = ?
        WHERE id_lich = ?
    ");

    $stmt->bind_param("isssi", $id_goi, $ngay, $trang_thai, $ghi_chu, $id);

    return $stmt->execute();
}
  function Delete_GoiBaoDuong($id){

            $id = (int)$id;
        
            $sql = "DELETE FROM goi_bao_duong WHERE id_goi = $id";
        
            return $this->db->query($sql);
        }

    // Xóa
    function Delete_BaoDuong($id)
{
    $stmt = $this->db->prepare("
        DELETE FROM lich_bao_duong 
        WHERE id_lich = ?
    ");

    $stmt->bind_param("i", $id);

    return $stmt->execute();
}

function Xoa_Nhan_Vien($id) {
    $id = (int)$id;
    $sql = "DELETE FROM admin WHERE id_Ad = $id";
    return $this->db->query($sql);
}
   // ==========================================
    // CÁC HÀM THỐNG KÊ DOANH THU 
    // ==========================================

    // 1. Tổng doanh thu trong năm
    public function ThongKe_TongDoanhThu($nam) {
        $nam = (int)$nam;
        $sql = "SELECT SUM(Tong_Tien) as total FROM don_hang WHERE payment_status = 'paid' AND YEAR(Ngay_Tao) = $nam";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'] ? (float)$row['total'] : 0;
    }

    // 2. Khách hàng mới trong năm
    public function ThongKe_KhachHangMoi($nam) {
        $nam = (int)$nam;
        $sql = "SELECT COUNT(*) as total FROM khach_hang WHERE YEAR(Ngay_Tao) = $nam";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }

    // 3. Tỷ lệ khách mua lại (Giữ chân)
    public function ThongKe_TyLeQuayLai() {
        $sqlTotal = "SELECT COUNT(*) as total FROM khach_hang";
        $resTotal = $this->db->query($sqlTotal);
        $totalKhach = (int)$resTotal->fetch_assoc()['total'];

        if ($totalKhach === 0) return 0;

        $sqlReturn = "SELECT COUNT(*) as total_return FROM (
                        SELECT id_Khach_Hang 
                        FROM don_hang 
                        WHERE payment_status = 'paid' 
                        GROUP BY id_Khach_Hang 
                        HAVING COUNT(id_Don_Hang) > 1
                      ) as returning_customers";
        $resReturn = $this->db->query($sqlReturn);
        $totalReturn = (int)$resReturn->fetch_assoc()['total_return'];

        return round(($totalReturn / $totalKhach) * 100, 2);
    }

    // 4. Lấy dữ liệu 12 tháng cho biểu đồ
    public function ThongKe_BieuDoDoanhThu($nam) {
        $nam = (int)$nam;
        $sql = "SELECT MONTH(Ngay_Tao) as thang, SUM(Tong_Tien) as doanh_thu 
                FROM don_hang 
                WHERE payment_status = 'paid' AND YEAR(Ngay_Tao) = $nam 
                GROUP BY MONTH(Ngay_Tao)";
        $result = $this->db->query($sql);
        
        $data = array_fill(1, 12, 0); 
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[(int)$row['thang']] = (float)$row['doanh_thu'];
            }
        }
        return array_values($data); 
    }

    // 5. Đếm số lượng xe bán ra
    public function ThongKe_SoLuongXeBanRa($nam) {
        $nam = (int)$nam;
        $sql = "SELECT COUNT(*) as total FROM don_hang WHERE payment_status = 'paid' AND YEAR(Ngay_Tao) = $nam";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }

    // 6. Lấy chi tiết xe bán ra cho Modal
    public function ThongKe_ChiTietXeBanRa($nam) {
        $nam = (int)$nam;
        $sql = "SELECT sp.Ten_Xe, mx.Ten_Mau, dh.Tong_Tien, dh.Ngay_Tao 
                FROM don_hang dh
                JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
                JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
                JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
                WHERE dh.payment_status = 'paid' AND YEAR(dh.Ngay_Tao) = $nam
                ORDER BY dh.Ngay_Tao DESC";
        $result = $this->db->query($sql);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    

}