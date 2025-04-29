@extends('dashboard')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Edit Product</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.postUpdateProduct', ['id' => $product->product_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group mb-3">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="product_price">Price</label>
                    <input type="number" id="product_price" name="product_price" class="form-control" value="{{ old('product_price', $product->product_price) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="product_qty">Quantity</label>
                    <input type="number" id="product_qty" name="product_qty" class="form-control" value="{{ old('product_qty', $product->product_qty) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="products_description">Description</label>
                    <textarea id="products_description" name="products_description" class="form-control" rows="4">{{ old('products_description', $product->products_description) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="category_id">Category</label>
                             <select id="category_id" name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
                         {{ $category->category_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="brand_id">Brand</label>
                            <select id="brand_id" name="brand_id" class="form-control" required>
                                     <option value="">-- Choose brand --</option>
                            @foreach($brands as $brand)
                                     <option value="{{ $brand->brand_id }}" {{ $product->brand_id == $brand->brand_id ? 'selected' : '' }}>
                {{ $brand->brand_name }}
            </option>
        @endforeach
    </select>
</div>

                @foreach([1, 2, 3] as $i)
                    <div class="form-group mb-4">
                        <label for="product_images_{{ $i }}">Product Image {{ $i }}</label>
                        <input type="file" id="product_images_{{ $i }}" name="product_images_{{ $i }}" class="form-control">
                        @php $image = 'product_images_' . $i; @endphp
                        @if($product->$image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->$image) }}" alt="Product Image {{ $i }}" width="150" class="rounded shadow">
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
