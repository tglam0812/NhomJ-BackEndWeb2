<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/png" href="{{ asset('assets/images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/MagnificPopup/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @yield('custom-css')
</head>

<body class="animsition">
    @section('custom-css')
    @endsection

    <!-- Header -->
    @include('layouts.header')

    <!-- Cart -->
    @include('layouts.cart')

    @if(session('success') || session('error'))
		<style>
			#toast-container {
				position: fixed;
				top: 20px;
				right: 20px;
				z-index: 9999;
				animation: slideIn 0.5s ease;
			}

			.toast-custom {
				display: flex;
				align-items: center;
				gap: 10px;
				background-color: {{ session('success') ? '#d1e7dd' : '#f8d7da' }};
				color: {{ session('success') ? '#0f5132' : '#842029' }};
				border-left: 5px solid {{ session('success') ? '#198754' : '#dc3545' }};
				padding: 14px 20px;
				border-radius: 10px;
				box-shadow: 0 4px 12px rgba(0,0,0,0.15);
				min-width: 280px;
				max-width: 400px;
				font-size: 15px;
			}

			.toast-icon {
				font-size: 20px;
			}

			@keyframes slideIn {
				from {
					opacity: 0;
					transform: translateY(-30px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
		</style>

		<div id="toast-container">
			<div class="toast-custom">
				<i class="toast-icon bi {{ session('success') ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }}"></i>
				<div>{{ session('success') ?? session('error') }}</div>
			</div>
		</div>

		<script>
			setTimeout(() => {
				const toast = document.getElementById('toast-container');
				if (toast) {
					toast.style.opacity = '0';
					setTimeout(() => toast.remove(), 500);
				}
			}, 4000);
		</script>
	@endif


    <!-- Content -->
    @yield('main-content')

    <!-- Footer -->
    @include('layouts.footer')

	<script src="{{ asset('assets/css/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<script src="{{ asset('assets/css/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('assets/js/slick-custom.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
	<script src="{{ asset('assets/css/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
		$('.gallery-lb').each(function() {
			$(this).magnificPopup({
		        delegate: 'a',
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
	<script src="{{ asset('assets/css/vendor/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('assets/css/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	</script>
	<script src="{{ asset('assets/css/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('custom-scripts')

	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
