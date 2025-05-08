@extends('dashboard')

@section('content')
<main class="category-update">
    <div class="container">
        <h2>Update Category</h2>
        <!-- Form sửa danh mục -->
        <form method="POST" action="{{ route('categories.update', $category->category_id) }}" class="category-form">
            @csrf
            @method('PUT') <!-- Dùng PUT cho việc cập nhật -->

            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
                @error('category_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_description">Description</label>
                <textarea id="category_description" name="category_description">{{ old('category_description', $category->category_description) }}</textarea>
                @error('category_description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_status">Status</label>
                <select id="category_status" name="category_status" required>
                    <option value="1" {{ old('category_status', $category->category_status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('category_status', $category->category_status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('category_status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Update Category</button>
            </div>
        </form>
    </div>
</main>
@endsection
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
.category-update textarea,
.category-update select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.category-update textarea {
    height: 150px;
    resize: vertical;
}

.category-update .error {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
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