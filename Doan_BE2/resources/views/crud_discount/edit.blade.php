@extends('dashboard')

@section('content')
<style>
    .category-update {
        padding: 20px;
        background-color: #f4f4f9;
    }

    .category-update .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-update h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .category-update .form-group {
        margin-bottom: 15px;
    }

    .category-update label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .category-update input[type="text"],
    .category-update input[type="number"],
    .category-update input[type="date"],
    .category-update textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .category-update textarea {
        height: 120px;
        resize: vertical;
    }

    .category-update button.btn-submit {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .category-update button.btn-submit:hover {
        background-color: #2980b9;
    }

    .category-update button.btn-submit:disabled {
        background-color: #bbb;
        cursor: not-allowed;
    }
</style>

<div class="category-update">
    <div class="container">
        <h2>Cập Nhật Phiếu Giảm Giá</h2>

        <form action="{{ route('phieugiam.update', $pg->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="ten_phieu">Tên phiếu *</label>
                <input type="text" name="ten_phieu" id="ten_phieu"
                       value="{{ old('ten_phieu', $pg->ten_phieu) }}" required>
            </div>

            <div class="form-group">
                <label for="phan_tram_giam">Phần trăm giảm (%) *</label>
                <input type="number" name="phan_tram_giam" id="phan_tram_giam"
                       value="{{ old('phan_tram_giam', $pg->phan_tram_giam) }}" min="1" max="100" required>
            </div>

            <div class="form-group">
                <label for="so_luong">Số lượng *</label>
                <input type="number" name="so_luong" id="so_luong"
                       value="{{ old('so_luong', $pg->so_luong) }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="ngay_bat_dau">Ngày bắt đầu *</label>
                <input type="date" name="ngay_bat_dau" id="ngay_bat_dau"
                       value="{{ old('ngay_bat_dau', \Carbon\Carbon::parse($pg->ngay_bat_dau)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="ngay_ket_thuc">Ngày kết thúc *</label>
                <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc"
                       value="{{ old('ngay_ket_thuc', \Carbon\Carbon::parse($pg->ngay_ket_thuc)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="mo_ta">Mô tả</label>
                <textarea name="mo_ta" id="mo_ta">{{ old('mo_ta', $pg->mo_ta) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Cập nhật</button>
        </form>
    </div>
</div>
@endsection
