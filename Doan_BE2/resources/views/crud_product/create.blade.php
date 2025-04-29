@extends('dashboard')

@section('content')
<main class="product-create">
    <div class="container">
        <h2>Add New Product</h2>
        <form action="{{ route('products.postProduct') }}" method="POST" enctype="multipart/form-data" class="form-product">
            @csrf

            <div class="form-group">
                <label for="product_name">Product Name <span class="text-danger">*</span></label>
                <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="product_price">Price (VND) <span class="text-danger">*</span></label>
                    <input type="number" id="product_price" name="product_price" min="0" value="{{ old('product_price') }}" required>
                </div>
                <div class="form-group">
                    <label for="product_qty">Quantity <span class="text-danger">*</span></label>
                    <input type="number" id="product_qty" name="product_qty" min="0" value="{{ old('product_qty') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id">
                        <option value="">-- Select Brand --</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="products_description">Description</label>
                <textarea name="products_description" id="products_description" rows="4">{{ old('products_description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <div class="radio-group">
                    <label><input type="radio" name="products_status" value="1" checked> Active</label>
                    <label><input type="radio" name="products_status" value="0"> Inactive</label>
                </div>
            </div>

            <div class="form-group">
                <label>Images (JPG/PNG/GIF, max 2MB each)</label>
                <div class="image-inputs">
                    <input type="file" name="product_images_1">
                    <input type="file" name="product_images_2">
                    <input type="file" name="product_images_3">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Product</button>
                <a href="{{ route('products.list') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</main>

<style>
    .product-create {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-product {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    textarea {
        resize: vertical;
    }

    .radio-group {
        display: flex;
        gap: 15px;
    }

    .image-inputs input {
        display: block;
        margin-bottom: 8px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-save {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-save:hover {
        background-color: #0056b3;
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }

    .text-danger {
        color: red;
    }
</style>
@endsection
