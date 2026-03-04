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
    public function laykhachhangtheosdt($SDT) {
    $SDT = $this->db->real_escape_string($SDT);
    $sql = "SELECT * FROM khach_hang WHERE So_Dien_Thoai = '$SDT'";
    $result = $this->db->query($sql);
    return ($row = $result->fetch_assoc()) ? $row : null;
}
 function capnhat_thong_tin_khach_hang($id_khachhang,$ten, $email, $diachi, $sdt, $Avatar, $files)
 {
    $TenKH = $this->db->real_escape_string($ten);
    $Email = $this->db->real_escape_string($email);
    $DiaChi = $this->db->real_escape_string($diachi);
    $SDT = $this->db->real_escape_string($sdt);
    move_uploaded_file($files['avatar']['tmp_name'], '../upload/avatar/' . $Avatar);
    $sql = "UPDATE khach_hang 
            SET Ho_Ten = '$TenKH', Email = '$Email', Dia_Chi = '$DiaChi', So_Dien_Thoai = '$SDT',Avatar = '$avatar'
            WHERE id_Khach_Hang = '$id_khachhang'";

    return $this->db->query($sql);

}

}
?>



