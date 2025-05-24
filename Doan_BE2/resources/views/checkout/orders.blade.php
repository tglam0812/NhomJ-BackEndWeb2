@extends('layouts.master')

@section('main-content') 
<div class="container mt-5 pt-4">
    <h3 class="mb-4" style="margin-top: 40px;">Lịch sử mua hàng</h3>

    @forelse ($bills as $bill)
    @php
        $subtotal = $bill->details->sum(fn($item) => $item->price * $item->quantity);
        $discount = $bill->coupon ? round($subtotal * $bill->coupon->phan_tram_giam / 100) : 0;
    @endphp

    <div class="card shadow-sm border-primary mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">
                <i class="bi bi-receipt-cutoff"></i> Đơn hàng #{{ $bill->bill_id }} - {{ $bill->date_invoice }}
            </h5>

            <p>
                <strong><i class="bi bi-info-circle"></i> Trạng thái:</strong> 
                <span class="badge bg-warning text-dark">{{ ucfirst($bill->status) }}</span>
            </p>

            <ul class="mb-3">
                @foreach ($bill->details as $item)
                    <li>
                        {{ $item->product->product_name ?? 'Sản phẩm đã xóa' }} × {{ $item->quantity }} = 
                        <span class="text-danger">{{ number_format($item->price * $item->quantity) }} VND</span>
                    </li>
                @endforeach
            </ul>

            <div class="mb-2">
                <p><i class="bi bi-calculator"></i> <strong>Tạm tính:</strong> {{ number_format($subtotal) }} VND</p>

                @if ($bill->coupon)
                    <p>
                        <i class="bi bi-tag"></i> <strong>Phiếu giảm giá:</strong> {{ $bill->coupon->ten_phieu }} 
                        ({{ $bill->coupon->phan_tram_giam }}%)<br>
                        <span class="text-success">→ Giảm: {{ number_format($discount) }} VND</span>
                    </p>
                @endif
            </div>

            <p class="fw-bold text-end">
                <i class="bi bi-cash-coin"></i> 
                Tổng cộng: <span class="text-danger">{{ number_format($bill->total_amount) }} VND</span>
            </p>

            <div class="text-end">
                <a href="{{ route('order.detail', $bill->bill_id) }}" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-eye"></i> Xem chi tiết
                </a>
            </div>
        </div>
    </div>
    @empty
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @endforelse
</div>
@endsection
