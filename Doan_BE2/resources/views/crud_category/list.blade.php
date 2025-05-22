@extends('dashboard')

@section('content')
<main class="category-list">
    <div class="container">
        <div class="row justify-content-between">
            <h2>Category List</h2>
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search categories..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <a href="{{ route('categories.createCategory') }}" class="btn-add">Add Category</a>
            <table class="category-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->category_id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->category_description }}</td>
                        <td>{{ $category->category_status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>

                            <a href="{{ route('categories.updateCategory', $category->category_id) }}">Edit</a> |
                            <form method="POST" action="{{ route('categories.deleteCategory', $category->category_id) }}" class="form-delete" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete"
                                    data-category-name="{{ $category->category_name }}">Delete</button>
                            </form>


                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!--Hiển thị thông báo trong 3 giây -->
                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('alert-message');
                        if (alert) {
                            alert.style.display = 'none';
                        }
                    }, 3000); // thông báo trong 3 giât
                </script>
            </table>

            {{ $categories->links('phantrang') }}

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.form-delete');
                    const categoryName = this.getAttribute('data-category-name');

                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: `Bạn có muốn xóa danh mục "${categoryName}" không?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có',
                        cancelButtonText: 'Hủy',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

</main>
<link rel="stylesheet" href="{{ asset('assets/css/category/list.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection