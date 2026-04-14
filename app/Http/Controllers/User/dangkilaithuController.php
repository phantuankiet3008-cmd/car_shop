<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product;
use App\Services\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DangkilaithuController extends Controller
{
    // ===== 1. Load trang =====
   public function index($id_Xe_Mau)
    {
        $sp = new Product();
        $id_Xe_Mau = (int)$id_Xe_Mau;

        
        $checksoluong = $sp->kiemtraxedo($id_Xe_Mau);
       if (!$checksoluong || $checksoluong->num_rows <= 0) {
            return back()->with('error', 'Rất tiếc, mẫu xe màu này hiện đã hết hàng hoặc không khả dụng để lái thử.');
        }

        $thongTinXe = $sp->getThongTinXeTheoXeMau($id_Xe_Mau);
        if (!$thongTinXe) {
            abort(404, 'Không tìm thấy thông tin xe.');
        }

        
        $kg = [];
        $result_khung = $sp->getKhungGio();
        if ($result_khung) {
            while ($row = $result_khung->fetch_assoc()) {
                $kg[] = $row;
            }
        }
        
        return view('user.layouts.DangKiLaiThu', [
            'thongTinXe' => (object)$thongTinXe,
            'khungGio'   => $kg,
        ]);
    }

    
    public function layGioDaDat(Request $request)
    {
        $sp = new Product();

        $ngay = $request->ngay;
        $idXeMau = (int)$request->id_xe_mau;

        $gioDaDat = [];
        $result = $sp->getGioDaDat($ngay, $idXeMau); // bạn phải có function này

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $gioDaDat[] = $row['id_Khung_Gio'];
            }
        }

        return response()->json($gioDaDat);
    }

    
    public function store(Request $request)
    { 
        $sp = new Product();
        $idKhach = session('user_id');

        if (!$idKhach) {
            return redirect('car_shop/dangnhap')->with('error', 'Vui lòng đăng nhập để thực hiện đặt lịch.');
        }

        $idXeMau    = (int)$request->id_xe_mau;
        $ngay       = $request->ngay_lai_thu;
        $idKhungGio = (int)$request->id_Khung_Gio;

        // --- CHỐT CHẶN 2: Kiểm tra lại số lượng một lần nữa trước khi Insert ---
        $checkKho = $sp->kiemtraxedo($idXeMau);
        if (!$checkKho || $checkKho->num_rows <= 0) {
            return redirect('/user/car_shop/tranglaithu')->with('error', 'Mẫu xe này vừa hết hàng, vui lòng chọn mẫu xe khác.');
        }
        
        // Kiểm tra khách đã đặt xe này trong ngày này chưa
        $checkKhach = $sp->kiemTraKhachDaDat($idKhach, $idXeMau, $ngay);
        if ($checkKhach && $checkKhach->num_rows > 0) {
            return back()->with('error', 'Bạn đã có một lịch hẹn lái thử mẫu xe này trong ngày hôm nay.');
        }

        // Kiểm tra khung giờ có bị trùng không (Double check slot)
        $checkSlot = $sp->kiemTraSlotDaDat($idXeMau, $ngay, $idKhungGio);
        if ($checkSlot && $checkSlot->num_rows > 0) {
            return back()->with('error', 'Khung giờ này vừa có người khác nhanh tay đặt mất rồi.');
        }

        try {
            $result = $sp->insertLichLaiThu($idKhach, $idXeMau, $ngay, $idKhungGio);
            return redirect('/user/car_shop/trangcanhan')->with('success', 'Đăng ký lái thử thành công! Chúng tôi sẽ liên hệ sớm.');
        } catch (\Exception $e) {
            return back()->with('error', 'Hệ thống bận, vui lòng thử lại sau vài phút.');
        }
    }
 public function lichCuaToi()
{
    $User = new User();

    $idKhach = session('user_id');   

    if (!$idKhach) {
        return redirect('car_shop/dangnhap')
            ->with('error', 'Vui lòng đăng nhập.');
    }

    $danhSach = $User->LichLaiThu_CuaToi($idKhach);

    return view('user.layouts.lichlaithu', [
        'danh_sach' => $danhSach
    ]);
}
function tranglaithu(Request $request, $IDloai = 0, $IDTH = 0){
    $maLoai = (int)$IDloai;
        $maThuongHieu = (int)$IDTH;

      
        $search = trim($request->query('search', ''));

        
        $sp = new Product();

        
        $danhSachXe = $sp->locSanPham($search, $maLoai, $maThuongHieu);
        
     
        $loaiXeList = $sp->getAllLoaiXe();
        $thuongHieuList = $sp->getAllThuongHieu();

       
       return view('user.layouts.trangdatlaithu', compact(
            'danhSachXe', 
            'loaiXeList', 
            'thuongHieuList', 
            'search', 
            'maLoai', 
            'IDTH' 
        ));  
    }
    function chitietxelaithu($id){
        $sp = new Product();

        $id = (int)$id;

        // ===== 1. Chi tiết xe =====
        $chitietsp = $sp->chitietsp($id);

        if (!$chitietsp) {
            return abort(404, 'Không tìm thấy xe trong hệ thống.');
        }

        // ===== 2. Ảnh xe =====
        $anh_xe_mau = [];
        $result_anh = $sp->list_anh_xe_mau($id);

        if ($result_anh) {
            while ($row = $result_anh->fetch_assoc()) {
                $anh_xe_mau[] = $row;
            }
        }
        $Xe_mau = [];
        $result_xe_mau = $sp->getDanhSachXeMauTheoXe($id);

        if ($result_xe_mau) {
            while ($row = $result_xe_mau->fetch_assoc()) {
                $Xe_mau[] = $row;
            }
        }

        // ===== 3. Màu xe =====
        $mau_xe = [];
        $result_mau = $sp->list_mau_xe($id);

        if ($result_mau) {
            while ($row = $result_mau->fetch_assoc()) {
                $mau_xe[] = $row;
            }
        }

        // ===== 4. Giá mặc định =====
        $gia_mac_dinh = 0;
        if (!empty($mau_xe)) {
            $gia_mac_dinh = $mau_xe[0]['Gia'];
        }

        // ===== 5. Ưu đãi =====
        $uu_dai = [];
        $result_uu_dai = $sp->uu_dai_cua_xe($id);

        if ($result_uu_dai) {
            while ($row = $result_uu_dai->fetch_assoc()) {
                $uu_dai[] = $row;
            }
        }

        return view('user.layouts.trangchitietxelaithu', compact(
            'chitietsp',
            'Xe_mau',
            'anh_xe_mau',
            'mau_xe',
            'gia_mac_dinh',
            'uu_dai'
        ));
    }
function huylaithu($id){
    $service = new User();
    $userId = session('user_id');

    $result = $service->huy_lich_lai_thu($id, $userId);

    if ($result) {
        return back()->with('success', 'Hủy lịch thành công!');
    } else {
        return back()->with('error', 'Không thể hủy lịch.');
    }
}


}
