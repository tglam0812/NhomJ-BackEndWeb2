@extends('dashboard')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="brand-list">
    @if (session('success'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    </script>
    @endif

    @if (session('error'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session("error") }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    </script>
    @endif

    <div class="container">
        <div class="row justify-content-between">
            <h2>Brand List</h2>
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search brands..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <div class="col-md-4 text-end">
                <a href="{{ route('brands.createBrand') }}" class="btn-add me-2">Add Brand</a>
            </div>

            <table class="brand-table">
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
                    @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->brand_id }}</td>
                        <td>{{ $brand->brand_name }}</td>
                        <td>{{ $brand->brand_description }}</td>
                        <td>{{ $brand->brand_status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('brands.updateBrand', $brand->brand_id) }}">Edit</a> |
                            <form action="{{ route('brands.deleteBrand', $brand->brand_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete {{ $brand->brand_name }}?')" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No brands found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $brands->links('phantrang') }}
        </div>
    </div>
</main>

<style>
.brand-list {
    padding: 20px 0;
    background-color: #f9f9f9;
}

.brand-list .container {
    max-width: 1200px;
    margin: 0 auto;
}

.brand-list h2 {
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

.brand-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}

.brand-table th,
.brand-table td {
    padding: 12px;
    border: 1px solid #dee2e6;
    text-align: left;
}

.brand-table th {
    background-color: #007bff;
    color: white;
}

.brand-table td a {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.brand-table td a:hover {
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
@endsection
