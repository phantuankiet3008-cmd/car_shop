{{-- index_AD.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Admin</title>
    <link rel="stylesheet" href="{{ asset('admin/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="admin-wrapper">
        <!-- ⬅️ WRAPPER MỚI -->

        <!-- ĐẦU TRANG -->
        <div class="dau_trang">
            <button id="toggleMenu" class="btn_menu">☰</button>
            <h2 class="title_trang">TRANG QUẢN TRỊ</h2>
            Chào mừng bạn đến với trang quản trị.
            Hãy chọn một mục từ menu bên trái để bắt đầu quản lý.
            <a href="{{ route('admin.logout') }}" class="logout">Đăng xuất</a>
        </div>

        <!-- BODY -->
        <div class="body_trang">

            <!-- MENU TRÁI -->
            <div class="left_menu">
                <ul class="menu_admin">
<<<<<<< feature-DangNhapQL
                    <li class="menu_item"><a href="{{ url('/trang_admin/loai_xe') }}"><i
                                class="fa-solid fa-layer-group"></i>Loại Xe</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/thuong_hieu') }}"><i
                                class="fa-solid fa-copyright"></i>Thương Hiệu</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/san_pham') }}"><i
                                class="fa-solid fa-car"></i>Sản Phẩm</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/khach_hang') }}"><i
                                class="fa-solid fa-users"></i>Khách Hàng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/don_hang') }}"><i
                                class="fa-solid fa-cart-shopping"></i>Đơn Hàng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/uu_dai') }}"><i
                                class="fa-solid fa-tags"></i>Quản Lý Ưu Đãi</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/lai_thu') }}"><i
                                class="fa-solid fa-calendar-check"></i>Đặt Lịch Lái Thử</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/baoduong') }}"><i
                                class="fa-solid fa-screwdriver-wrench"></i>Đặt Lịch Bảo Dưỡng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/kiem_ke') }}"><i
                                class="fa-solid fa-clipboard-list"></i>Kiểm Kê</a></li>
=======

                    <li class="menu_item"><a href="{{ url('/trang_admin/loai_xe') }}"><i class="fa-solid fa-layer-group"></i>Loại Xe</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/thuong_hieu') }}"><i class="fa-solid fa-copyright"></i>Thương Hiệu</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/san_pham') }}"><i class="fa-solid fa-car"></i>Sản Phẩm</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/khach_hang') }}"><i class="fa-solid fa-users"></i>Khách Hàng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/don_hang') }}"><i class="fa-solid fa-cart-shopping"></i>Đơn Hàng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/uu_dai') }}"><i class="fa-solid fa-tags"></i>Quản Lý Ưu Đãi</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/lai_thu') }}"><i class="fa-solid fa-calendar-check"></i>Đặt Lịch Lái Thử</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/baoduong') }}"><i class="fa-solid fa-screwdriver-wrench"></i>Đặt Lịch Bảo Dưỡng</a></li>
                    <li class="menu_item"><a href="{{ url('/trang_admin/kiem_ke') }}"><i class="fa-solid fa-clipboard-list"></i>Kiểm Kê</a></li>
>>>>>>> main
                    <li class="menu_item"><a href="{{ url('/trang_admin/nhan_vien') }}">Nhân Viên</a></li>
                </ul>
            </div>

            <!-- NỘI DUNG -->
            <div class="right_content" id="right_content">

                @if(isset($key))
                @switch($key)
                @case('dashboard')
                <div class="dashboard">
                    <h2>Chào mừng Admin 👋</h2>
                    <p>Chọn chức năng bên trái để quản lý hệ thống.</p>
                </div>
                @break
                @case('dang_xuat')
                @include('admin.layouts.DangXuatADM')
                @break

                @case('loai_xe')
                @include('admin.layouts.QL_loai.List_LoaiXe')
                @break

                @case('Add_Loai_Xe')
                @include('admin.layouts.QL_loai.them_loaixe')
                @break

                @case('Edit_Loai_Xe')
                @include('admin.layouts.QL_loai.sua_loaixe')
                @break



                @case('thuong_hieu')
                @include('admin.layouts.QL_thuonghieu.List_ThuongHieu')
                @break

                @case('Add_Thuong_Hieu')
                @include('admin.layouts.QL_thuonghieu.them_thuonghieu')
                @break

                @case('Edit_Thuong_Hieu')
                @include('admin.layouts.QL_thuonghieu.sua_thuonghieu')
                @break



                @case('san_pham')
                @include('admin.layouts.QL_sanpham.San_Pham')
                @break

                @case('Add_San_Pham')
                @include('admin.layouts.QL_sanpham.Add_SanPham')
                @break

                @case('Edit_San_Pham')
                @include('admin.layouts.QL_sanpham.Edit_SanPham')
                @break



                @case('khach_hang')
                @include('admin.layouts.QL_khachhang.listkh')
                @break

                @case('update_kh')
                @include('admin.layouts.QL_khachhang.updatekh')
                @break

                @case('delete_kh')
                @include('admin.layouts.QL_khachhang.deletekh')
                @break

                @case('add_kh')
                @include('admin.layouts.QL_khachhang.addkh')
                @break

                @case('uu_dai')
                @include('admin.layouts.QL_uudai.quanly_uudai')
                @break

                @case('Add_Uu_Dai')
                @include('admin.layouts.QL_uudai.them_uudai')
                @break

                @case('Edit_Uu_Dai')
                @include('admin.layouts.QL_uudai.sua_uudai')
                @break

                @case('delete_Uu_Dai')
                @include('admin.layouts.QL_uudai.xoa_uudai')
                @break

                @case('chitiet_uu_dai')
                @include('admin.layouts.QL_uudai.quanly_xe_uudai')
                @break

                @case('Add_Chi_Tiet_Uu_Dai')
                @include('admin.layouts.QL_uudai.them_xe_uudai')
                @break

                @case('don_hang')
                @include('admin.layouts.QL_donhang.listdonhang')
                @break

                @case('them_don_hang')
                @include('admin.layouts.QL_donhang.ADDdonhang')
                @break

                @case('Edit_Don_Hang')
                @include('admin.layouts.QL_donhang.editdonhang')
                @break

                @case('lai_thu')
                @include('admin.layouts.QL_laithu.LichLaiThu')
                @break
                @case('bao_duong')
                @include('admin.layouts.QL_baoduong.QLBaoDuong')
                @break

                @case('edit_bao_duong')
                @include('admin.layouts.QL_baoduong.EditBaoDuong')
                @break

                @case('goi_bao_duong')
                @include('admin.layouts.QL_baoduong.QLGoiBaoDuong')
                @break

                @case('add_goi_bao_duong')
                @include('admin.layouts.QL_baoduong.AddGoiBaoDuong')
                @break

                @case('edit_goi_bao_duong')
                @include('admin.layouts.QL_baoduong.EditGoiBaoDuong')
                @break

                @case('kiem_ke')
                @include('admin.layouts.Kiem_Ke')
                @break

                @case('nhan_vien')
                @include('admin.layouts.QL_nhanvien.ListNhanVien')
                @break

                @case('add_nhan_vien')
                @include('admin.layouts.QL_nhanvien.AddNhanVien')
                @break

                @case('edit_nhan_vien')
                @include('admin.layouts.QL_nhanvien.EditNhanVien')
                @break

                @endswitch
                @endif

            </div>


        </div>



    </div>

    <script>
    const toggleBtn = document.getElementById('toggleMenu');
    const bodyTrang = document.querySelector('.body_trang');

    toggleBtn.addEventListener('click', () => {
        bodyTrang.classList.toggle('hide-menu');
        toggleBtn.textContent = bodyTrang.classList.contains('hide-menu') ? '✖' : '☰';
    });
    </script>

</body>

</html>