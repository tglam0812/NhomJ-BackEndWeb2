@extends('layouts.user-auth')

@section('content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <!-- Register Form -->
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card mt-12">
                            <div class="card-header text-center pt-4">
                                 <h5 class="text-success text-gradient">Đăng ký tài khoản</h5>
                            </div>
                            <!-- End of Icons of Social Login -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}" role="form text-left">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" placeholder="Họ và tên" name="full_name" aria-label="Name" aria-describedby="email-addon">
                                        @error('name')
                                            <span class="invalid-feedback text-xs" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" aria-label="Email" aria-describedby="email-addon">
                                        @error('email')
                                            <span class="invalid-feedback text-xs" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu" name="password" aria-label="Password" aria-describedby="password-addon">
                                        @error('password')
                                            <span class="invalid-feedback text-xs" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmation" aria-label="Password" aria-describedby="password-addon">
                                    </div>
                                    <div class="form-check form-check-info text-left">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tôi đồng ý với các <a href="javascript:;" class=" bg-gradient-info font-weight-bolder">Điều khoản và Điều kiện</a>
                                        </label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Đăng ký</button>
                                    </div>
                                    <p class="text-sm mt-3 mb-0">Bạn đã có tài khoản? <a href="{{ route('login') }}" class="text-success text-gradient font-weight-bolder">Đăng nhập</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @stop
