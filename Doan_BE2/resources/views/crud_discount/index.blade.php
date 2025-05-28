@extends('dashboard')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="discount-list">
    <div class="container">
        <h2>Danh sách phiếu giảm giá</h2>

        <a href="{{ route('phieugiam.create') }}" class="btn-add">➕ Thêm phiếu mới</a>

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Danh sách --}}
        @if($ds->isEmpty())
            <div class="alert alert-warning text-center">Hiện chưa có phiếu giảm giá nào.</div>
        @else
            <table class="discount-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên phiếu</th>
                        <th>% Giảm</th>
                        <th>Số lượng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ds as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->ten_phieu }}</td>
                            <td>{{ $item->phan_tram_giam }}%</td>
                            <td>{{ $item->so_luong }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->ngay_bat_dau)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d/m/Y') }}</td>
                            <td>{{ $item->mo_ta }}</td>
                            <td>
                                <a href="{{ route('phieugiam.edit', $item->id) }}" class="btn-edit">✏️ Sửa</a>

                                {{-- Form xóa --}}
                                <button type="button" class="btn-delete" onclick="confirmDelete({{ $item->id }})">🗑️ Xóa</button>

                                <form id="delete-form-{{ $item->id }}" action="{{ route('phieugiam.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Phân trang --}}
            {{ $ds->links('phantrang') }}
        @endif
    </div>
</main>

{{-- SweetAlert confirm --}}
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn có chắc chắn muốn xóa phiếu này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

{{-- CSS --}}
<style>
    .discount-list {
        padding: 20px 0;
        background-color: #f9f9f9;
    }

    .discount-list .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 20px;
    }

    .discount-list h2 {
        font-size: 26px;
        margin-bottom: 20px;
        color: #2c3e50;
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

    .discount-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .discount-table th,
    .discount-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;
    }

    .discount-table th {
        background-color: #007bff;
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #000;
        padding: 5px 10px;
        font-size: 13px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
        display: inline-block;
    }

    .btn-edit:hover {
        background-color: #e0a800;
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
