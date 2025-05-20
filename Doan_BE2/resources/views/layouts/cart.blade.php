<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Giỏ hàng của bạn
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                @php $headerTotal = 0; @endphp

                @if(session()->has('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $item)
                        @php
                            $lineTotal = $item['product_price'] * $item['quantity'];
                            $headerTotal += $lineTotal;
                        @endphp
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <img src="{{ asset('assets/images/products/' . $item['product_image']) }}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    {{ $item['product_name'] }}
                                </a>

                                <span class="header-cart-item-info">
                                    {{ $item['quantity'] }} x {{ number_format($item['product_price']) }} VND
                                </span>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="text-center p-3 w-full"> Giỏ hàng đang trống</li>
                @endif
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Tổng cộng: {{ number_format($headerTotal) }} VND
                </div>

               <div class="header-cart-buttons flex-w w-full justify-center">
                    <a href="{{ route('cart.view') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10 mx-auto">
                        XEM GIỎ HÀNG
                    </a>
                </div>


            </div>
        </div>
    </div>
</div>
