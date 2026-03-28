<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;


class VNPayController extends Controller
{
 public function redirect($id)
{
    $id_kh = session('user_id');
    if(!$id_kh) return back()->with('error','Bạn chưa đăng nhập');

    $service = new User();
    $order = $service->lay_don($id);

    if(!$order) return back()->with('error','Đơn không tồn tại');

    if($order->id_Khach_Hang != $id_kh) abort(403);


    if($order->payment_status !== 'pending'){
        return back()->with('error','Đơn không hợp lệ để thanh toán');
    }

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = route('vnpay.return');
    $vnp_TmnCode = env('VNPAY_TMN_CODE');
    $vnp_HashSecret = env('VNPAY_HASH_SECRET');

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_Command" => "pay",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $order->Tien_Coc * 100,
        "vnp_CurrCode" => "VND",
        "vnp_TxnRef" => $order->id_Don_Hang . '_' . time(),
        "vnp_OrderInfo" => "Thanh toan coc don #".$order->id_Don_Hang,
        "vnp_OrderType" => "billpayment",
        "vnp_Locale" => "vn",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_IpAddr" => request()->ip(),
        "vnp_CreateDate" => date('YmdHis'),
    ];

    ksort($inputData);

    $query = "";
    $hashdata = "";

    foreach ($inputData as $key => $value) {
        $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

    return redirect($vnp_Url);
}
public function return(Request $request)
{
    $vnp_HashSecret = env('VNPAY_HASH_SECRET');
    $inputData = $request->all();

    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
    unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

    ksort($inputData);

    $hashData = "";
    foreach ($inputData as $key => $value) {
        $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
    }

    // sai chữ ký
    if(hash_hmac('sha512', $hashData, $vnp_HashSecret) !== $vnp_SecureHash){
        return redirect('/')->with('error','Lỗi chữ ký');
    }

    $orderId = explode('_', $request->vnp_TxnRef)[0];

    $service = new User();
    $order = $service->lay_don($orderId);

    if(!$order){
        return redirect('/')->with('error','Đơn không tồn tại');
    }

    if($order->payment_expires_at && now()->greaterThan($order->payment_expires_at)){
    $service->cap_nhat_payment_status($orderId, 'expired');

    return redirect()->route('checkout', $orderId)
                     ->with('error','Đơn đã hết hạn');
}
    
    if($order->payment_status === 'paid'){
        return redirect()->route('don-hang')->with('success','Đơn đã thanh toán');
    }


    if($request->vnp_Amount != $order->Tien_Coc * 100){
        return redirect()->route('checkout', $orderId)->with('error','Sai số tiền');
    }

  
    if($request->vnp_ResponseCode == '00'){

        $service->thanh_toan_thanh_cong(
            $orderId,
            $request->vnp_TransactionNo
        );

        return redirect()->route('don-hang')
                         ->with('success','Thanh toán thành công');
    }


    $service->cap_nhat_payment_status($orderId, 'failed');

    return redirect()->route('checkout', $orderId)
                     ->with('error','Thanh toán thất bại hoặc đã hủy');
}
}