@extends('dashboard')

@section('content')
<div class="container">
    <h2>Product Detail</h2>
    <table class="table">
        <tr>
            <td>
            <img src="{{ asset('assets/images/products/' . $product->product_images_1) }}" width="60" alt="{{ $product->product_name }}">
            </td>
            <td> <strong>Tên sản phẩm: </strong>{{ $product->product_name }}</td>
            <td>{{ number_format($product->product_price) }} VND</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td colspan="5"><strong>Description:</strong> {{ $product->product_description }}</td>
        </tr>
    </table>
    <a href="{{ route('products.list') }}">Back to list</a>
</div>
@endsection
