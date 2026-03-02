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
}

?>