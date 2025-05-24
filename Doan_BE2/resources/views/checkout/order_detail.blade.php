@extends('layouts.master')

@section('main-content')
<div class="container mt-5 pt-5">
    <div class="bg-light p-4 shadow rounded">
        <h3 class="mb-4 text-primary">
            <i class="bi bi-receipt"></i> Chi tiết đơn hàng #{{ $bill->bill_id }}
        </h3>

        <div class="mb-3">
            <p><i class="bi bi-calendar-date"></i> <strong>Ngày đặt:</strong> {{ $bill->date_invoice }}</p>
            <p><i class="bi bi-info-circle"></i> <strong>Trạng thái:</strong> 
                <span class="badge bg-warning text-dark">{{ ucfirst($bill->status) }}</span>
            </p>
            <p><i class="bi bi-chat-left-text"></i> <strong>Ghi chú:</strong> {{ $bill->note }}</p>
        </div>

        <h5 class="mt-4 mb-3"><i class="bi bi-bag"></i> Danh sách sản phẩm:</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tạm tính</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach ($bill->details as $item)
                        @php
                            $lineTotal = $item->price * $item->quantity;
                            $subtotal += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $item->product->product_name ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} VND</td>
                            <td>{{ number_format($lineTotal) }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @php
            $discount = 0;
        @endphp

        <div class="mt-4">
            <p><i class="bi bi-calculator"></i> <strong>Tạm tính:</strong> {{ number_format($subtotal) }} VND</p>

            @if ($bill->coupon)
                @php
                    $discount = round($subtotal * $bill->coupon->phan_tram_giam / 100);
                @endphp
                <p><i class="bi bi-tag"></i> <strong>Phiếu giảm giá:</strong> {{ $bill->coupon->ten_phieu }} ({{ $bill->coupon->phan_tram_giam }}%)</p>
                <p><i class="bi bi-patch-check-fill text-success"></i> <strong>Số tiền được giảm:</strong> <span class="text-success">-{{ number_format($discount) }} VND</span></p>
            @endif
        </div>

        <div class="d-flex justify-content-end mt-4">
            <h4 class="text-danger">
                <i class="bi bi-cash-coin"></i> Tổng cộng: {{ number_format($bill->total_amount) }} VND
            </h4>
        </div>

        <a href="{{ route('orders.mine') }}" class="btn btn-dark mt-3">
            <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách đơn hàng
        </a>
    </div>
</div>
@endsection
