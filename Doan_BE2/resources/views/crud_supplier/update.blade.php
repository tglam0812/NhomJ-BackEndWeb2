@extends('dashboard')

@section('content')
<main class="supplier-update">
    <div class="container">
        <h2>Update Supplier</h2>
        <!-- Form sửa danh mục -->
        <form method="POST" action="{{ route('suppliers.update', $supplier->supplier_id) }}" class="supplier-form">
            @csrf
            @method('PUT') <!-- Dùng PUT cho việc cập nhật -->

            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" id="supplier_name" name="supplier_name" value="{{ old('supplier_name', $supplier->supplier_name) }}" required>
                @error('supplier_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="form-group">
                <label for="supplier_email">Supplier Email</label>
                <input type="text" id="supplier_email" name="supplier_email" value="{{ old('supplier_email', $supplier->supplier_email) }}" required>
                @error('supplier_email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="supplier_description">Description</label>
                <textarea id="supplier_description" name="supplier_description">{{ old('supplier_description', $supplier->supplier_description) }}</textarea>
                @error('supplier_description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="supplier_status">Status</label>
                <select id="supplier_status" name="supplier_status" required>
                    <option value="1" {{ old('supplier_status', $supplier->supplier_status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('supplier_status', $supplier->supplier_status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('supplier_status')
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
.supplier-update {
    padding: 20px;
    background-color: #f4f4f9;
}

.supplier-update .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.supplier-update h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.supplier-update .form-group {
    margin-bottom: 15px;
}

.supplier-update label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.supplier-update input[type="text"],
.supplier-update textarea,
.supplier-update select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.supplier-update textarea {
    height: 150px;
    resize: vertical;
}

.supplier-update .error {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
}

.supplier-update button.btn-submit {
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

.supplier-update button.btn-submit:hover {
    background-color: #2980b9;
}

.supplier-update button.btn-submit:disabled {
    background-color: #bbb;
    cursor: not-allowed;
}
</style>