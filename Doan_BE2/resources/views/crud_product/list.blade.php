@extends('dashboard')

@section('content')
<main class="product-list">
    <div class="container">
        <div class="row justify-content-between">
            <h2>Products List</h2>
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <a href="{{ route('products.createProduct') }}" class="btn-add">Add Product</a>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quanity</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('assets/images/products/' . $product->product_images_1) }}" width="60" height="60" alt="{{ $product->product_name }}">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->product_price) }} VND</td>
                        <td>{{ $product->product_qty }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $product->brand->brand_name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('products.readProduct', $product->product_id) }}">View</a> |
                            <a href="{{ route('products.updateProduct', $product->product_id) }}">Edit</a> |
                            <form action="{{ route('products.delete', $product->product_id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</main>
<style>
    .product-list {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    h2 {
        font-size: 26px;
        margin-bottom: 20px;
        color: #333;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-form input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 250px;
    }

    .search-form button {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #0056b3;
    }

    .btn-add {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-add:hover {
        background-color: #218838;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .product-table th, .product-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .product-table th {
        background-color: #007bff;
        color: white;
    }

    .product-table td img {
        border-radius: 4px;
    }

    .product-table td a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .product-table td a:hover {
        text-decoration: underline;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        font-size: 13px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

</style>
@endsection
