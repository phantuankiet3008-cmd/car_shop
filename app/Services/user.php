<?php
namespace App\Services;
class User {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "car_shop";
    private $db;
    protected $cloudinary;

    public function __construct() {
        $this->db = new \mysqli($this->host, $this->user, $this->pass, $this->dbname, 3308);
        if ($this->db->connect_error) {
            die("Kết nối thất bại: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");

        $this->cloudinary = new CloudinaryService();
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
 public function capnhat_thong_tin_khach_hang($id_khachhang, $ten, $email, $diachi, $sdt, $files)
{
    $id_khachhang = (int)$id_khachhang;
    $TenKH = $this->db->real_escape_string($ten);
    $Email = $this->db->real_escape_string($email);
    $DiaChi = $this->db->real_escape_string($diachi);
    $SDT = $this->db->real_escape_string($sdt);

    // 1. Lấy thông tin hiện tại trong DB để lấy URL Avatar cũ
    $old_data = $this->lay_khach_hang($id_khachhang);
    $avatar_url = $old_data['Avatar'] ?? "";

    // 2. Kiểm tra nếu có upload file ảnh mới (key 'avatar' khớp với tên input trong form)
    if (!empty($files['avatar']['name'])) {
        
        // Xóa ảnh cũ trên Cloudinary để tránh rác bộ nhớ
        if (!empty($avatar_url)) {
            $this->cloudinary->deleteImage($avatar_url);
        }

        // Upload ảnh mới lên thư mục 'avatars' trên Cloudinary
        // Lưu ý: $files['avatar'] là mảng từ $_FILES truyền sang
        $avatar_url = $this->cloudinary->uploadImage($files['avatar'], 'avatars');
    }

    // 3. Thực hiện câu lệnh SQL update
    $sql = "UPDATE khach_hang 
            SET Ho_Ten = '$TenKH',
                Email = '$Email',
                Dia_Chi = '$DiaChi',
                So_Dien_Thoai = '$SDT',
                Avatar = '$avatar_url'
            WHERE id_Khach_Hang = $id_khachhang";

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
public function uu_dai_cua_xe($idXeMau) {

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
 public function Danh_Sach_Slider() {
    $sql = "SELECT id_Loai_Xe, Hinh_Anh_Loai, Ten_Loai_Xe FROM loai_xe ORDER BY id_Loai_Xe DESC";
    $result = $this->db->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


public function lay_anh_va_id_theo_thuong_hieu_moi_nhat($tenThuongHieu) {
    $sql = "SELECT sp.id_Xe, sp.Anh_Dai_Dien, th.id_Thuong_Hieu
            FROM san_pham_xe sp
            JOIN thuong_hieu_xe th 
                ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            WHERE LOWER(th.Ten_Thuong_Hieu) LIKE LOWER(?)
            ORDER BY sp.id_Xe DESC
            LIMIT 1";

    $stmt = $this->db->prepare($sql);

    $search = "%" . $tenThuongHieu . "%";
    $stmt->bind_param("s", $search);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

public function lay_san_pham_khuyen_mai()
{
    $sql = "SELECT DISTINCT sp.*, 
                   lx.Ten_Loai_Xe, 
                   th.Ten_Thuong_Hieu, 
                   xm.Gia AS Gia_Mau,
                   ud.Ten_Uu_Dai, ud.Loai, ud.Gia_Tri,
                   ud.Ngay_Bat_Dau, ud.Ngay_Ket_Thuc
            FROM san_pham_xe sp
            JOIN loai_xe lx ON sp.id_Loai_Xe = lx.id_Loai_xe
            JOIN thuong_hieu_xe th ON sp.id_Thuong_Hieu = th.id_Thuong_Hieu
            LEFT JOIN xe_mau xm 
                ON sp.id_Xe = xm.id_Xe AND xm.is_Default = 1
            JOIN xe_uu_dai xud 
                ON sp.id_Xe = xud.id_Xe
            JOIN uu_dai ud 
                ON xud.id_Uu_Dai = ud.id_Uu_Dai
            WHERE sp.Trang_Thai = 1
              AND ud.Trang_Thai = 1
              AND CURDATE() >= ud.Ngay_Bat_Dau
              AND CURDATE() <= ud.Ngay_Ket_Thuc
            ORDER BY sp.id_Xe DESC";

    $result = $this->db->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // 🔥 lấy giá mẫu (nếu null thì = 0)
        $gia = isset($row['Gia_Mau']) ? $row['Gia_Mau'] : 0;

        // 🔥 tính giá sau khuyến mãi
        if ($row['Loai'] == 'tien_mat') {
            $row['Gia_Sau_KM'] = $gia - $row['Gia_Tri'];
        } 
        else if ($row['Loai'] == 'phan_tram') {
            $row['Gia_Sau_KM'] = $gia - ($gia * $row['Gia_Tri'] / 100);
        } 
        else {
            $row['Gia_Sau_KM'] = $gia;
        }

        // 🔥 tránh giá âm
        if ($row['Gia_Sau_KM'] < 0) {
            $row['Gia_Sau_KM'] = 0;
        }

        // 🔥 thêm % giảm (xài cho UI đẹp)
        if ($gia > 0) {
            $row['Phan_Tram_Giam'] = round((($gia - $row['Gia_Sau_KM']) / $gia) * 100);
        } else {
            $row['Phan_Tram_Giam'] = 0;
        }

        $data[] = $row;
    }

    return $data;
}

public function lay_xe_khach($id_khachhang) {
    $id_khachhang = (int)$id_khachhang; // Ép kiểu để an toàn
    $sql = "
        SELECT 
            xm.id_Xe_Mau, 
            spx.Ten_Xe, 
            mx.Ten_Mau, 
            th.Ten_Thuong_Hieu,
            lx.Ten_Loai_Xe
        FROM don_hang dh
        JOIN xe_mau xm ON dh.id_Xe_Mau = xm.id_Xe_Mau
        JOIN san_pham_xe spx ON xm.id_Xe = spx.id_Xe
        JOIN mau_xe mx ON xm.id_Mau = mx.id_Mau
        JOIN thuong_hieu_xe th ON spx.id_Thuong_Hieu = th.id_Thuong_Hieu
        JOIN loai_xe lx ON spx.id_Loai_Xe = lx.id_Loai_xe
        WHERE dh.id_Khach_Hang = $id_khachhang
        AND dh.Trang_Thai IN ('da_coc', 'da_ky', 'da_giao')
    ";

    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// tạo đơn hàng 
public function tao_don_dat_coc($id_kh, $id_xe_mau)
{
    $id_kh = (int)$id_kh;
    $id_xe_mau = (int)$id_xe_mau;

    // ===== lấy xe =====
    $xe = $this->lay_xe_mau($id_xe_mau);
    if(!$xe) return false;

    $gia = $xe['Gia'];

    // ===== ưu đãi =====
    $uu_dai = $this->uu_dai_cua_xe($id_xe_mau);

    $max_giam = 0;

    foreach($uu_dai as $ud){

        $giam = 0;

        if($ud['Loai'] == 'phan_tram'){
            $giam = $gia * $ud['Gia_Tri'] / 100;
        }

        if($ud['Loai'] == 'tien'){
            $giam = $ud['Gia_Tri'];
        }

        if($giam > $max_giam){
            $max_giam = $giam;
        }
    }

    $tong = $gia - $max_giam;
    if($tong < 0) $tong = 0;

    $tien_coc = $tong * 0.01;

    $now = date('Y-m-d H:i:s');

    // ===== insert =====
    $sql = "INSERT INTO don_hang 
        (id_Khach_Hang, id_Xe_Mau, Tong_Tien, Tien_Coc, payment_status, Trang_Thai, Ngay_Tao)
        VALUES
        ($id_kh, $id_xe_mau, $tong, $tien_coc, 'pending', 'new', '$now')";

    $this->db->query($sql);

    return $this->db->insert_id;
}

public function lay_don($id)
{
    $id = (int)$id;

    $sql = "SELECT * FROM don_hang WHERE id_Don_Hang = $id";

    $result = $this->db->query($sql);

    return ($row = $result->fetch_assoc()) ? (object)$row : null;
}
public function cap_nhat_payment_status($id, $status)
{
    $id = (int)$id;
    $status = $this->db->real_escape_string($status);

    $sql = "UPDATE don_hang 
            SET payment_status = '$status'
            WHERE id_Don_Hang = $id";

    return $this->db->query($sql);
}
public function thanh_toan_thanh_cong($id, $ma_gd)
{
    $id = (int)$id;
    $now = date('Y-m-d H:i:s');

    $sql = "UPDATE don_hang 
            SET payment_status = 'paid',
                Trang_Thai = 'da_coc',
                Ngay_Cap_Nhat = '$now'
            WHERE id_Don_Hang = $id
            AND payment_status = 'pending'";

    return $this->db->query($sql);
}
}
?>



