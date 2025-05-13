@extends('layouts.master')

@section('title', 'Sản phẩm yêu thích')

@section('main-content')
<div class="container py-5">
    <h3 class="mb-4 pt-5">Danh sách sản phẩm yêu thích</h3>
    <div class="row">
        @forelse($wishlists as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['product_id' => $item->product->product_id]) }}">
                        <img src="{{ asset('assets/images/products/' . $item->product->product_images_1) }}" class="card-img-top" alt="{{ $item->product->product_name }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->product->product_name }}</h5>
                        <p class="card-text mb-2">{{ number_format($item->product->product_price) }} VND</p>

                        <form action="{{ route('wishlist.toggle', $item->product->product_id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-heart-fill"></i> Xóa khỏi yêu thích
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Chưa có sản phẩm nào được thêm vào yêu thích.</p>
        @endforelse
    </div>
</div>
@endsection
