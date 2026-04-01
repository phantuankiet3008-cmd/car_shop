<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Services\User;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout($id)
    {
        $id_kh = session('user_id');
        if (!$id_kh) return redirect()->route('dangnhap')->with('error', 'Bạn chưa đăng nhập');

        $service = new User();
        $don = $service->lay_don($id);

        if (!$don || $don->id_Khach_Hang != $id_kh) {
            return back()->with('error', 'Đơn hàng không hợp lệ');
        }

        if ($don->payment_status !== 'pending') {
            return back()->with('error', 'Đơn hàng này đã được xử lý hoặc đã thanh toán');
        }

        try {
            // Lấy Secret Key từ file .env
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Tạo Session thanh toán
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency'     => 'vnd', // Stripe hỗ trợ VND trực tiếp
                        'product_data' => [
                            'name' => 'Đặt cọc xe - Đơn hàng #' . $don->id_Don_Hang,
                            'description' => 'Thanh toán tiền cọc 1% giá trị xe',
                        ],
                        // Quan trọng: Phải là số nguyên và tối thiểu ~12,000 VND
                        'unit_amount'  => (int)round($don->Tien_Coc), 
                    ],
                    'quantity' => 1,
                ]],
                'mode'        => 'payment',
                // Chú ý: Route name phải khớp với web.php
                'success_url' => route('stripe.success', ['id' => $id]),
                'cancel_url'  => route('stripe.cancel', ['id' => $id]),
            ]);

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi Stripe: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $service = new User();
        // Gọi hàm cập nhật DB đã có trong User.php
        $result = $service->thanh_toan_thanh_cong($id, 'STRIPE_' . strtoupper(bin2hex(random_bytes(4))));

        if ($result) {
            return redirect()->route('don-hang')->with('success', 'Thanh toán tiền cọc thành công!');
        }
        return redirect()->route('don-hang')->with('error', 'Thanh toán thành công nhưng lỗi cập nhật dữ liệu');
    }

    public function cancel($id)
    {
        return redirect()->route('checkout', ['id' => $id])->with('error', 'Bạn đã hủy thanh toán Stripe');
    }
}