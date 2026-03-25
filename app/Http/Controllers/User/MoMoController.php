<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // NHỚ PHẢI CÓ DÒNG NÀY ĐỂ GỌI DATABASE

class MoMoController extends Controller
{
    public function thanhToanMoMo(Request $request)
    {
        // =======================================================
        // PHẦN 1: BẢO MẬT VÀ TÍNH TOÁN SỐ TIỀN CỌC CHÍNH XÁC TỪ DB
        // =======================================================
        
        // 1. Lấy ID xe màu từ Form người dùng bấm
        $id_xe_mau = $request->input('id_xe_mau'); 
        
        if (!$id_xe_mau) {
            return back()->with('error', 'Lỗi: Không tìm thấy thông tin phiên bản xe!');
        }

        // 2. Truy vấn lấy giá gốc của xe
        $xeMau = DB::table('xe_mau')
            ->join('san_pham_xe', 'xe_mau.id_Xe', '=', 'san_pham_xe.id_Xe')
            ->where('xe_mau.id_Xe_Mau', $id_xe_mau)
            ->select('xe_mau.Gia', 'san_pham_xe.id_Xe', 'san_pham_xe.Ten_Xe')
            ->first();

        if (!$xeMau) {
            return back()->with('error', 'Lỗi: Sản phẩm không tồn tại trong hệ thống!');
        }

        $giaGoc = $xeMau->Gia;
        $giaTriGiam = 0;

        // 3. Kiểm tra xem xe này có đang nằm trong chương trình Ưu đãi hợp lệ không
        $today = date('Y-m-d');
        $uuDai = DB::table('xe_uu_dai')
            ->join('uu_dai', 'xe_uu_dai.id_Uu_Dai', '=', 'uu_dai.id_Uu_Dai')
            ->where('xe_uu_dai.id_Xe', $xeMau->id_Xe)
            ->where('uu_dai.Trang_Thai', 1)
            ->whereDate('uu_dai.Ngay_Bat_Dau', '<=', $today)
            ->whereDate('uu_dai.Ngay_Ket_Thuc', '>=', $today)
            ->first(); 

        if ($uuDai) {
            if ($uuDai->Loai == 'phan_tram') {
                $giaTriGiam = $giaGoc * ($uuDai->Gia_Tri / 100);
            } elseif ($uuDai->Loai == 'tien_mat') {
                $giaTriGiam = $uuDai->Gia_Tri;
            }
        }

        // 4. Tính giá cuối cùng và Lấy 1% làm tiền cọc
        $giaCuoiCung = $giaGoc - $giaTriGiam;
        if ($giaCuoiCung < 0) $giaCuoiCung = 0;

        // TIỀN CỌC CHUẨN ĐƯỢC HỆ THỐNG TỰ TÍNH:
        $tienCocThucTe = round($giaCuoiCung * 0.01); 

        // =======================================================
        // LƯU Ý CỰC QUAN TRỌNG KHI BẢO VỆ ĐỒ ÁN VỚI HỘI ĐỒNG:
        // Môi trường test Sandbox của MoMo chỉ cho phép giao dịch tối đa 50.000.000 VNĐ.
        // Nếu test con xe 8 tỷ -> cọc 80 triệu -> MoMo sẽ báo lỗi vượt hạn mức.
        // Do đó ta cần ép giá trị test về tối đa 50tr để luồng chạy không bị đứt quãng.
        // =======================================================
        $soTienMoMoNhan = $tienCocThucTe;
        if ($tienCocThucTe > 50000000) {
            $soTienMoMoNhan = 50000000; 
        }

        // =======================================================
        // PHẦN 2: CHUẨN BỊ GÓI DỮ LIỆU ĐẨY SANG MOMO
        // =======================================================
        
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMOBKUN20180529";
        $accessKey = "klm05TvNBzhg7h7j";
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

        $orderInfo = "Coc xe " . $xeMau->Ten_Xe; // Lấy tên xe thật bỏ vào bill
        $amount = (string) $soTienMoMoNhan; 
        
        $orderId = time() . ""; 
        $requestId = $orderId; 
        
        $redirectUrl = "http://127.0.0.1:8000/user/car_shop/momo-return"; 
        $ipnUrl = "http://127.0.0.1:8000/user/car_shop/momo-return";
        $extraData = "";

        $requestType = "payWithATM"; 
        
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Car Shop Nhom 10",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)))
        );
        $result = curl_exec($ch);
        curl_close($ch);

        $jsonResult = json_decode($result, true);
        
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        } else {
            return back()->with('error', 'Lỗi MoMo: ' . ($jsonResult['message'] ?? 'Không rõ lý do'));
        }
    }
    public function momoReturn(Request $request)
    {
        // Lấy mã kết quả MoMo trả về trên thanh URL
        $resultCode = $request->resultCode;

        if ($resultCode == 0) {
            // GIAO DỊCH THÀNH CÔNG
            // (Mẹo: Chỗ này sau này nhóm của bạn sẽ viết code SQL để lưu thông tin khách hàng vào bảng `dat_coc` hoặc `don_hang` trong Database nhé)
            
            return redirect('/user/car_shop/trangchu')->with('success', '🎉 Chúc mừng! Bạn đã đặt cọc xe thành công qua hệ thống MoMo.');
        } else {
            // GIAO DỊCH THẤT BẠI HOẶC BỊ HỦY
            return redirect('/user/car_shop/trangchu')->with('error', '❌ Giao dịch đặt cọc đã bị hủy hoặc thất bại!');
        }
    }
}