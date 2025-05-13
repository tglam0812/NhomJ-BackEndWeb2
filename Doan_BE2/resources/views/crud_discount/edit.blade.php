@extends('dashboard')
@section('content')
<form action="{{ route('phieugiam.update', $pg->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="ten_phieu" class="form-label">Tên phiếu</label>
        <input type="text" name="ten_phieu" id="ten_phieu" class="form-control"
               value="{{ old('ten_phieu', $pg->ten_phieu) }}" required>
    </div>

    <div class="mb-3">
        <label for="phan_tram_giam" class="form-label">Phần trăm giảm (%)</label>
        <input type="number" name="phan_tram_giam" id="phan_tram_giam" class="form-control"
               value="{{ old('phan_tram_giam', $pg->phan_tram_giam) }}" required min="1" max="100">
    </div>

    <div class="mb-3">
        <label for="so_luong" class="form-label">Số lượng</label>
        <input type="number" name="so_luong" id="so_luong" class="form-control"
               value="{{ old('so_luong', $pg->so_luong) }}" required min="1">
    </div>

    <div class="mb-3">
        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
        <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control"
               value="{{ old('ngay_bat_dau', \Carbon\Carbon::parse($pg->ngay_bat_dau)->format('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
        <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control"
               value="{{ old('ngay_ket_thuc', \Carbon\Carbon::parse($pg->ngay_ket_thuc)->format('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label for="mo_ta" class="form-label">Mô tả</label>
        <textarea name="mo_ta" id="mo_ta" class="form-control" rows="3">{{ old('mo_ta', $pg->mo_ta) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection
