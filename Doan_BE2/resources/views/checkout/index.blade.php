@extends('layouts.master')

@section('title', 'Thanh toán')

@section('main-content')
<div class="container checkout-container">
    <h4>Thông tin người nhận hàng</h4>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="fullname">Họ và tên:</label>
            <input type="text" name="fullname" id="fullname" class="form-control" value="{{ old('fullname') }}" required>
            @error('fullname')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address">Địa chỉ:</label>
            <textarea
                name="address"
                id="address"
                rows="3"
                class="form-control @error('address') is-invalid @enderror"
                required>{{ old('address') }}</textarea>

            @error('address')
                <div class="invalid-feedback d-block fw-semibold mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <button type="submit" class="btn btn-dark w-100">Xác nhận đặt hàng</button>
    </form>
</div>
@endsection

@section('custom-css')
<style>
    .checkout-container {
        margin-top: 80px;
        max-width: 600px;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .checkout-container h4 {
        margin-bottom: 25px;
        font-weight: bold;
        color: #333;
    }

    .checkout-container label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
    }

    .checkout-container input,
    .checkout-container textarea {
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .checkout-container button {
        margin-top: 20px;
        width: 100%;
        background-color: #222;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 25px;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    .checkout-container button:hover {
        background-color: #444;
    }
</style>
@endsection
