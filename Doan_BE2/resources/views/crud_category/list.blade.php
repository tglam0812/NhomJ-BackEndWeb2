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
                    @if (session('success'))
                    <div class="alert alert-success auto-dismiss">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger auto-dismiss">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if (session('warning'))
                    <div class="alert alert-warning auto-dismiss">
                        {{ session('warning') }}
                    </div>
                    @endif


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
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.auto-dismiss').forEach(function(el) {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '0';

                    setTimeout(function() {
                        if (el && el.parentNode) {
                            el.parentNode.removeChild(el);
                        }
                    }, 500); // đợi hiệu ứng mờ xong mới xóa
                });
            }, 3000); // 3 giây sau bắt đầu ẩn
        });
    </script>

</main>
<link rel="stylesheet" href="{{ asset('assets/css/category/list.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
<style>
    .alert {
        padding: 12px 20px;
        margin: 10px 0;
        border-radius: 4px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding-left: 0;
    }

    .pagination li {
        margin: 0 3px;
    }

    .pagination li a,
    .pagination li span {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
        color: #007bff;
        background-color: #fff;
        transition: 0.3s;
    }

    .pagination li a:hover {
        background-color: #007bff;
        color: #fff;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: #fff;    
        border-color: #007bff;
    }

    .pagination li.disabled span {
        color: #6c757d;
    }
</style>