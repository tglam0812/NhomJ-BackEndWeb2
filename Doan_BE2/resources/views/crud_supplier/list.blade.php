@extends('dashboard')

@section('content')
<main class="supplier-list">
    <div class="container">
        <div class="row justify-content-between">
            <h2>Supplier List</h2>
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search suppliers..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <a href="{{ route('suppliers.createSupplier') }}" class="btn-add">Add Supplier</a>
            <table class="supplier-table">
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
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->supplier_id }}</td>
                        <td>{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->supplier_description }}</td>
                        <td>{{ $supplier->supplier_status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <!-- <a href="{{ route('suppliers.readSupplier', $supplier->supplier_id) }}">View</a> | -->
                            <a href="{{ route('suppliers.updateSupplier', $supplier->supplier_id) }}">Edit</a> |
                            <form action="{{ route('suppliers.deleteSupplier', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete {{ $supplier->supplier_name }}?')" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No suppliers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Hiển thị phân trang -->
            <div class="pagination">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
<style>
    .supplier-list {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .supplier-list .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .supplier-list h2 {
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

    .supplier-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .supplier-table th, .supplier-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .supplier-table th {
        background-color: #007bff;
        color: white;
    }

    .supplier-table td a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .supplier-table td a:hover {
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
