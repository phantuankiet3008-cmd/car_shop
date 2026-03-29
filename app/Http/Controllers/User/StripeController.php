<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Services\User;

class StripeController extends Controller
{
    public function checkout($id)
    {
        $service = new User();
        $don = $service->lay_don($id);

        if(!$don){
            return back()->with('error','Đơn không tồn tại');
        }

        return view('user.layouts.stripe', compact('don'));
    }

    public function pay($id)
    {
        $service = new User();
        $don = $service->lay_don($id);

        if(!$don){
            return back()->with('error','Đơn không tồn tại');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // ⚠️ convert VNĐ -> USD (tạm)
        $usd = $don->Tien_Coc / 24000;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Thanh toán đơn #' . $id,
                    ],
                    'unit_amount' => $usd * 100, // cent
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'success_url' => route('stripe.success', $id),
            'cancel_url' => route('stripe.cancel', $id),
        ]);

        return redirect($session->url);
    }

    public function success($id)
    {
        // ✅ gọi service (đúng yêu cầu bạn)
        $service = new User();

        $service->thanh_toan_thanh_cong(
            $id,
            'stripe_' . time()
        );

        return redirect()->route('don-hang')
            ->with('success','Thanh toán Stripe thành công');
    }

    public function cancel($id)
    {
        return redirect()->route('checkout', $id)
            ->with('error','Bạn đã hủy thanh toán');
    }
}