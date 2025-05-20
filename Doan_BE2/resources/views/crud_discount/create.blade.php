@extends('dashboard')
@section('content')

<style>
    .category-create {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-category {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    textarea {
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-save {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-save:hover {
        background-color: #218838;
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }
</style>

<div class="category-create">
    <div class="container">
        <h2>Thêm Phiếu Giảm Giá</h2>

        <form action="{{ route('phieugiam.store') }}" method="POST" class="form-category">
            @csrf

            <div class="form-group">
                <label for="ten_phieu">Tên phiếu *</label>
                <input type="text" name="ten_phieu" id="ten_phieu" required>
            </div>

            <div class="form-group">
                <label for="phan_tram_giam">Phần trăm giảm (%) *</label>
                <input type="number" name="phan_tram_giam" id="phan_tram_giam" min="1" max="100" required>
            </div>

            <div class="form-group">
                <label for="so_luong">Số lượng *</label>
                <input type="number" name="so_luong" id="so_luong" min="1" required>
            </div>

            <div class="form-group">
                <label for="ngay_bat_dau">Ngày bắt đầu *</label>
                <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" required>
            </div>

            <div class="form-group">
                <label for="ngay_ket_thuc">Ngày kết thúc *</label>
                <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" required>
            </div>

            <div class="form-group">
                <label for="mo_ta">Mô tả</label>
                <textarea name="mo_ta" id="mo_ta" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('phieugiam.index') }}" class="btn-cancel">Hủy</a>
                <button type="submit" class="btn-save">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
@endsection

