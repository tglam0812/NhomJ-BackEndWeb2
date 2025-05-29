@extends('layouts.master')

@section('title', 'So sánh sản phẩm')

@section('main-content')
<div class="container py-5 mt-5">
    <h3 class="text-center mb-4 mt-4">So sánh sản phẩm</h3>

    @if(count($products) < 2)
        <p class="text-center text-muted">Bạn cần chọn ít nhất 2 sản phẩm để so sánh.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Thông số</th>
                    @foreach ($products as $p)
                        <th>
                            {{ $p->product_name }}<br>
                            <a href="{{ route('compare.remove', $p->product_id) }}" class="text-danger small">Xóa</a>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hình ảnh</td>
                    @foreach ($products as $p)
                        <td><img src="{{ asset('assets/images/products/'.$p->product_images_1) }}" width="100"></td>
                    @endforeach
                </tr>
                <tr>
                    <td>Giá</td>
                    @foreach ($products as $p)
                        <td>{{ number_format($p->product_price) }} VND</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Thương hiệu</td>
                    @foreach ($products as $p)
                        <td>{{ $p->brand->brand_name ?? '—' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Mô tả ngắn</td>
                    @foreach ($products as $p)
                        <td>{{ \Illuminate\Support\Str::limit($p->product_description, 80) }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <div class="mt-4 text-center">
        <a href="{{ route('home') }}" class="btn btn-primary">← Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
