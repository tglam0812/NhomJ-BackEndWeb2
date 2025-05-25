@extends('layouts.master')

@section('main-content')
<style>
    .order-success-container {
        max-width: 700px;
        margin: 100px auto 50px;
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    }

    .order-success-container h2 {
        font-weight: bold;
        color: #28a745;
        margin-bottom: 20px;
    }

    .order-success-container p,
    .order-success-container li {
        font-size: 16px;
        color: #333;
    }

    .order-success-container ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-bottom: 20px;
    }

    .order-success-container .btn-back {
        display: inline-block;
        padding: 10px 25px;
        background-color: #000;
        color: #fff;
        border-radius: 25px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .order-success-container .btn-back:hover {
        background-color: #444;
    }

    .highlight {
        color: #e74c3c;
        font-weight: bold;
    }

    .bi {
        margin-right: 5px;
        color: #555;
    }
</style>

@php
    $subtotal = collect($order['items'])->sum(function($item) {
        return $item['product_price'] * $item['quantity'];
    });

    $discount = 0;
    if ($order['coupon']) {
        $discount = $order['coupon']['loai_giam'] === 'percent'
            ? $subtotal * $order['coupon']['gia_tri'] / 100
            : $order['coupon']['gia_tri'];

        if ($discount > $subtotal) $discount = $subtotal;
    }
@endphp

<div class="order-success-container">
    <h2><i class="bi bi-check2-circle"></i> Đặt hàng thành công!</h2>

    <p><i class="bi bi-person-fill"></i> <strong>Họ tên:</strong> {{ $order['fullname'] }}</p>
    <p><i class="bi bi-telephone-fill"></i> <strong>SĐT:</strong> {{ $order['phone'] }}</p>
    <p><i class="bi bi-geo-alt-fill"></i> <strong>Địa chỉ:</strong> {{ $order['address'] }}</p>

    <h5 class="mt-4 mb-2"><i class="bi bi-bag-fill"></i> Danh sách sản phẩm:</h5>
    <ul>
        @foreach($order['items'] as $item)
            <li>{{ $item['product_name'] }} × {{ $item['quantity'] }} – 
                <span class="highlight">{{ number_format($item['product_price']) }} VND</span>
            </li>
        @endforeach
    </ul>

    <p><i class="bi bi-wallet2"></i> <strong>Tạm tính:</strong> {{ number_format($subtotal) }} VND</p>

    @if($order['coupon'])
        <p>
            <i class="bi bi-tag-fill"></i> 
            <strong>Giảm giá:</strong> {{ $order['coupon']['ma_phieu'] }}
            @if($order['coupon']['loai_giam'] === 'percent')
                ({{ $order['coupon']['gia_tri'] }}%)
            @else
                ({{ number_format($order['coupon']['gia_tri']) }} VND)
            @endif
            <br>
            <span class="text-success">→ Tiết kiệm: {{ number_format($discount) }} VND</span>
        </p>
    @endif

    <p><i class="bi bi-cash-coin"></i> <strong>Tổng thanh toán:</strong> 
        <span class="highlight">{{ number_format($order['total']) }} VND</span>
    </p>

    <a href="/" class="btn-back mt-3"><i class="bi bi-arrow-left"></i> Về trang chủ</a>
</div>
@endsection
