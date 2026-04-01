namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class ThongKeController extends Controller
{
public function index($tab = 'tieu-dung') 
{
    // 1. Lấy dữ liệu biểu đồ: Số lượng đơn hàng (khách mua) theo từng tháng
    // Để biết tháng nào cao nhất
    $bieuDoTieuDung = DB::table('don_hang')
        ->select(
            DB::raw('MONTH(created_at) as thang'), 
            DB::raw('COUNT(id_Don_Hang) as so_luong_don'),
            DB::raw('SUM(Tien_Coc) as doanh_thu_thang')
        )
        ->where('payment_status', 'paid')
        ->groupBy('thang')
        ->orderBy('thang', 'asc')
        ->get();

    // 2. Lấy danh sách khách hàng tiêu dùng (Bảng chi tiết)
    $dsKhachHang = DB::table('don_hang')
        ->join('khach_hang', 'don_hang.id_Khach_Hang', '=', 'khach_hang.id_Khach_Hang')
        ->select('khach_hang.Ho_Ten', 'khach_hang.SDT', 
                DB::raw('SUM(don_hang.Tien_Coc) as tong_chi'), 
                DB::raw('COUNT(don_hang.id_Don_Hang) as so_don'))
        ->where('don_hang.payment_status', 'paid')
        ->groupBy('khach_hang.id_Khach_Hang', 'khach_hang.Ho_Ten', 'khach_hang.SDT')
        ->orderBy('tong_chi', 'desc')
        ->get();

    return view('admin.layouts.index_AD', [
        'key' => 'kiem_ke',
        'tab' => $tab,
        'bieuDo' => $bieuDoTieuDung,
        'khachHang' => $dsKhachHang
    ]);
}