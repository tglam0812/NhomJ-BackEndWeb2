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

    <div class="container mt-5">
    <h4 class="mb-4">Đánh giá sản phẩm</h4>

    {{-- Hiển thị danh sách đánh giá --}}
    @if($reviews->isEmpty())
        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
    @else
        @foreach($reviews as $review)
            <div class="mb-3 p-3 border rounded bg-light position-relative">
                <strong>{{ $review->user->full_name ?? 'Người dùng' }}</strong>
                <span class="text-warning">
                    @for($i = 1; $i <= $review->rating; $i++) ★ @endfor
                    @for($i = $review->rating + 1; $i <= 5; $i++) ☆ @endfor
                </span>
                <p class="m-0">{{ $review->comment }}</p>
                <small class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</small>

                {{-- Nút 3 chấm và menu xóa, chỉ hiển thị nếu đúng user --}}
                @if(Auth::id() === $review->user_id)
                <div class="dropdown position-absolute" style="top: 10px; right: 10px;">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenu{{ $review->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $review->id }}">
                        <li>
                            <form action="{{ route('review.destroy', $review->review_id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">Xóa</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        @endforeach

    @endif

    @if(Auth::check())
        <form action="{{ route('review.store') }}" method="POST" class="mt-4" onsubmit="return validateReviewForm();">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

            <div class="form-group mb-2">
                <label for="rating">Số sao:</label>
                <select id="rating" name="rating" class="form-control">
                    <option value="">-- Chọn sao --</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} sao</option>
                    @endfor
                </select>
                <small id="rating-error" class="text-danger" style="display: none;">Vui lòng chọn số sao.</small>
            </div>

            <div class="form-group mb-2">
                <label for="comment">Nội dung đánh giá:</label>
                <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Nhập đánh giá của bạn..."></textarea>
                <small id="comment-error" class="text-danger" style="display: none;">Bình luận không được để trống và không vượt quá 1000 ký tự.</small>
            </div>

            <button type="submit" class="btn btn-success">Gửi đánh giá</button>
        </form>

        <script>
            function validateReviewForm() {
                const rating = document.getElementById('rating').value;
                const comment = document.getElementById('comment').value.trim(); // bỏ khoảng trắng đầu/cuối
                const ratingError = document.getElementById('rating-error');
                const commentError = document.getElementById('comment-error');

                let valid = true;

                // Kiểm tra số sao
                if (!rating) {
                    ratingError.style.display = 'block';
                    valid = false;
                } else {
                    ratingError.style.display = 'none';
                }

                // Kiểm tra comment rỗng hoặc dài quá
                if (comment === "" || comment.length > 1000) {
                    commentError.style.display = 'block';
                    valid = false;
                } else {
                    commentError.style.display = 'none';
                }

                return valid;
            }
        </script>
    @else
        <p class="mt-3">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi đánh giá.</p>
    @endif
</div>

</section>
@endsection


