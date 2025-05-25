@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h2>Chi tiết đơn hàng #{{ $bill->bill_id }}</h2>
    <p><strong>Người nhận:</strong> {{ $bill->note }}</p>
    <p><strong>Ngày đặt:</strong> {{ $bill->date_invoice }}</p>
    <p><strong>Trạng thái:</strong> {{ ucfirst($bill->status) }}</p>

    @php
        $subtotal = 0;
        foreach ($bill->details as $detail) {
            $subtotal += $detail->price * $detail->quantity;
        }
        $discount = 0;
        if ($bill->coupon) {
            $discount = round($subtotal * $bill->coupon->phan_tram_giam / 100);
        }
    @endphp

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->details as $detail)
            <tr>
                <td>{{ $detail->product->product_name ?? 'Đã xóa' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price) }} VND</td>
                <td>{{ number_format($detail->price * $detail->quantity) }} VND</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end mt-4">
        <p><strong>Tạm tính:</strong> {{ number_format($subtotal) }} VND</p>

        @if ($bill->coupon)
            <p><strong>Mã giảm giá:</strong> {{ $bill->coupon->ten_phieu }} ({{ $bill->coupon->phan_tram_giam }}%)</p>
            <p><strong>Giảm giá:</strong> -{{ number_format($discount) }} VND</p>
        @endif

        <h4><strong>Tổng cộng:</strong> {{ number_format($bill->total_amount) }} VND</h4>
    </div>
</div>
@endsection
