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
                        <th>ID</th>
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
                        <td>{{ $product->product_id }}</td>
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
                            <form method="POST" action="{{ route('products.deleteProduct', $product->product_id) }}" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete"
                                    data-product-name="{{ $product->product_name }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if (session('error'))
                <div class="alert alert-danger auto-dismiss">
                    {{ session('error') }}
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success auto-dismiss">
                    {{ session('success') }}
                </div>
                @endif


            </table>
            {{ $products->links('phantrang') }}

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.form-delete');
                    const productName = this.getAttribute('data-product-name');

                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: `Bạn có muốn xóa sản phẩm "${productName}" không?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có',
                        cancelButtonText: 'Hủy',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        setTimeout(function() {
            document.querySelectorAll('.auto-dismiss').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000); // 3 giây sau bắt đầu ẩn
    </script>

</main>
<link rel="stylesheet" href="{{ asset('assets/css/product/list.css') }}">
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection