-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 12:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_Ad` int(10) UNSIGNED NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `PassWord` varchar(255) NOT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_Ad`, `UserName`, `PassWord`, `Trang_Thai`, `created_at`) VALUES
(1, 'admin', '$2y$10$hTobG/wMFI.6u1HGNC/0B..fMm5WMZ/ApvD16PxQFZSE3mFbJkSei', 1, '2025-12-28 11:53:12'),
(2, 'admin1', '$2y$10$/FPHMixyJU9eB52Sg97gNecSaqXCY2bVhr1x/LNznND6JsiSa/rFa', 1, '2026-01-11 07:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `dat_lich_lai_thu`
--

CREATE TABLE `dat_lich_lai_thu` (
  `id_Dat_Lich` int(11) NOT NULL,
  `id_Khach_Hang` int(11) DEFAULT NULL,
  `id_Xe` int(11) DEFAULT NULL,
  `Ngay_Lai_Thu` date DEFAULT NULL,
  `id_Khung_Gio` int(11) DEFAULT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id_Don_Hang` int(10) UNSIGNED NOT NULL,
  `id_Khach_Hang` int(10) UNSIGNED NOT NULL,
  `id_Xe_Mau` int(10) UNSIGNED NOT NULL,
  `Gia_Goc` bigint(20) NOT NULL,
  `Gia_Giam` bigint(20) DEFAULT 0,
  `Tong_Tien` bigint(20) NOT NULL,
  `Trang_Thai` enum('cho_duyet','da_duyet','da_len_don','tu_choi') DEFAULT 'cho_duyet',
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ngay_Cap_Nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goi_bao_duong`
--

CREATE TABLE `goi_bao_duong` (
  `id_goi` int(10) UNSIGNED NOT NULL,
  `ten_goi` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `gia` bigint(20) NOT NULL,
  `trang_thai` tinyint(4) DEFAULT 1,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id_Khach_Hang` int(10) UNSIGNED NOT NULL,
  `Ho_Ten` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `So_Dien_Thoai` varchar(20) NOT NULL,
  `Mat_Khau` varchar(255) NOT NULL,
  `Dia_Chi` varchar(255) DEFAULT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ngay_Cap_Nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id_Khach_Hang`, `Ho_Ten`, `Email`, `So_Dien_Thoai`, `Mat_Khau`, `Dia_Chi`, `Trang_Thai`, `Ngay_Tao`, `Ngay_Cap_Nhat`) VALUES
(2, 'kiệt', 'sontonmtp@gmail.com', '0908954822', '$2y$10$Tnw0Gafdz1.PQw4anw1GCu5qlCop2FrBFRBweJmJMLx872Mzxmpva', '35/tên lữa', 1, '2026-01-05 01:07:09', '2026-01-05 01:07:09'),
(4, 'phan tuấn kiệt ', 'phantuankiet3008@gmail.com', '0908954123', '$2y$10$LHirMOYN1juLVstvKq2IuOYWUl5vILWn33IgmyyFOH/FsUq6Al0Du', NULL, 1, '2026-01-30 01:56:19', '2026-01-30 01:57:25'),
(5, 'teo', 'teo@gmail.com', '0777601452', '$2y$10$FUe0Kp/nKs/Hf6qn4XAsYO1qM4No7I494XrSAbHW/MoplsLpX93xS', NULL, 1, '2026-01-30 09:49:52', '2026-01-30 09:49:52'),
(6, 'top', 'top@gmail.com', '12345678910', '$2y$10$6m4TVZcMs33r3/vtjC4gT.VwuODhL36ZAZDBoruB5f/DyM8kX9jIu', NULL, 1, '2026-01-30 10:06:12', '2026-01-30 10:06:12'),
(7, 'pot', 'pot@gmail.com', '12345678911', '$2y$10$dUCNepc8r2UJzeXL1dwayuWodSATPcX6GshEU/vBvpkIL0PvOeYRC', NULL, 1, '2026-01-30 10:07:43', '2026-01-30 10:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `khung_gio_lai_thu`
--

CREATE TABLE `khung_gio_lai_thu` (
  `id_Khung_Gio` int(11) NOT NULL,
  `Gio_Bat_Dau` time NOT NULL,
  `Gio_Ket_Thuc` time NOT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lich_bao_duong`
--

CREATE TABLE `lich_bao_duong` (
  `id_lich` int(10) UNSIGNED NOT NULL,
  `id_Khach_Hang` int(10) UNSIGNED NOT NULL,
  `id_Xe_Mau` int(10) UNSIGNED NOT NULL,
  `id_goi` int(10) UNSIGNED NOT NULL,
  `ngay_bao_duong` date NOT NULL COMMENT 'Khách giao xe trong khung giờ 6h-11h sáng',
  `trang_thai` enum('cho_xac_nhan','da_xac_nhan','dang_bao_duong','hoan_thanh','huy') DEFAULT 'cho_xac_nhan',
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loai_xe`
--

CREATE TABLE `loai_xe` (
  `id_Loai_xe` int(10) UNSIGNED NOT NULL,
  `Ten_Loai_Xe` varchar(100) NOT NULL,
  `Slug` varchar(120) NOT NULL,
  `Mo_Ta` text DEFAULT NULL,
  `Hinh_Anh_Loai` varchar(255) DEFAULT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai_xe`
--

INSERT INTO `loai_xe` (`id_Loai_xe`, `Ten_Loai_Xe`, `Slug`, `Mo_Ta`, `Hinh_Anh_Loai`, `Trang_Thai`, `Ngay_Tao`) VALUES
(1, 'Sedan', 'sedan', 'Dòng xe 4 cửa, gầm thấp, thiết kế sang trọng lịch lãm phù hợp gia đình.', 'sedan.png', 1, '2025-12-30 11:54:45'),
(2, 'SUV', 'suv', 'Dòng xe thể thao đa dụng, gầm cao, không gian rộng rãi, vượt địa hình tốt.', 'suv.png', 1, '2025-12-30 11:54:45'),
(3, 'Hatchback', 'hatchback', 'Dòng xe nhỏ gọn, phần đuôi thẳng, phù hợp di chuyển trong đô thị.', 'hatchback.png', 1, '2025-12-30 11:54:45'),
(4, 'MPV / Xe Đa Dụng', 'mpv', 'Dòng xe gia đình 7 chỗ, không gian linh hoạt, tối ưu diện tích.', 'mpv.png', 1, '2025-12-30 11:54:45'),
(5, 'Bán Tải (Pickup)', 'pickup', 'Dòng xe vừa chở người vừa có thùng chở hàng phía sau, động cơ mạnh mẽ.', 'pickup.png', 1, '2025-12-30 11:54:45'),
(6, 'Coupe', 'coupe', 'Dòng xe thể thao 2 cửa, mui kín, thiết kế khí động học mạnh mẽ.', 'coupe.png', 1, '2025-12-30 11:54:45'),
(7, 'Xe Điện (EV)', 'xe-dien', 'Dòng xe sử dụng động cơ điện hoàn toàn, thân thiện với môi trường.', 'ev.png', 1, '2025-12-30 11:54:45'),
(8, 'Xe Cơ Bắp', 'xe-co-bap', 'Dòng xe hiệu năng cao đặc trưng của Mỹ với động cơ V8 mạnh mẽ.', 'muscle-car.jpg', 1, '2026-01-01 10:54:48'),
(9, 'Xe Thể Thao', 'xe-the-thao', 'Các dòng xe thiết kế 2 cửa, ưu tiên tốc độ và cảm giác lái.', 'sports-car.jpg', 1, '2026-01-01 10:54:48'),
(10, 'Xe Siêu Sang', 'xe-sieu-sang', 'Dòng xe tập trung vào sự xa hoa và tiện nghi bậc nhất.', 'luxury-car.jpg', 1, '2026-01-01 10:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `mau_xe`
--

CREATE TABLE `mau_xe` (
  `id_Mau` int(10) UNSIGNED NOT NULL,
  `Ten_Mau` varchar(50) NOT NULL,
  `Ma_Mau` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mau_xe`
--

INSERT INTO `mau_xe` (`id_Mau`, `Ten_Mau`, `Ma_Mau`) VALUES
(1, 'Trắng Tuyết (Snow White)', '#FFFFFF'),
(2, 'Đen Huyền Bí (Crystal Black)', '#000000'),
(3, 'Bạc Ánh Kim (Silver Metallic)', '#C0C0C0'),
(4, 'Xám Ghi (Modern Steel)', '#696969'),
(5, 'Đỏ Ruby (Red Soul)', '#CC0000'),
(6, 'Xanh Dương Đậm (Deep Blue)', '#003399'),
(7, 'Nâu Cafe (Brown Sand)', '#4B3621'),
(8, 'Vàng Cát (Champagne Gold)', '#E3D2B3'),
(9, 'Trắng Ngọc Trai (Pearl White)', '#F5F5F5'),
(10, 'Xám Xi Măng (Sonic Grey)', '#808080'),
(11, 'Xanh Da Trời (Sky Blue)', '#87CEEB'),
(12, 'Cam Rực Rỡ (Orange Metallic)', '#FF8C00'),
(13, 'Vàng Chanh (Yellow Sunlight)', '#FFFF00'),
(14, 'Xanh Lá Phong (Forest Green)', '#228B22'),
(15, 'Đỏ Mận (Wine Red)', '#722F37'),
(16, 'Xám Chuột (Dark Grey)', '#4F4F4F'),
(17, 'Đồng Ánh Kim (Bronze)', '#CD7F32'),
(18, 'Xanh Lục Bảo (Emerald Green)', '#006400'),
(19, 'Tím Than (Midnight Purple)', '#2E1A47'),
(20, 'Hồng Phấn (Rose Pink)', '#FFB6C1'),
(21, 'Brittany Blue', '#4F86B3'),
(22, 'Wimbledon White', '#F5F5F5'),
(23, 'Grabber Blue', '#00A1E4'),
(24, 'Cyber Orange', '#FFB400'),
(25, 'Shadow Black', '#000000'),
(26, 'Rapid Red', '#B20000'),
(27, 'Dark Matter Gray', '#3E4142');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham_xe`
--

CREATE TABLE `san_pham_xe` (
  `id_Xe` int(10) UNSIGNED NOT NULL,
  `Ten_Xe` varchar(255) NOT NULL,
  `Mo_Ta` text DEFAULT NULL,
  `Anh_Dai_Dien` varchar(255) NOT NULL,
  `Anh_3d` varchar(255) DEFAULT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_Loai_Xe` int(10) UNSIGNED DEFAULT NULL,
  `id_Thuong_Hieu` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `san_pham_xe`
--

INSERT INTO `san_pham_xe` (`id_Xe`, `Ten_Xe`, `Mo_Ta`, `Anh_Dai_Dien`, `Anh_3d`, `Trang_Thai`, `Ngay_Tao`, `id_Loai_Xe`, `id_Thuong_Hieu`) VALUES
(21, 'Ford Mustang Shelby GT500 Heritage Edition (2022)', 'Carroll Shelby gọi chiếc Shelby GT500 đời đầu là \"chiếc xe thực sự đầu tiên mà tôi thực sự tự hào\". Shelby GT500 vẫn mang tính biểu tượng như ngày nay - là chiếc Mustang mạnh mẽ và tiên tiến nhất từ trước đến nay - giống như phiên bản đầu tiên cách đây 55 năm.  Để tri ân chiếc Shelby GT500 nguyên bản năm 1967, phiên bản giới hạn Mustang Shelby GT500 Heritage Edition 2022 sẽ được hoàn thiện với màu sơn ngoại thất Brittany Blue cổ điển và độc quyền, cùng hai tùy chọn sọc ngoại thất Wimbledon White khác nhau:  Sơn sọc đua nổi bật với logo GT500 độc đáo (cũng có màu Đen tuyền).  Các đường sọc đua bằng vinyl cực chất với sọc vinyl độc đáo ở bên hông xe có logo GT500.  Được thiết kế và chế tạo bởi Ford Performance như chiếc Ford mạnh mẽ nhất từng được phép lưu hành trên đường phố, Mustang Shelby GT500 2022 sở hữu sức mạnh và công nghệ hệ thống truyền động hàng đầu thế giới để đạt được hiệu suất ngang tầm siêu xe. Các tính năng nổi bật bao gồm hộp số ly hợp kép 7 cấp tiên tiến nhất trong phân khúc, các chiến lược đi', '1768037246_Ford_Mustang_Shelby_GT500_Heritage_Edition_(2022).png', '3d_1768037246_car_002.glb', 1, '2026-01-10 09:27:26', 9, 7),
(22, 'VinFast VF8 Eco', 'công suất tối đa  260KW(349 mã lực) .Mô-men xoắn	500 Nm.Tăng tốc (0-100km/h)~5.9 giây.Hệ dẫn động	2 cầu toàn thời gian (AWD).Quãng đường (WLTP)	~471 km (Đi xa hơn).Dung lượng pin	87,7 kWh.', '1769772443_1769591870_vinfast_VF8_Eco.jpg', '', 1, '2026-01-30 11:27:23', 7, 6),
(23, 'VinFast VF8 Plus', 'Công suất tối đa:300 kW (~402 mã lực).Mô-men xoắn:620 Nm.Tăng tốc (0-100km/h)~5.5 giây.Hệ dẫn động2 cầu toàn thời gian (AWD).Quãng đường (WLTP)~457 km.Dung lượng pin 87,7 kWh', '1769774027_VF8_Plus_đen_đồng.png', '', 1, '2026-01-30 11:53:47', 7, 6),
(24, 'FORD RANGER ', 'Dài x rộng x Cao (mm) 3090 x 1496 x 1663,2 Chiều dài cơ sở 2065 mm Khoảng sáng gầm xe 166,3 mm Công suất tối đa 30 kW Mô men xoắn cực đại 65 Nm Quãng đường chạy (NEDC) 210 km/lần sạc đầy Dung lượng pin khả dụng 18,3 kWh Công suất sạc tối đa ≥24 kW Dẫn động RWD/Cầu sau Chế độ lái Eco/Normal Hệ thống treo (trước/sau) MacPherson/MacPherson Hệ thống phanh (trước/sau) Đĩa/Tang trống Kích thước la-zăng 13 inch Đèn chiếu sáng phía trước LED Đóng/mở cốp sau Chỉnh cơ Hệ thống điều hòa Máy lạnh, chỉnh cơ Màn hình thông tin lái 7’’ inch Chức năng giải trí FM Hệ thống loa 2 loa Ghế lái Chỉnh cơ 4 hướng', '1769775946_Ford_Ranger_Raptor_cam.png', '3d_1769775946_car_002.glb', 1, '2026-01-30 12:25:46', 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `thuong_hieu_xe`
--

CREATE TABLE `thuong_hieu_xe` (
  `id_Thuong_Hieu` int(10) UNSIGNED NOT NULL,
  `Ma_Thuong_Hieu` varchar(20) NOT NULL,
  `Ten_Thuong_Hieu` varchar(100) NOT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ngay_Cap_Nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuong_hieu_xe`
--

INSERT INTO `thuong_hieu_xe` (`id_Thuong_Hieu`, `Ma_Thuong_Hieu`, `Ten_Thuong_Hieu`, `Logo`, `Trang_Thai`, `Ngay_Tao`, `Ngay_Cap_Nhat`) VALUES
(1, 'TOY', 'Toyota', 'toyota_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(2, 'HON', 'Honda', 'honda_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(3, 'HYU', 'Hyundai', 'hyundai_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(4, 'KIA', 'Kia', 'kia_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(5, 'MAZ', 'Mazda', 'mazda_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(6, 'VIN', 'VinFast', 'vinfast_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(7, 'FOR', 'Ford', 'ford_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(8, 'MER', 'Mercedes-Benz', 'mercedes_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(9, 'BMW', 'BMW', 'bmw_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21'),
(10, 'MIT', 'Mitsubishi', 'mitsubishi_logo.png', 1, '2025-12-30 12:02:21', '2025-12-30 12:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `uu_dai`
--

CREATE TABLE `uu_dai` (
  `id_Uu_Dai` int(10) UNSIGNED NOT NULL,
  `Ten_Uu_Dai` varchar(150) NOT NULL,
  `Loai` enum('phan_tram','tien_mat') NOT NULL,
  `Gia_Tri` bigint(20) NOT NULL,
  `Ngay_Bat_Dau` date NOT NULL,
  `Ngay_Ket_Thuc` date NOT NULL,
  `Trang_Thai` tinyint(4) DEFAULT 1,
  `Ngay_Tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uu_dai`
--

INSERT INTO `uu_dai` (`id_Uu_Dai`, `Ten_Uu_Dai`, `Loai`, `Gia_Tri`, `Ngay_Bat_Dau`, `Ngay_Ket_Thuc`, `Trang_Thai`, `Ngay_Tao`) VALUES
(1, 'tri ân khách hàng', 'tien_mat', 100000000, '2026-01-01', '2026-01-31', 1, '2026-01-12 01:41:48'),
(2, 'tri ân khách hàng', 'tien_mat', 100000000, '2026-01-01', '2026-01-31', 1, '2026-01-12 01:43:07'),
(3, 'tri ân khách hàng', 'tien_mat', 100000000, '2026-01-01', '2026-02-01', 1, '2026-01-12 01:43:50'),
(4, 'tri ân khách hàng', 'tien_mat', 100000000, '2026-01-01', '2026-02-01', 1, '2026-01-12 01:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `xe_mau`
--

CREATE TABLE `xe_mau` (
  `id_Xe_Mau` int(10) UNSIGNED NOT NULL,
  `id_Xe` int(10) UNSIGNED NOT NULL,
  `id_Mau` int(10) UNSIGNED NOT NULL,
  `is_Default` tinyint(4) DEFAULT 0,
  `Gia` decimal(12,0) NOT NULL,
  `So_Luong` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe_mau`
--

INSERT INTO `xe_mau` (`id_Xe_Mau`, `id_Xe`, `id_Mau`, `is_Default`, `Gia`, `So_Luong`) VALUES
(5, 21, 21, 1, 7810000000, 1),
(6, 22, 9, 1, 1019000000, 0),
(7, 22, 15, 0, 1010000000, 0),
(8, 22, 2, 0, 1090000000, 0),
(9, 23, 2, 1, 1198000000, 0),
(10, 23, 15, 0, 1198000000, 0),
(11, 24, 12, 1, 1306000000, 0),
(12, 24, 26, 0, 1308000000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `xe_mau_anh`
--

CREATE TABLE `xe_mau_anh` (
  `id_Xe_Mau_Anh` int(10) UNSIGNED NOT NULL,
  `id_Xe_Mau` int(10) UNSIGNED NOT NULL,
  `Hinh_Anh_Xe_Mau` varchar(255) NOT NULL,
  `Thu_Tu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe_mau_anh`
--

INSERT INTO `xe_mau_anh` (`id_Xe_Mau_Anh`, `id_Xe_Mau`, `Hinh_Anh_Xe_Mau`, `Thu_Tu`) VALUES
(15, 5, '1768037246_69621b7e7b79e.png', NULL),
(16, 5, '1768037246_69621b7e7bf7c.png', NULL),
(17, 5, '1768037246_69621b7e7c57f.png', NULL),
(18, 5, '1768037246_69621b7e7cc0c.png', NULL),
(19, 6, '1769772443_697c959b0ebf5.jpg', NULL),
(20, 6, '1769772443_697c959b0f25e.jpg', NULL),
(21, 6, '1769772443_697c959b0f875.png', NULL),
(22, 6, '1769772443_697c959b1061d.png', NULL),
(23, 6, '1769772443_697c959b10c14.png', NULL),
(24, 6, '1769772443_697c959b111b8.png', NULL),
(25, 6, '1769772443_697c959b116bd.png', NULL),
(26, 7, '1769772443_697c959b1210b.png', NULL),
(27, 7, '1769772443_697c959b126fc.png', NULL),
(28, 7, '1769772443_697c959b12c99.png', NULL),
(29, 7, '1769772443_697c959b1315b.png', NULL),
(30, 7, '1769772443_697c959b13744.png', NULL),
(31, 7, '1769772443_697c959b13d0a.png', NULL),
(32, 8, '1769772443_697c959b146a7.png', NULL),
(33, 8, '1769772443_697c959b14c0e.png', NULL),
(34, 8, '1769772443_697c959b1511c.png', NULL),
(35, 8, '1769772443_697c959b15756.png', NULL),
(36, 8, '1769772443_697c959b15d1c.png', NULL),
(37, 8, '1769772443_697c959b1631a.png', NULL),
(38, 9, '1769774027_697c9bcb17951.png', NULL),
(39, 9, '1769774027_697c9bcb17fd2.png', NULL),
(40, 9, '1769774027_697c9bcb184e0.png', NULL),
(41, 9, '1769774027_697c9bcb18a1e.png', NULL),
(42, 9, '1769774027_697c9bcb18e57.png', NULL),
(43, 9, '1769774027_697c9bcb193d6.png', NULL),
(44, 9, '1769774027_697c9bcb197ba.png', NULL),
(45, 10, '1769774027_697c9bcb19e60.png', NULL),
(46, 10, '1769774027_697c9bcb1a3f9.png', NULL),
(47, 10, '1769774027_697c9bcb1a935.png', NULL),
(48, 10, '1769774027_697c9bcb1aca6.png', NULL),
(49, 10, '1769774027_697c9bcb1b02c.png', NULL),
(50, 10, '1769774027_697c9bcb1b380.png', NULL),
(51, 10, '1769774027_697c9bcb1b70e.png', NULL),
(52, 11, '1769775946_697ca34a975ee.png', NULL),
(53, 11, '1769775946_697ca34a97c2f.png', NULL),
(54, 11, '1769775946_697ca34a9810b.png', NULL),
(55, 11, '1769775946_697ca34a984fb.png', NULL),
(56, 11, '1769775946_697ca34a988c4.png', NULL),
(57, 11, '1769775946_697ca34a98c4b.png', NULL),
(58, 11, '1769775946_697ca34a98fea.png', NULL),
(59, 11, '1769775946_697ca34a99531.png', NULL),
(60, 11, '1769775946_697ca34a99e82.png', NULL),
(61, 11, '1769775946_697ca34a9a870.png', NULL),
(62, 12, '1769775946_697ca34a9b831.png', NULL),
(63, 12, '1769775946_697ca34a9be15.png', NULL),
(64, 12, '1769775946_697ca34a9c201.png', NULL),
(65, 12, '1769775946_697ca34a9c5ed.png', NULL),
(66, 12, '1769775946_697ca34a9ca48.png', NULL),
(67, 12, '1769775946_697ca34a9ce95.png', NULL),
(68, 12, '1769775946_697ca34a9d375.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xe_uu_dai`
--

CREATE TABLE `xe_uu_dai` (
  `id_Xe` int(10) UNSIGNED NOT NULL,
  `id_Uu_Dai` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe_uu_dai`
--

INSERT INTO `xe_uu_dai` (`id_Xe`, `id_Uu_Dai`) VALUES
(21, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_Ad`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `dat_lich_lai_thu`
--
ALTER TABLE `dat_lich_lai_thu`
  ADD PRIMARY KEY (`id_Dat_Lich`),
  ADD KEY `id_Khung_Gio` (`id_Khung_Gio`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id_Don_Hang`),
  ADD KEY `id_Khach_Hang` (`id_Khach_Hang`),
  ADD KEY `id_Xe_Mau` (`id_Xe_Mau`);

--
-- Indexes for table `goi_bao_duong`
--
ALTER TABLE `goi_bao_duong`
  ADD PRIMARY KEY (`id_goi`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id_Khach_Hang`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `So_Dien_Thoai` (`So_Dien_Thoai`);

--
-- Indexes for table `khung_gio_lai_thu`
--
ALTER TABLE `khung_gio_lai_thu`
  ADD PRIMARY KEY (`id_Khung_Gio`);

--
-- Indexes for table `lich_bao_duong`
--
ALTER TABLE `lich_bao_duong`
  ADD PRIMARY KEY (`id_lich`),
  ADD KEY `id_Khach_Hang` (`id_Khach_Hang`),
  ADD KEY `id_Xe_Mau` (`id_Xe_Mau`),
  ADD KEY `id_goi` (`id_goi`);

--
-- Indexes for table `loai_xe`
--
ALTER TABLE `loai_xe`
  ADD PRIMARY KEY (`id_Loai_xe`),
  ADD UNIQUE KEY `Ten_Loai_Xe` (`Ten_Loai_Xe`),
  ADD UNIQUE KEY `Slug` (`Slug`);

--
-- Indexes for table `mau_xe`
--
ALTER TABLE `mau_xe`
  ADD PRIMARY KEY (`id_Mau`);

--
-- Indexes for table `san_pham_xe`
--
ALTER TABLE `san_pham_xe`
  ADD PRIMARY KEY (`id_Xe`),
  ADD KEY `id_Loai_Xe` (`id_Loai_Xe`),
  ADD KEY `id_Thuong_Hieu` (`id_Thuong_Hieu`);

--
-- Indexes for table `thuong_hieu_xe`
--
ALTER TABLE `thuong_hieu_xe`
  ADD PRIMARY KEY (`id_Thuong_Hieu`),
  ADD UNIQUE KEY `Ma_Thuong_Hieu` (`Ma_Thuong_Hieu`);

--
-- Indexes for table `uu_dai`
--
ALTER TABLE `uu_dai`
  ADD PRIMARY KEY (`id_Uu_Dai`);

--
-- Indexes for table `xe_mau`
--
ALTER TABLE `xe_mau`
  ADD PRIMARY KEY (`id_Xe_Mau`),
  ADD UNIQUE KEY `uq_xe_mau` (`id_Xe`,`id_Mau`),
  ADD KEY `id_Mau` (`id_Mau`);

--
-- Indexes for table `xe_mau_anh`
--
ALTER TABLE `xe_mau_anh`
  ADD PRIMARY KEY (`id_Xe_Mau_Anh`),
  ADD KEY `id_Xe_Mau` (`id_Xe_Mau`);

--
-- Indexes for table `xe_uu_dai`
--
ALTER TABLE `xe_uu_dai`
  ADD PRIMARY KEY (`id_Xe`,`id_Uu_Dai`),
  ADD KEY `id_Uu_Dai` (`id_Uu_Dai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_Ad` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dat_lich_lai_thu`
--
ALTER TABLE `dat_lich_lai_thu`
  MODIFY `id_Dat_Lich` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id_Don_Hang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goi_bao_duong`
--
ALTER TABLE `goi_bao_duong`
  MODIFY `id_goi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id_Khach_Hang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `khung_gio_lai_thu`
--
ALTER TABLE `khung_gio_lai_thu`
  MODIFY `id_Khung_Gio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lich_bao_duong`
--
ALTER TABLE `lich_bao_duong`
  MODIFY `id_lich` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loai_xe`
--
ALTER TABLE `loai_xe`
  MODIFY `id_Loai_xe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mau_xe`
--
ALTER TABLE `mau_xe`
  MODIFY `id_Mau` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `san_pham_xe`
--
ALTER TABLE `san_pham_xe`
  MODIFY `id_Xe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `thuong_hieu_xe`
--
ALTER TABLE `thuong_hieu_xe`
  MODIFY `id_Thuong_Hieu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `uu_dai`
--
ALTER TABLE `uu_dai`
  MODIFY `id_Uu_Dai` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xe_mau`
--
ALTER TABLE `xe_mau`
  MODIFY `id_Xe_Mau` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `xe_mau_anh`
--
ALTER TABLE `xe_mau_anh`
  MODIFY `id_Xe_Mau_Anh` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dat_lich_lai_thu`
--
ALTER TABLE `dat_lich_lai_thu`
  ADD CONSTRAINT `dat_lich_lai_thu_ibfk_1` FOREIGN KEY (`id_Khung_Gio`) REFERENCES `khung_gio_lai_thu` (`id_Khung_Gio`);

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_Khach_Hang`) REFERENCES `khach_hang` (`id_Khach_Hang`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`id_Xe_Mau`) REFERENCES `xe_mau` (`id_Xe_Mau`);

--
-- Constraints for table `lich_bao_duong`
--
ALTER TABLE `lich_bao_duong`
  ADD CONSTRAINT `lich_bao_duong_ibfk_1` FOREIGN KEY (`id_Khach_Hang`) REFERENCES `khach_hang` (`id_Khach_Hang`),
  ADD CONSTRAINT `lich_bao_duong_ibfk_2` FOREIGN KEY (`id_Xe_Mau`) REFERENCES `xe_mau` (`id_Xe_Mau`),
  ADD CONSTRAINT `lich_bao_duong_ibfk_3` FOREIGN KEY (`id_goi`) REFERENCES `goi_bao_duong` (`id_goi`);

--
-- Constraints for table `san_pham_xe`
--
ALTER TABLE `san_pham_xe`
  ADD CONSTRAINT `san_pham_xe_ibfk_1` FOREIGN KEY (`id_Loai_Xe`) REFERENCES `loai_xe` (`id_Loai_xe`),
  ADD CONSTRAINT `san_pham_xe_ibfk_2` FOREIGN KEY (`id_Thuong_Hieu`) REFERENCES `thuong_hieu_xe` (`id_Thuong_Hieu`);

--
-- Constraints for table `xe_mau`
--
ALTER TABLE `xe_mau`
  ADD CONSTRAINT `xe_mau_ibfk_1` FOREIGN KEY (`id_Xe`) REFERENCES `san_pham_xe` (`id_Xe`) ON DELETE CASCADE,
  ADD CONSTRAINT `xe_mau_ibfk_2` FOREIGN KEY (`id_Mau`) REFERENCES `mau_xe` (`id_Mau`) ON DELETE CASCADE;

--
-- Constraints for table `xe_mau_anh`
--
ALTER TABLE `xe_mau_anh`
  ADD CONSTRAINT `xe_mau_anh_ibfk_1` FOREIGN KEY (`id_Xe_Mau`) REFERENCES `xe_mau` (`id_Xe_Mau`) ON DELETE CASCADE;

--
-- Constraints for table `xe_uu_dai`
--
ALTER TABLE `xe_uu_dai`
  ADD CONSTRAINT `xe_uu_dai_ibfk_1` FOREIGN KEY (`id_Xe`) REFERENCES `san_pham_xe` (`id_Xe`) ON DELETE CASCADE,
  ADD CONSTRAINT `xe_uu_dai_ibfk_2` FOREIGN KEY (`id_Uu_Dai`) REFERENCES `uu_dai` (`id_Uu_Dai`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
