@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h2>Chi tiết đơn hàng #{{ $bill->bill_id }}</h2>
    <p><strong>Người nhận:</strong> {{ $bill->note }}</p>
    <p><strong>Ngày đặt:</strong> {{ $bill->date_invoice }}</p>
    <p><strong>Trạng thái:</strong> {{ ucfirst($bill->status) }}</p>

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

    <h4 class="mt-3 text-end">Tổng cộng: {{ number_format($bill->total_amount) }} VND</h4>
</div>
@endsection
