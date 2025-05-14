@extends('layouts.master')

@section('title', 'Thanh toán')

@section('main-content')
<div class="container mt-5">
    <h2>Trang thanh toán</h2>
    @if(session()->has('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $item)
                    @php $lineTotal = $item['product_price'] * $item['quantity']; $total += $lineTotal; @endphp
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['product_price']) }} VND</td>
                        <td>{{ number_format($lineTotal) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4 class="text-end">Tổng cộng: {{ number_format($total) }} VND</h4>

        <form action="#" method="POST">
            @csrf
            <button class="btn btn-success">Xác nhận thanh toán</button>
        </form>
    @else
        <p>Không có sản phẩm trong giỏ hàng.</p>
    @endif
</div>
@endsection
