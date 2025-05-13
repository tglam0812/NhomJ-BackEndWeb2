@extends('layouts.discount-layout')

@section('title', 'Thêm phiếu giảm giá')

@section('content')
<form action="{{ route('phieugiam.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="ten_phieu" class="form-label">Tên phiếu</label>
        <input type="text" name="ten_phieu" id="ten_phieu" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="phan_tram_giam" class="form-label">Phần trăm giảm (%)</label>
        <input type="number" name="phan_tram_giam" id="phan_tram_giam" class="form-control" min="1" max="100" required>
    </div>

    <div class="mb-3">
        <label for="so_luong" class="form-label">Số lượng</label>
        <input type="number" name="so_luong" id="so_luong" class="form-control" min="1" required>
    </div>

    <div class="mb-3">
        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
        <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
        <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="mo_ta" class="form-label">Mô tả</label>
        <textarea name="mo_ta" id="mo_ta" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Thêm mới</button>
</form>
@endsection
