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
<link rel="stylesheet" href="{{ asset('assets/css/category/update.css') }}">
@endsection
