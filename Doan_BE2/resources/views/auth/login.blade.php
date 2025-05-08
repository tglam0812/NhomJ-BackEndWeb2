@extends('layouts.user-auth')

@section('content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <!-- Login Form -->
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card mt-5">
                            <div class="card-header text-center pt-4">
                                 <h5 class="text-success text-gradient">Đăng nhập</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" role="form">
                                    @csrf
                                    <label>Email</label>
                                    <div class="mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Example @mail.com" name="email" aria-label="Email" aria-describedby="email-addon">
                                        @error('email')
                                            <span class="invalid-feedback text-xs" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label>Mật khẩu</label>
                                    <div class="mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu" name="password" aria-label="Password" aria-describedby="password-addon">
                                        @error('password')
                                        <span class="invalid-feedback text-xs" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Bạn chưa có tài khoản ?
                                    <a href="{{ route('register') }}" class="text-info text-gradient font-weight-bold">Đăng ký</a>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-info text-gradient" href="#" onclick="return confirm('Hệ thống đang bảo trì. Vui lòng quay lại sau ! Cảm ơn.')">
                                            {{ __('Quên mật khẩu đăng nhập?') }}
                                        </a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection	
