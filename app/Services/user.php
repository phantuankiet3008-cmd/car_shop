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

}
?>



