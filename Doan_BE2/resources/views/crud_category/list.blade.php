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
