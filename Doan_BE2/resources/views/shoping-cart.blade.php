@extends('layouts.master')

@section('title')
E - Sunshine
@endsection

@section('custom-css')
@endsection

@section('main-content')
<!-- breadcrumb -->
<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="/" class="stext-109 cl8 hov-cl1 trans-04">
			Home
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>
		<span class="stext-109 cl4">
			Shopping Cart
		</span>
	</div>
</div>

<!-- Shopping Cart -->
<section class="bg0 p-t-75 p-b-85">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<div class="wrap-table-shopping-cart">
						<table class="table-shopping-cart">
							<tr class="table_head">
								<th class="column-1">Product</th>
								<th class="column-2"></th>
								<th class="column-3">Price</th>
								<th class="column-4">Quantity</th>
								<th class="column-5">Total</th>
							</tr>
							@php $total = 0; @endphp
							@if(session()->has('cart') && count(session('cart')) > 0)
								@foreach(session('cart') as $item)
									@php $lineTotal = $item['product_price'] * $item['quantity']; $total += $lineTotal; @endphp
									<tr class="table_row">
										<td class="column-1">
											<div class="how-itemcart1">
												<img src="{{ asset('assets/images/products/' . $item['product_image']) }}" alt="IMG">
											</div>
										</td>
										<td class="column-2">{{ $item['product_name'] }}</td>
										<td class="column-3">{{ number_format($item['product_price']) }} VND</td>
										<td class="column-4">{{ $item['quantity'] }}</td>
										<td class="column-5">{{ number_format($lineTotal) }} VND</td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="5" class="text-center text-danger py-3">🛒 Giỏ hàng đang trống</td></tr>
							@endif
						</table>
					</div>
				</div>
			</div>

			<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
					<h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>
					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">Subtotal:</span>
						</div>
						<div class="size-209">
							<span class="mtext-110 cl2">{{ number_format($total) }} VND</span>
						</div>
					</div>
					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208">
							<span class="mtext-101 cl2">Total:</span>
						</div>
						<div class="size-209 p-t-1">
							<span class="mtext-110 cl2">{{ number_format($total) }} VND</span>
						</div>
					</div>
					<a href="{{ route('checkout.index') }}" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
						Proceed to Checkout
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('custom-scripts')
@endsection
