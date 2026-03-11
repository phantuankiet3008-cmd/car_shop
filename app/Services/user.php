<?php
namespace App\Services;
class User {
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

    public function dang_nhap($SDT, $MatKhau) {

        $SDT = $this->db->real_escape_string($SDT);
    
        $sql = "SELECT * FROM khach_hang WHERE So_Dien_Thoai = '$SDT'";
        $result = $this->db->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            
            if (password_verify($MatKhau, $row['Mat_Khau'])) {
                return $row; 
            }
        }
    
        return false;
    }

    // ĐĂNG KÝ
    public function dang_ky($HoTen,$DiaChi, $SDT, $email, $MatKhau) {

        $HoTen = $this->db->real_escape_string($HoTen);
        $DiaChi = $this->db->real_escape_string($DiaChi);
        $SDT = $this->db->real_escape_string($SDT);
        $email = $this->db->real_escape_string($email);
        $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);
    
        // Kiểm tra tồn tại
        $check = $this->db->query(
            "SELECT id_Khach_Hang FROM khach_hang WHERE So_Dien_Thoai = '$SDT'"
        );
    
        if ($check && $check->num_rows > 0) {
            return false; 
        }
    
        $sql = "INSERT INTO khach_hang (Ho_Ten, Dia_Chi, So_Dien_Thoai, Email, Mat_Khau)
                VALUES ('$HoTen','$DiaChi', '$SDT', '$email', '$MatKhauHash')";
    
        if ($this->db->query($sql)) {
            return true; 
        }
    
        return false;
    }
    

    // CẬP NHẬT MẬT KHẨU
    public function update_mk($SDT, $MK)
{
    $SDT = $this->db->real_escape_string($SDT);
    $MatKhauHash = password_hash($MK, PASSWORD_DEFAULT);

    $check = $this->db->query(
        "SELECT id_Khach_Hang FROM khach_hang WHERE So_Dien_Thoai = '$SDT'"
    );

    if (!$check || $check->num_rows == 0) {
        return false; 
    }

    $sql = "UPDATE khach_hang 
            SET Mat_Khau = '$MatKhauHash'
            WHERE So_Dien_Thoai = '$SDT'";

    if ($this->db->query($sql)) {
        return true; 
    }

    return false; 
}
    public function laykhachhangtheosdt($SDT) {
    $SDT = $this->db->real_escape_string($SDT);
    $sql = "SELECT * FROM khach_hang WHERE So_Dien_Thoai = '$SDT'";
    $result = $this->db->query($sql);
    return ($row = $result->fetch_assoc()) ? $row : null;
}
 function capnhat_thong_tin_khach_hang($id_khachhang,$ten,$email,$diachi,$sdt,$avatar)
{
    $TenKH = $this->db->real_escape_string($ten);
    $Email = $this->db->real_escape_string($email);
    $DiaChi = $this->db->real_escape_string($diachi);
    $SDT = $this->db->real_escape_string($sdt);

    // Nếu có avatar mới thì cập nhật
    if($avatar){
        $Avatar = $this->db->real_escape_string($avatar);

        $sql = "UPDATE khach_hang 
                SET Ho_Ten='$TenKH',
                    Email='$Email',
                    Dia_Chi='$DiaChi',
                    So_Dien_Thoai='$SDT',
                    Avatar='$Avatar'
                WHERE id_Khach_Hang='$id_khachhang'";
    } 
    // Nếu không upload avatar thì giữ nguyên
    else{
        $sql = "UPDATE khach_hang 
                SET Ho_Ten='$TenKH',
                    Email='$Email',
                    Dia_Chi='$DiaChi',
                    So_Dien_Thoai='$SDT'
                WHERE id_Khach_Hang='$id_khachhang'";
    }

    return $this->db->query($sql);
}
 function LichLaiThu_CuaToi($idKhach)
{
    $idKhach = (int)$idKhach;

$sql = "
    SELECT dl.id_Dat_Lich,
           sp.Ten_Xe,
           mx.Ten_Mau,
           dl.Ngay_Lai_Thu,
           CONCAT(kg.Gio_Bat_Dau, ' - ', kg.Gio_Ket_Thuc) AS Khung_Gio,
           dl.Trang_Thai
    FROM dat_lich_lai_thu dl
    JOIN xe_mau xm ON dl.id_Xe_Mau = xm.id_Xe_Mau
    JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
    JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
    JOIN khung_gio_lai_thu kg ON dl.id_Khung_Gio = kg.id_Khung_Gio
    WHERE dl.id_Khach_Hang = {$idKhach}
    ORDER BY dl.id_Dat_Lich DESC
";

    return $this->db->query($sql);
}



    // LẤY GÓI BẢO DƯỠNG
    public function chongoi_baoduong(){

        $sql = "SELECT * FROM goi_bao_duong WHERE trang_thai = 1";

        $result = $this->db->query($sql);

        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }

    // ĐẶT LỊCH BẢO DƯỠNG
    public function datlich_baoduong($id_khach,$id_goi,$ngay){

        $sql = "INSERT INTO lich_bao_duong (id_Khach_Hang,id_goi,ngay_bao_duong)
                VALUES ('$id_khach','$id_goi','$ngay')";

        return $this->db->query($sql);
    }
    public function lay_xe_mau($idXeMau){

    $idXeMau = (int)$idXeMau;

    $sql = "SELECT xm.*, 
                   sp.Ten_Xe,
                   th.Ten_Thuong_Hieu,
                   lx.Ten_Loai_Xe,
                   mx.Ten_Mau
            FROM xe_mau xm
            JOIN san_pham_xe sp ON xm.id_Xe = sp.id_Xe
            JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
            JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_Xe
            WHERE xm.id_Xe_Mau = $idXeMau";

    $result = $this->db->query($sql);

    return ($row = $result->fetch_assoc()) ? $row : null;
}
public function dem_don_cho_duyet($idXeMau){

    $idXeMau = (int)$idXeMau;

    $sql = "SELECT COUNT(*) as tong
            FROM don_hang
            WHERE id_Xe_Mau = $idXeMau
            AND Trang_Thai = 'cho_duyet'";

    $result = $this->db->query($sql);

    $row = $result->fetch_assoc();

    return $row['tong'];
}
public function lay_khach_hang($idKhach){

    $idKhach = (int)$idKhach;

    $sql = "SELECT * FROM khach_hang WHERE id_Khach_Hang = $idKhach";

    $result = $this->db->query($sql);

    return ($row = $result->fetch_assoc()) ? $row : null;
}
function uu_dai_cua_xe($idXeMau) {

    $idXeMau = (int)$idXeMau;

    $sql = "
        SELECT ud.*
        FROM uu_dai ud
        JOIN xe_uu_dai xud 
            ON ud.id_Uu_Dai = xud.id_Uu_Dai
        JOIN xe_mau xm 
            ON xm.id_Xe = xud.id_Xe
        WHERE xm.id_Xe_Mau = $idXeMau
        AND ud.Trang_Thai = 1
        AND CURDATE() <= ud.Ngay_Ket_Thuc
        AND CURDATE() >= ud.Ngay_Bat_Dau
    ";

    $result = $this->db->query($sql);

    $data = [];

    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    return $data;
}
}
?>






