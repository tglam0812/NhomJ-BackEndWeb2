@extends('dashboard')

@section('content')
<main class="account-list">
    <div class="container">
        <div class="row justify-content-between">
            <h2>Account List</h2>
            
            <!-- Form tìm kiếm -->
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search accounts..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>

            <!-- Nút thêm tài khoản mới -->
            <a href="{{ route('accountAdmin.create') }}" class="btn-add">Add Account</a>

            <!-- Bảng danh sách tài khoản -->
            <table class="account-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr>
                        <td>{{ $account->user_id }}</td>
                        <td>{{ $account->full_name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ $account->phone }}</td>
                        <td>{{ $account->level->level_name ?? 'N/A' }}</td>
                        <td>{{ $account->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('accountAdmin.read', $account->user_id) }}">View</a> |
                            <a href="{{ route('accountAdmin.update', $account->user_id) }}">Edit</a> |
                            <form action="{{ route('accountAdmin.delete', $account->user_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete {{ $account->full_name }}?')" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No accounts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="pagination">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
</main>

<style>
    /* Custom CSS cho danh sách tài khoản */
    .account-list {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    h2 {
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

    .account-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .account-table th, .account-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .account-table th {
        background-color: #007bff;
        color: white;
    }

    .account-table td a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .account-table td a:hover {
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
</style>
@endsection
