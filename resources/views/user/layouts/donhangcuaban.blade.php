@extends('user.layouts.user_index')
<link rel="stylesheet" href="{{ asset('user/css/donhang.css') }}">
@section('content')

<div class="container mt-5">

    <div class="order-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="order-title">
                <i class="bi bi-bag-check"></i> Đơn hàng của tôi
            </h2>
        </div>

        @if($don_hang && $don_hang->num_rows > 0)

        <div class="table-responsive">
            <table class="table align-middle text-center">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Xe</th>
                        <th>Màu</th>
                        <th>Tổng tiền</th>
                        <th>Tiền cọc/Thanh toán</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày</th>
                    </tr>
                </thead>

                <tbody>

                @php $i = 1; @endphp

                @while($row = $don_hang->fetch_assoc())

                <tr>
                    <td>{{ $i++ }}</td>

                    <td>
                        <strong>{{ $row['Ten_Xe'] }}</strong>
                    </td>

                    <td>{{ $row['Ten_Mau'] }}</td>

                    <td class="price">
                        {{ number_format($row['Tong_Tien']) }} đ
                    </td>

                    <td>
                        {{ number_format($row['Tien_Coc']) }} đ
                    </td>

                    <td>
                        @if($row['payment_status'] == 'paid')
                            <span class="pay-paid">
                                <i class="bi bi-check-circle"></i> Đã thanh toán
                            </span>
                        @else
                            <span class="pay-pending">
                                <i class="bi bi-clock"></i> Chờ thanh toán
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($row['Trang_Thai'] == 'new')
                            <span class="badge-status status-new">Mới</span>
                        @elseif($row['Trang_Thai'] == 'da_coc')
                            <span class="badge-status status-coc">Đã cọc</span>
                        @elseif($row['Trang_Thai'] == 'da_ky')
                            <span class="badge-status status-ky">Đã ký</span>
                        @elseif($row['Trang_Thai'] == 'da_giao')
                            <span class="badge-status status-giao">Đã giao</span>
                        @else
                            <span class="badge bg-secondary">{{ $row['Trang_Thai'] }}</span>
                        @endif
                    </td>

                    <td>
                        {{ date('d/m/Y', strtotime($row['Ngay_Tao'])) }}
                    </td>

                </tr>

                @endwhile

                </tbody>
            </table>
        </div>

        @else

            <div class="text-center p-4">
                <i class="bi bi-cart-x" style="font-size:40px;"></i>
                <p class="mt-2">Bạn chưa có đơn hàng nào</p>
            </div>

        @endif

    </div>

</div>

@endsection