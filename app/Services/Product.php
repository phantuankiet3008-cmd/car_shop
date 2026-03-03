<?php
namespace App\Services;

use Illuminate\Support\Facades\DB; 
class Product {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "car_shop";
    private $db;

    public function __construct() {
        $this->db = new \mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_error) {
            die("Kết nối thất bại: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    //Loại xe
    function list_san_pham_xe() {
        return $this->db->query("SELECT id_Xe, Ten_Xe, Mo_Ta, Anh_Dai_Dien, Anh_3d, Trang_thai, Ngay_Tao, id_Loai_Xe, id_Thuong_Hieu FROM san_pham_xe");
    }

    function list_xe_theo_loai($MaLoai) {
        $MaLoai = $this->db->real_escape_string($MaLoai);
        return $this->db->query("SELECT id_Xe, Ten_Xe, Mo_Ta, Anh_Dai_Dien, Anh_3d, Trang_thai, Ngay_Tao, id_Loai_Xe, id_Thuong_Hieu FROM san_pham_xe WHERE id_Loai_Xe = '$MaLoai'");
    }

    public function list_loai_xe() {
        $sp="SELECT * FROM loai_xe";
        $result = $this->db->query($sp);
        return $result;
    }
    
    public function ten_loai_xe($MaLoai) {
    $MaLoai = (int)$MaLoai;
    $sql = "SELECT Ten_Loai_Xe FROM loai_xe WHERE id_Loai_xe = $MaLoai";
    $result = $this->db->query($sql);
    return ($row = $result->fetch_assoc()) ? $row['Ten_Loai_Xe'] : null;
}


    //thương hiệu
    function list_xe_theo_thuong_hieu($Mathuonghieu) {
    $Mathuonghieu = (int)$Mathuonghieu;

    $sql = "SELECT sp.id_Xe, sp.Ten_Xe, sp.Mo_Ta, 
                   sp.Anh_Dai_Dien, 
                   sp.Anh_3d, 
                   sp.Trang_thai, 
                   sp.Ngay_Tao, 
                   sp.id_Loai_Xe, 
                   sp.id_Thuong_Hieu
            FROM san_pham_xe sp
            WHERE sp.id_Thuong_Hieu = $Mathuonghieu 
            AND sp.Trang_thai = 'Còn hàng'";

    return $this->db->query($sql);
}
    function list_thuong_hieu() {
        return $this->db->query("SELECT * FROM thuong_hieu_xe");
    }
     function ten_thuong_hieu($Mathuonghieu) {
    $Mathuonghieu = (int)$Mathuonghieu;
    $sql = "SELECT Ten_Thuong_Hieu FROM thuong_hieu_xe WHERE id_Thuong_Hieu = $Mathuonghieu";
    $result = $this->db->query($sql);
    return ($row = $result->fetch_assoc()) ? $row['Ten_Thuong_Hieu'] : null;
}
function list_thuong_hieu_theo_loai($MaLoai){
    $MaLoai = (int)$MaLoai;
    $sql = "
        SELECT DISTINCT th.*
        FROM thuong_hieu_xe th
        JOIN san_pham_xe sp ON th.id_Thuong_Hieu = sp.id_Thuong_Hieu
        WHERE sp.id_Loai_Xe = $MaLoai
    ";
    return $this->db->query($sql);
}

function list_loai_theo_thuong_hieu($MaThuongHieu){
    $MaThuongHieu = (int)$MaThuongHieu;
    $sql = "
        SELECT DISTINCT l.*
        FROM loai_xe l
        JOIN san_pham_xe sp ON l.id_Loai_xe = sp.id_Loai_Xe
        WHERE sp.id_Thuong_Hieu = $MaThuongHieu
    ";
    return $this->db->query($sql);
}
public function list_xe_theo_loai_va_thuong_hieu($MaLoai, $MaThuongHieu){
    $MaLoai = (int)$MaLoai;
    $MaThuongHieu = (int)$MaThuongHieu;

    $sql = "SELECT sp.id_Xe, sp.Ten_Xe, sp.Gia, sp.Mo_Ta, sp.Anh_Dai_Dien as Anh_Dai_Dien_SP, sp.Anh_3d, sp.Trang_thai, sp.Ngay_Tao, sp.id_Loai_Xe, sp.id_Thuong_Hieu,
                (
                    SELECT xma.Hinh_Anh_Xe_Mau
                    FROM xe_mau xm
                    JOIN xe_mau_anh xma ON xma.id_Xe_Mau = xm.id_Xe_Mau
                    WHERE xm.id_Xe = sp.id_Xe AND xm.is_Default = 1
                    ORDER BY xma.Thu_Tu ASC
                    LIMIT 1
                ) AS Anh_Dai_Dien
                FROM san_pham_xe sp
                WHERE sp.id_Loai_Xe = $MaLoai AND sp.id_Thuong_Hieu = $MaThuongHieu AND sp.Trang_thai = 'Còn hàng'";

    return $this->db->query($sql);
}
// Tìm kiếm sản phẩm: trả về câu SQL và mảng tham số (sử dụng array() để tương thích PHP cũ)
   public function search_san_pham($search = '') {

    $search = trim($search);

    $sql = "SELECT sp.*,
                   lx.Ten_Loai_Xe,
                   th.Ten_Thuong_Hieu
            FROM san_pham_xe sp
            JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            WHERE sp.Trang_Thai = 1";

    $params = array();

    if ($search !== '') {
        $sql .= " AND (
                    sp.Ten_Xe LIKE ?
                    OR lx.Ten_Loai_Xe LIKE ?
                    OR th.Ten_Thuong_Hieu LIKE ?
                  )";

        $params = array("%{$search}%", "%{$search}%", "%{$search}%");
    }

    return array($sql, $params);
}
    // Thực thi truy vấn tìm kiếm và trả về mảng kết quả (mỗi phần tử là associative array)
    public function search_san_pham_results($search = '') {
        list($sql, $params) = $this->search_san_pham($search);

        // Nếu không có tham số, thực thi trực tiếp
        if (empty($params)) {
            $res = $this->db->query($sql);
            $rows = array();
            if ($res) {
                while ($r = $res->fetch_assoc()) {
                    $rows[] = $r;
                }
            }
            return $rows;
        }

        // Có tham số: dùng prepared statement
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return array();
        }

        $types = str_repeat('s', count($params));
        // bind_param requires references
        $bind_names = array();
        $bind_names[] = & $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_names[] = & $params[$i];
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_names);

        if (!$stmt->execute()) {
            return array();
        }

        $result = $stmt->get_result();
        $rows = array();
        if ($result) {
            while ($r = $result->fetch_assoc()) {
                $rows[] = $r;
            }
        }
        $stmt->close();
        return $rows;
    }
 function chitietsp($id) {
        $id = (int)$id;
        $sql = "SELECT sp.*,
                       lx.Ten_Loai_Xe,
                       th.Ten_Thuong_Hieu
                FROM san_pham_xe sp
                JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
                JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
                WHERE sp.id_Xe = $id";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    public function getAllSanPham() {
    $sql = " SELECT 
            sp.id_Xe,
            sp.Ten_Xe,
            sp.Anh_Dai_Dien,
            xm.Gia AS Gia_Mau,
            lx.Ten_Loai_Xe,
            th.Ten_Thuong_Hieu
        FROM san_pham_xe sp
        LEFT JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
        LEFT JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
        LEFT JOIN xe_mau xm ON sp.id_Xe = xm.id_Xe AND xm.is_Default = 1
        WHERE sp.Trang_Thai = 1
        ORDER BY sp.id_Xe DESC
    ";

    $result = $this->db->query($sql);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
    // 2. Hàm lấy danh sách ảnh theo màu - Đã sửa lỗi Join bảng
    // Trong DB của bạn: san_pham_xe -> xe_mau -> xe_mau_anh
function list_anh_xe_mau($id) {
    $id_xe = (int)$id;

    $sql = "SELECT 
                xma.Hinh_Anh_Xe_Mau as duong_dan,
                xm.id_Xe_Mau
            FROM xe_mau_anh xma
            JOIN xe_mau xm ON xma.id_Xe_Mau = xm.id_Xe_Mau
            WHERE xm.id_Xe = $id_xe
            ORDER BY xma.Thu_Tu ASC";

    return $this->db->query($sql);
}
public function locSanPham($MaLoai, $MaThuongHieu)
{
    $sql = "SELECT sp.id_Xe, sp.Ten_Xe, sp.Mo_Ta, sp.Anh_Dai_Dien, sp.Trang_thai, sp.id_Loai_Xe, sp.id_Thuong_Hieu,
            lx.Ten_Loai_Xe,
            th.Ten_Thuong_Hieu,
            xm.Gia AS Gia_Mau
            FROM san_pham_xe sp
            LEFT JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            LEFT JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            LEFT JOIN xe_mau xm ON sp.id_Xe = xm.id_Xe
            WHERE sp.Trang_Thai = 1 AND xm.is_Default = 1 ";

    if ($MaLoai > 0) {
        $sql .= " AND sp.id_Loai_Xe = $MaLoai";
    }

    if ($MaThuongHieu > 0) {
        $sql .= " AND sp.id_Thuong_Hieu = $MaThuongHieu";
    }

    $result = $this->db->query($sql);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

    // 3. Hàm lấy ưu đãi - Đã sửa lỗi thiếu Return
     function uu_dai_cua_xe($id) {

    $id_xe = (int)$id;

    $sql = "
        SELECT ud.* 
        FROM uu_dai ud
        JOIN xe_uu_dai xud 
            ON ud.id_Uu_Dai = xud.id_Uu_Dai
        WHERE xud.id_Xe = $id_xe
        AND ud.Trang_Thai = 1
        AND CURDATE() <= ud.Ngay_Ket_Thuc
        AND CURDATE() >= ud.Ngay_Bat_Dau
    ";

    return $this->db->query($sql);
}
    function list_mau_xe($id) {
    $id = (int)$id;
    // Lấy thêm Ma_Mau và Gia từ bảng xe_mau và mau_xe
    $sql = "SELECT xm.id_Xe_Mau, m.Ten_Mau, m.Ma_Mau, xm.Gia 
            FROM xe_mau xm
            JOIN mau_xe m ON xm.id_Mau = m.id_Mau
            WHERE xm.id_Xe = $id";
    return $this->db->query($sql);
}
}
?>