<!-- Header -->
<style>
    .user-menu-wrapper {
        position: relative;
        display: inline-block;
        z-index: 1200;
    }
    .sub-menu-m {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        min-width: 180px;
        padding: 8px 0;
        border-radius: 6px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
    }
    .sub-menu-m li {
        width: 100%;
    }
    .sub-menu-m li a {
        display: block;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s, color 0.3s;
        border-left: 4px solid transparent;
    }
    .sub-menu-m li a:hover {
        color: #e74c3c;
        background-color: #f9f9f9;
        border-left: 4px solid #e74c3c;
    }
</style>

<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
                <div class="right-top-bar flex-w h-full">
                    @if (Route::has('login'))
                        @auth
                            <div class="user-menu-wrapper">
                                <a href="javascript:void(0);" class="flex-c-m trans-04 p-lr-25 user-name" id="userToggle">
                                    {{ Auth::user()->full_name }}
                                </a>
                                <ul class="sub-menu-m" id="userMenu">
                                    <li><a href="{{ route('auth.info') }}">Info</a></li>
                                    <li><a href="{{ route('auth.showresetpassword') }}">Change password</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('home') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex-c-m trans-04 p-lr-25">Đăng xuất</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">Đăng nhập</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">Đăng ký</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <a href="#" class="logo">
                    <img src="{{ asset('assets/images/icons/logo-01.png') }}" alt="IMG-LOGO">
                </a>

                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="product.html">Shop</a></li>
                        <li class="label1" data-label1="hot"><a href="shoping-cart.html">Features</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>

                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    @php
                        $cart = session('cart', []);
                        $cartTotal = collect($cart)->sum('quantity');
                    @endphp
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="{{ $cartTotal }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a href="{{ route('wishlist.index') }}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <div class="logo-mobile">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
        </div>

        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="{{ $cartTotal }}">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>
            <a href="{{ route('wishlist.index') }}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box"><span class="hamburger-inner"></span></span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="product.html">Shop</a></li>
            <li><a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{ asset('assets/images/icons/icon-close2.png') }}" alt="CLOSE">
            </button>
            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04"><i class="zmdi zmdi-search"></i></button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("userToggle");
        const menu = document.getElementById("userMenu");

        toggle?.addEventListener("click", function (e) {
            e.preventDefault();
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        });

        document.addEventListener("click", function (event) {
            if (!toggle?.contains(event.target) && !menu?.contains(event.target)) {
                menu.style.display = "none";
            }
        });
    });
</script>