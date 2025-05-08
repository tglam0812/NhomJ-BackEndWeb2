@extends('dashboard')

@section('content')
<main class="category-create">
    <div class="container">
        <h2>Add New Category</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="form-category">
            @csrf

            <div class="form-group">
                <label for="category_name">Category Name <span class="text-danger">*</span></label>
                <input type="text" id="category_name" name="category_name" value="{{ old('category_name') }}" required>
            </div>

            <div class="form-group">
                <label for="category_description">Description</label>
                <textarea name="category_description" id="category_description" rows="4">{{ old('category_description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="category_status" value="1" {{ old('category_status', '1') == '1' ? 'checked' : '' }}> Active</label>
                    <label><input type="radio" name="category_status" value="0" {{ old('category_status') == '0' ? 'checked' : '' }}> Inactive</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Category</button>
                <a href="{{ route('categories.list') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</main>

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
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    textarea {
        resize: vertical;
    }

    .radio-group {
        display: flex;
        gap: 15px;
        margin-top: 6px;
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

    .text-danger {
        color: red;
    }
</style>
@endsection