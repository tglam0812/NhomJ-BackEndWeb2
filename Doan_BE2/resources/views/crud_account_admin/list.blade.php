@extends('dashboard')

@section('content')
<main class="account-list">
    <div class="container">
        <div class="row justify-content-between">
            <h2>Account List</h2>
            <form method="GET" class="mb-3 d-flex search-form">
                <input type="text" name="search" placeholder="Search accounts..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <a href="{{ route('accountAdmin.create') }}" class="btn-add">Add Account</a>
            <table class="account-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Level</th>

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

                        <td>

                            <a href="{{ route('accountAdmin.update', $account->user_id) }}">Edit</a> |
                            <form method="POST" action="{{ route('accountAdmin.delete', $account->user_id) }}" class="form-delete" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete" data-account-name="{{ $account->full_name }}">Delete</button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No accounts found.</td>
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
            {{ $accounts->links('phantrang') }}



        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.form-delete');
                    const accountName = this.getAttribute('data-account-name');

                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: `Bạn có muốn xóa tài khoản "${accountName}" không?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có',
                        cancelButtonText: 'Hủy',
                        reverseButtons: false // Có bên trái, Hủy bên phải
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
<link rel="stylesheet" href="{{ asset('assets/css/account/list.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection