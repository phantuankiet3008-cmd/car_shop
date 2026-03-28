<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User;
use App\Http\Controllers\User\VNPayController;
// Có thể thêm use App\Http\Controllers\User\MoMoController; nếu cần, nhưng chuyển hướng bằng route thì không bắt buộc.

class CheckoutController extends Controller
{
    public function checkout($id) 
    {
        $id_kh = session('user_id');

        if(!$id_kh){
            return redirect()->back()->with('error','Bạn chưa đăng nhập');
        }

        $service = new User();
        $don = $service->lay_don($id);

        if(!$don){
            return redirect()->back()->with('error','Đơn hàng không tồn tại');
        }

        // ✅ đúng user
        if($don->id_Khach_Hang != $id_kh){
            abort(403);
        }

        // ✅ check đã thanh toán (ĐÚNG DB)
        if($don->payment_status === 'paid'){
            return redirect()->route('don-hang')
                             ->with('success','Đơn hàng đã thanh toán');
        }

        // ✅ check đơn fail / expired
        if(in_array($don->payment_status, ['failed','expired'])){
            return redirect()->route('datcoc', ['id' => $don->id_Xe_Mau])
                             ->with('error','Đơn hàng đã hết hạn hoặc lỗi');
        }

        // ✅ lấy dữ liệu
        $xe = $service->lay_xe_mau($don->id_Xe_Mau);
        $khach = $service->lay_khach_hang($id_kh);

        return view('user.layouts.Checkout', compact('don','xe','khach'));
    }

    public function selectPayment(Request $request, $id)
    {
        // ❗ Đã thêm 'momo' vào danh sách cho phép
        $request->validate([
            'payment_method' => 'required|in:vnpay,stripe,momo' 
        ]);

        $service = new User();
        $don = $service->lay_don($id);

        if(!$don){
            return back()->with('error','Đơn không tồn tại');
        }

        // ❗ thêm check trạng thái
        if($don->payment_status !== 'pending'){
            return back()->with('error','Đơn không hợp lệ để thanh toán');
        }

        // ==========================================
        // CHIA NHÁNH ĐIỀU HƯỚNG CỔNG THANH TOÁN
        // ==========================================
        if($request->payment_method === 'vnpay'){
            return redirect()->route('vnpay.redirect', ['id' => $id]);
        } 
        elseif ($request->payment_method === 'momo') {
            return redirect()->route('momo.redirect', ['id' => $id]);
        }

        return redirect()->route('stripe.checkout', ['id' => $id]);
    }
}