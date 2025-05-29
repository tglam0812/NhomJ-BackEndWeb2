<!-- {{-- View này sẽ kế thừa giao diện từ layout->master--}} -->
@extends('layouts.master')
<!-- header - cart - footer -->

@section('title')
Thương Mại Điện Tử
@endsection

@section('custom-css')
<style>
	.scrollable-categories {
		display: block;
		overflow-x: auto;
		white-space: nowrap;
		padding: 10px 0;
		-webkit-overflow-scrolling: touch;
		scrollbar-width: thin; /* Cho Firefox */
		border-bottom: 1px solid #e0e0e0;
	}

	.scrollable-categories a {
		display: inline-block;
		white-space: nowrap;
		margin-right: 20px;
		text-decoration: none;
	}

	/* Cho Chrome/Safari hiển thị thanh cuộn */
	.scrollable-categories::-webkit-scrollbar {
		height: 6px;
	}

	.scrollable-categories::-webkit-scrollbar-thumb {
		background: #888;
		border-radius: 3px;
	}

	.scrollable-categories::-webkit-scrollbar-track {
		background: #f1f1f1;
	}
	
	input:focus, select:focus, button:focus {
    box-shadow: none !important;
    outline: none;
	}

	form .form-select, form .btn {
		height: 42px;
		font-size: 14px;
	}
</style>
@endsection


@section('main-content')

<!-- Slider -->
<section class="section-slide">
	<div class="wrap-slick1">
		<div class="slick1">
			<div class="item-slick1" style="background-image: url({{ asset('assets/images/phone4.jpg') }});">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								iPhone chính hãng - Giá tốt mỗi ngày
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1" style="color: red;">
								Mua ngay !!!
							</h2>
						</div>
					</div>
				</div>
			</div>

			<div class="item-slick1" style="background-image: url({{ asset('assets/images/phone5.jpg') }});">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								Apple iPhone 14 Pro Max
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1" style="color: red;">
								Mua ngay !!!
							</h2>
						</div>
					</div>
				</div>
			</div>

			<div class="item-slick1" style="background-image: url({{ asset('assets/images/Phone6.jpg') }});">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								Redmi Note 13 Pro+ (Plus) 5G
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1" style="color: red;">
								Giảm thêm 30%
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Banner -->

<!-- Banner -->




<!-- Product -->
<section class="bg0 p-t-23 p-b-140">

	<div class="container">
		<div class="p-b-10">
			<h3 class="ltext-103 cl5">
				Product Overview
			</h3>
		</div>

		<div class="flex-w flex-sb-m p-b-52">
			<div class="scrollable-categories flex-w flex-l-m filter-tope-group m-tb-10">
				{{-- Link tất cả sản phẩm --}}
				<a href="{{ route('home') }}"
					class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request('category_id') ? '' : 'how-active1' }}">
					Tất cả sản phẩm
				</a>

				{{-- Các danh mục --}}
				@foreach ($categories as $category)
				<a href="{{ url('/') . '?category_id=' . $category->category_id }}"
					class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request('category_id') == $category->category_id ? 'how-active1' : '' }}">
					{{ $category->category_name }}
				</a>
				@endforeach
			</div>


			<!-- Search product -->
			<form method="GET" action="{{ route('home') }}" class="d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 mt-3">

				{{-- Dropdown lọc giá --}}
				<div>
					<select name="price_range" class="form-select rounded-pill px-4 py-2 shadow-sm border" style="min-width: 200px; height: 42px;" onchange="this.form.submit()">
						<option value="">-- Chọn khoảng giá --</option>
						<option value="under_5m" {{ request('price_range') == 'under_5m' ? 'selected' : '' }}>Dưới 5 triệu</option>
						<option value="5m_15m" {{ request('price_range') == '5m_15m' ? 'selected' : '' }}>5 - 15 triệu</option>
						<option value="15m_25m" {{ request('price_range') == '15m_25m' ? 'selected' : '' }}>15 - 25 triệu</option>
						<option value="above_25m" {{ request('price_range') == 'above_25m' ? 'selected' : '' }}>Trên 25 triệu</option>
					</select>
				</div>

				<!-- {{-- Nút tìm kiếm --}}
				<div>
					<button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm" style="height: 42px;">
						Tìm kiếm
					</button>
				</div> -->

			</form>



			<!-- Filter -->
			<div class="dis-none panel-filter w-full p-t-10">
				<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
					<div class="filter-col1 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Sort By
						</div>

						<ul>
							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Default
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Popularity
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Average rating
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									Newness
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Price: Low to High
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Price: High to Low
								</a>
							</li>
						</ul>
					</div>

					<div class="filter-col2 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Price
						</div>

						<ul>
							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									All
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$0.00 - $50.00
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$50.00 - $100.00
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$100.00 - $150.00
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$150.00 - $200.00
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$200.00+
								</a>
							</li>
						</ul>
					</div>

					<div class="filter-col3 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Color
						</div>

						<ul>
							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #222;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Black
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									Blue
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Grey
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Green
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Red
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
									<i class="zmdi zmdi-circle-o"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									White
								</a>
							</li>
						</ul>
					</div>

					<div class="filter-col4 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Tags
						</div>

						<div class="flex-w p-t-4 m-r--5">
							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Fashion
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Lifestyle
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Denim
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Streetstyle
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Crafts
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if (session('error'))
		<div class="alert alert-danger auto-dismiss">
			{{ session('error') }}
		</div>
		@endif
		<script>
			setTimeout(function() {
				document.querySelectorAll('.auto-dismiss').forEach(function(alert) {
					alert.style.transition = 'opacity 0.5s ease';
					alert.style.opacity = '0';
					setTimeout(() => alert.remove(), 500);
				});
			}, 3000);
		</script>

		<div class="row isotope-grid">
			@foreach ($products as $product)
<!--Sản phẩm theo danh mục -->
		<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ Str::slug($product->category->category_name) }}">
			<div class="block2">
				<div class="block2-pic hov-img0">
					<img src="{{ asset('assets/images/products/' . $product->product_images_1) }}" alt="IMG-PRODUCT">

					<a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}"
						class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
						Quick View
					</a>
				</div>
				<div class="block2-txt flex-w flex-t p-t-14">
					<div class="block2-txt-child1 flex-col-l">
						<a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}"
							class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
							{{ $product->product_name }}
						</a>

						<span class="stext-105 cl3">
							{{ number_format($product->product_price) }} VND
						</span>

						{{-- Nút so sánh sản phẩm --}}
						<a href="{{ route('compare.add', $product->product_id) }}"
							class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
							So sánh
						</a>
					</div>

					<div class="block2-txt-child2 flex-r p-t-3">
						<form action="{{ route('wishlist.toggle', $product->product_id) }}" method="POST">
							@csrf
							<button type="submit" class="btn btn-link p-0 border-0">
								<i class="bi bi-heart{{ in_array($product->product_id, $userWishlistIds ?? []) ? '-fill text-danger' : '' }}"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endforeach

		</div>
		<!-- phan trang -->

		<div class="flex-c-m flex-w w-full p-t-45">
			{{ $products->links() }}
		</div>
	</div>
</section>
<!-- Banner -->
<!-- Product -->
@endsection
@section('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
	Swal.fire({
		icon: 'success',
		title: '{{ session('
		success ') }}',
		showConfirmButton: false,
		timer: 3000
	});
</script>
@endif
@endsection