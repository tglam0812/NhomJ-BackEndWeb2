@extends('dashboard')

@section('content')
<div class="category-update">
    <div class="container">
        <h2>Update Products</h2>
        <form action="{{ route('products.postUpdateProduct', ['id' => $product->product_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="product_name">Tên sản phẩm</label>
                <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="form-group">
                <label for="product_price">Giá</label>
                <input type="number" id="product_price" name="product_price" class="form-control" value="{{ old('product_price', $product->product_price) }}" required>
            </div>

            <div class="form-group">
                <label for="product_qty">Số lượng</label>
                <input type="number" id="product_qty" name="product_qty" class="form-control" value="{{ old('product_qty', $product->product_qty) }}" required>
            </div>

            <div class="form-group">
                <label for="product_description">Mô tả</label>
                <textarea id="product_description" name="product_description" class="form-control" rows="4">{{ old('product_description', $product->product_description) }}</textarea>
            </div>


            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Thương hiệu</label>
                <select id="brand_id" name="brand_id" class="form-control" required>
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->brand_id }}" {{ $product->brand_id == $brand->brand_id ? 'selected' : '' }}>
                        {{ $brand->brand_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            @foreach([1, 2, 3] as $i)
            <div class="form-group mb-4">
                <label for="product_images_{{ $i }}">Ảnh sản phẩm {{ $i }}</label>
                <input type="file" id="product_images_{{ $i }}" name="product_images_{{ $i }}" class="form-control">
                @php $image = 'product_images_' . $i; @endphp
                @if($product->$image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->$image) }}" alt="Ảnh sản phẩm {{ $i }}" width="150" class="rounded shadow">
                </div>
                @endif
            </div>
            @endforeach

            <div class="text-center">
                <button type="submit" class="btn-submit">Cập nhật sản phẩm</button>

            </div>
            <a href="{{ route('products.list') }}" class="btn btn-secondary">Trở về</a>
        </form>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('assets/css/product/update.css') }}">
@endsection