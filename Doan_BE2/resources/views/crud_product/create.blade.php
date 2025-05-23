@extends('dashboard')

@section('content')
<main class="product-create">
    <div class="container">
        <h2>Add New Product</h2>

        {{-- Hiển thị lỗi validation --}}
        @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('products.postProduct') }}" method="POST" enctype="multipart/form-data" class="form-product">
            @csrf

            <div class="form-group">
                <label for="product_name">Product Name <span class="text-danger">*</span></label>
                <input type="text" id="product_name" name="product_name"
                    value="{{ old('product_name') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="product_price">Price (VND) <span class="text-danger">*</span></label>
                    <input type="number" id="product_price" name="product_price" min="0"
                        value="{{ old('product_price') }}" required>
                </div>
                <div class="form-group">
                    <label for="product_qty">Quantity <span class="text-danger">*</span></label>
                    <input type="number" id="product_qty" name="product_qty" min="0"
                        value="{{ old('product_qty') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id">
                        <option value="">-- Select Brand --</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->brand_id }}"
                            {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                            {{ $brand->brand_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="product_description">Description</label>
                <textarea name="product_description" id="product_description" rows="4">{{ old('product_description') }}</textarea>
            </div>

            

            <div class="form-group">
                <label>Images (JPG/PNG/GIF, max 2MB each)</label>
                <div class="image-inputs">
                    Ảnh 1<input type="file" name="product_images_1" accept=".jpg,.jpeg,.png,.gif">
                    Ảnh 2<input type="file" name="product_images_2" accept=".jpg,.jpeg,.png,.gif">
                    Ảnh 3<input type="file" name="product_images_3" accept=".jpg,.jpeg,.png,.gif">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Product</button>
                <a href="{{ route('products.list') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</main>

<link rel="stylesheet" href="{{ asset('assets/css/product/create.css') }}">
@endsection