@extends('dashboard')
@section('content')
<main class="brand-update">
    <div class="container">
        <h2>Update Supplier</h2>
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form sửa danh mục -->
        <form method="POST" action="{{ route('brands.update', $brand->brand_id) }}" class="brand-form">
            @csrf
            @method('PUT') <!-- Dùng PUT cho việc cập nhật -->

            <!-- Trường ẩn để lưu giá trị updated_at -->
            <input type="hidden" name="updated_at" value="{{ $brand->updated_at->toDateTimeString() }}">

            <div class="form-group">
                <label for="brand_name">Supplier Name</label>
                <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" required>
                @error('brand_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand_description">Description</label>
                <textarea id="brand_description" name="brand_description">{{ old('brand_description', $brand->brand_description) }}</textarea>
                @error('brand_description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand_status">Status</label>
                <select id="brand_status" name="brand_status" required>
                    <option value="1" {{ old('brand_status', $brand->brand_status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('brand_status', $brand->brand_status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('brand_status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Update Supplier</button>
            </div>
        </form>
    </div>
</main>
@endsection


<style>
.brand-update {
    padding: 20px;
    background-color: #f4f4f9;
}

.brand-update .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.brand-update h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.brand-update .form-group {
    margin-bottom: 15px;
}

.brand-update label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.brand-update input[type="text"],
.brand-update textarea,
.brand-update select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.brand-update textarea {
    height: 150px;
    resize: vertical;
}

.brand-update .error {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
}

.brand-update .error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
    text-align: center;
}

.brand-update .success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
    text-align: center;
}

.brand-update button.btn-submit {
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

.brand-update button.btn-submit:hover {
    background-color: #2980b9;
}

.brand-update button.btn-submit:disabled {
    background-color: #bbb;
    cursor: not-allowed;
}
</style>