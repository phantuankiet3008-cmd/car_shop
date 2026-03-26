<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user/css/Checkout_user.css') }}">
</head>
<body>

<div class="checkout-container">
    <div class="checkout-header">
        <i class="fa-solid fa-file-invoice-dollar"></i>
        <h3>Thanh toán đơn #{{ $don->id_Don_Hang }}</h3>
    </div>

    <div class="order-info">
        <div class="info-row">
            <span>Tổng giá trị xe:</span>
            <span class="price">{{ number_format($don->Tong_Tien) }} VNĐ</span>
        </div>
        <div class="info-row highlight">
            <span>Số tiền cần đặt cọc:</span>
            <span class="deposit">{{ number_format($don->Tien_Coc) }} VNĐ</span>
        </div>
    </div>

    <form method="POST" action="{{ route('selectPayment', $don->id_Don_Hang) }}">
        @csrf
        <p class="section-title">Chọn phương thức thanh toán:</p>

        <label class="payment-option">
            <input type="radio" name="payment_method" value="vnpay" required checked>
            <div class="option-content">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-VNPAY-QR-350x65.png" alt="VNPay">
                <span>Thanh toán qua ví VNPay / Ngân hàng</span>
            </div>
            <i class="fa-solid fa-circle-check"></i>
        </label>
          <label class="payment-option">
            <input type="radio" name="payment_method" value="momo" required>
            <div class="option-content">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Transparent-768x768.png" alt="Momo">
                <span>Thanh toán qua ví MOMO / Ngân hàng</span>
            </div>
            <i class="fa-solid fa-circle-check"></i>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_method" value="stripe">
            <div class="option-content">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe">
                <span>Thanh toán qua thẻ quốc tế (Stripe)</span>
            </div>
            <i class="fa-solid fa-circle-check"></i>
        </label>

        <button type="submit" class="btn-checkout">
            Xác nhận thanh toán <i class="fa-solid fa-arrow-right"></i>
        </button>
    </form>

    <p class="footer-note"><i class="fa-solid fa-shield-halved"></i> Giao dịch bảo mật 100%</p>
</div>

</body>
</html>