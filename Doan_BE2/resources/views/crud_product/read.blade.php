@extends('dashboard')

@section('content')
<div class="product-detail">
    <div class="image-stack" id="imageStack">
        @foreach ([$product->product_images_1, $product->product_images_2, $product->product_images_3] as $img)
        @if ($img)
        <img src="{{ asset('assets/images/products/' . $img) }}" alt="Ảnh sản phẩm">
        @endif
        @endforeach

        <button class="btn-nav btn-prev" id="prevBtn" aria-label="Previous image">&#8249;</button>
        <button class="btn-nav btn-next" id="nextBtn" aria-label="Next image">&#8250;</button>
        <button class="btn-zoom" id="zoomBtn">Phóng to</button>
    </div>

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

<!-- Modal hiển thị ảnh phóng to -->
<div class="zoom-modal" id="zoomModal">
    <img src="" alt="Phóng to ảnh" id="zoomedImage">
</div>

<script>
    const images = document.querySelectorAll('#imageStack img');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const zoomBtn = document.getElementById('zoomBtn');
    const zoomModal = document.getElementById('zoomModal');
    const zoomedImage = document.getElementById('zoomedImage');
    let currentIndex = 0;
    let intervalId;

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.remove('active');
        });
        images[index].classList.add('active');
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    function startAutoSlide() {
        intervalId = setInterval(nextImage, 3000);
    }

    function stopAutoSlide() {
        clearInterval(intervalId);
    }

    function zoomCurrentImage() {
        const activeImage = document.querySelector('#imageStack img.active');
        if (activeImage) {
            zoomedImage.src = activeImage.src;
            zoomModal.classList.add('active');
        }
    }

    zoomModal.addEventListener('click', () => {
        zoomModal.classList.remove('active');
        zoomedImage.src = '';
    });

    if (images.length > 0) {
        showImage(currentIndex);
        startAutoSlide();

        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextImage();
            startAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevImage();
            startAutoSlide();
        });

        zoomBtn.addEventListener('click', zoomCurrentImage);
    }
</script>
<link rel="stylesheet" href="{{ asset('assets/css/product/read.css') }}">
@endsection