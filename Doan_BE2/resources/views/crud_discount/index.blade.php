@extends('layouts.discount-layout')

@section('title', 'Danh sách phiếu giảm giá')

@section('content')
<a href="{{ route('phieugiam.create') }}" class="btn btn-success mb-4">
    ➕ Thêm phiếu mới
</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($ds->isEmpty())
    <div class="alert alert-warning text-center">Hiện chưa có phiếu giảm giá nào.</div>
@else
    <table class="table table-bordered table-hover table-dark text-center align-middle">
        <thead class="table-secondary">
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
                        <a href="{{ route('phieugiam.edit', $item->id) }}" class="btn btn-warning btn-sm mb-1">
                            ✏️ Sửa
                        </a>

                        <form action="{{ route('phieugiam.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                🗑️ Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
