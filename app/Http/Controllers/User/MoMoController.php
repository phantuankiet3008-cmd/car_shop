<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;

class MoMoController extends Controller
{
    public function redirect($id)
    {
        $id_kh = session('user_id');
        if(!$id_kh) return back()->with('error','Bạn chưa đăng nhập');

        $service = new User();
        $order = $service->lay_don($id);

        if(!$order) return back()->with('error','Đơn không tồn tại');
        if($order->id_Khach_Hang != $id_kh) abort(403);
        if($order->payment_status !== 'pending') {
            return back()->with('error','Đơn không hợp lệ để thanh toán');
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMOBKUN20180529";
        $accessKey = "klm05TvNBzhg7h7j";
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

        $orderInfo = "Thanh toan coc don #" . $order->id_Don_Hang;
        
        $tienCoc = $order->Tien_Coc;
        if ($tienCoc > 50000000) $tienCoc = 50000000;
        $amount = (string) $tienCoc; 
        
        $orderId = $order->id_Don_Hang . "_" . time(); 
        $requestId = time() . ""; 
        
        $redirectUrl = route('momo.return'); 
        $ipnUrl = route('momo.return');
        $extraData = "";
        $requestType = "payWithATM"; 
        
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
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
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        $jsonResult = json_decode($result, true);
        
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        } else {
            return back()->with('error', 'Lỗi MoMo: ' . ($jsonResult['message'] ?? 'Không rõ lý do'));
        }
    }

    public function return(Request $request)
    {
        $orderIdRaw = explode('_', $request->orderId);
        $orderId = $orderIdRaw[0];

        $service = new User();
        $order = $service->lay_don($orderId);

        if(!$order){
            return redirect('/')->with('error','Đơn không tồn tại');
        }

        if ($request->resultCode == 0) {
            $service->thanh_toan_thanh_cong(
                $orderId,
                $request->transId 
            );
            return redirect()->route('don-hang')->with('success','Thanh toán MoMo thành công!');
        } else {
            $service->cap_nhat_payment_status($orderId, 'failed');
            return redirect()->route('checkout', $orderId)->with('error','Thanh toán thất bại hoặc đã hủy giao dịch');
        }
    }
}