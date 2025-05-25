@extends('dashboard')

@section('content')
<main class="category-create">
    <div class="container">
        <h2>Add New Category</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="form-category">
            @csrf
            {{-- Hiển thị lỗi validation --}}
            @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
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
                <a href="{{ route('categories.list') }}" class="btn-cancel">Trở về</a>
            </div>
        </form>
    </div>
</main>
<link rel="stylesheet" href="{{ asset('assets/css/category/create.css') }}">
@endsection