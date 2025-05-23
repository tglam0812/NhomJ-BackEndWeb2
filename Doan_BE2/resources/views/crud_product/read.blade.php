@extends('dashboard')

@section('content')
<style>
    .product-detail {
        display: flex;
        gap: 30px;
        padding: 20px;
        align-items: flex-start;
        max-width: 900px;
        margin: auto;
    }

    .product-detail img {
        width: 300px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-info {
        flex: 1;
        font-size: 16px;
    }

    .product-info table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-info th {
        text-align: left;
        padding-right: 10px;
        white-space: nowrap;
        width: 150px;
        color: #333;
    }

    .product-info td {
        padding-bottom: 10px;
        color: #000;
    }

    .back-link {
        display: block;
        margin-top: 20px;
        text-decoration: none;
        color: #6c63ff;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="product-detail">
    <!-- Ảnh -->
    <div>
        <img src="{{ asset('assets/images/products/' . $product->product_images_1) }}" alt="Ảnh sản phẩm">
    </div>

    <!-- Thông tin -->
    <div class="product-info">
        <table>
            <tr>
                <th>Tên sản phẩm</th>
                <td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>{{ number_format($product->product_price, 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <th>Số lượng trong kho</th>
                <td>{{ $product->product_qty }}</td>
            </tr>
            <tr>
                <th>Danh mục</th>
                <td>{{ $product->category->category_name ?? 'Chưa phân loại' }}</td>
            </tr>
            <tr>
                <th>Thương hiệu</th>
                <td>{{ $product->brand->brand_name ?? 'Không rõ' }}</td>
            </tr>
            <tr>
                <th>Tình trạng</th>
                <td>{{ $product->product_status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
            </tr>
            <tr>
                <th>Mô tả sản phẩm</th>
                <td>{{ $product->product_description }}</td>
            </tr>

        </table>

        <a href="{{ route('products.list') }}" class="back-link">← Trở về danh sách</a>
    </div>
</div>
@endsection