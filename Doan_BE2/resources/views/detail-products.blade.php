<!-- {{-- View này sẽ kế thừa giao diện từ layout->master--}} -->
@extends('layouts.master')
<!-- header - cart - footer -->

@section('main-content')
<section class="section-slide">
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ Str::slug($product->category->category_name) }}">
        <div class="block2">
            <div class="block2-pic hov-img0">
                <img src="{{ asset('assets/images/products/' . $product->product_images_1) }}" alt="IMG-PRODUCT">
            </div>
            <div class="block2-txt flex-w flex-t p-t-14">
                <div class="block2-txt-child1 flex-col-l ">
                    <a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                        {{ $product->product_name }}
                    </a>
                    <p class="product-description">{{ Str::limit($product->product_description, 100) }}</p>
                    <span class="stext-105 cl3">
                        {{ number_format($product->product_price) }} VND
                    </span>
                </div>
                <div class="block2-txt-child2 flex-r p-t-3">
                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                        <img class="icon-heart1 dis-block trans-04" src="{{ asset('assets/images/icons/icon-heart-01.png') }}" alt="ICON">
                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('assets/images/icons/icon-heart-02.png') }}" alt="ICON">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
