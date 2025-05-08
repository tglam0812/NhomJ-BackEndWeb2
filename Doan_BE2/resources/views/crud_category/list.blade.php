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
                            <a href="{{ route('categories.readCategory', $category->category_id) }}">View</a> |
                            <a href="{{ route('categories.updateCategory', $category->category_id) }}">Edit</a> |
                            <form action="{{ route('categories.deleteCategory', $category->category_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete {{ $category->category_name }}?')" class="btn-delete">Delete</button>
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

            <!-- Hiển thị phân trang -->
            <div class="pagination">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
<style>
    .category-list {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .category-list .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .category-list h2 {
        font-size: 26px;
        margin-bottom: 20px;
        color: #333;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-form input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 250px;
    }

    .search-form button {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #0056b3;
    }

    .btn-add {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-add:hover {
        background-color: #218838;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .category-table th, .category-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .category-table th {
        background-color: #007bff;
        color: white;
    }

    .category-table td a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .category-table td a:hover {
        text-decoration: underline;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        font-size: 13px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
</style>
