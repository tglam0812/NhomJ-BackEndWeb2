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
        </form>
    </div>
</div>
@endsection

<style>
    .category-update {
        padding: 20px;
        background-color: #f4f4f9;
    }

    .category-update .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-update h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .category-update .form-group {
        margin-bottom: 15px;
    }

    .category-update label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .category-update input[type="text"],
    .category-update textarea,
    .category-update select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .category-update textarea {
        height: 150px;
        resize: vertical;
    }

    .category-update .error {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
    }

    .category-update button.btn-submit {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .category-update button.btn-submit:hover {
        background-color: #2980b9;
    }

    .category-update button.btn-submit:disabled {
        background-color: #bbb;
        cursor: not-allowed;
    }
</style>