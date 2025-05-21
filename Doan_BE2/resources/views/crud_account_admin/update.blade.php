
@extends('dashboard')
@section('content')
<div class="container">
    <h2>Update Account</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu nhập vào.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('accountAdmin.postUpdate', ['account_id' => $account->user_id]) }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Họ tên:</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $account->full_name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $account->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $account->phone) }}" required>
        </div>

        <div class="mb-3">
            <label>Giới tính:</label>
            <select name="gender" class="form-control" required>
                <option value="Nam" {{ old('gender', $account->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gender', $account->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                <option value="Khác" {{ old('gender', $account->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Ngày sinh:</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $account->date) }}" required>
        </div>

        <div class="mb-3">
            <label>Địa chỉ:</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $account->address) }}" required>
        </div>

        <div class="mb-3">
            <label>Ảnh đại diện hiện tại:</label><br>
            @if ($account->avatar)
                <img src="{{ asset('storage/' . $account->avatar) }}" width="100">
            @else
                <p>Chưa có ảnh</p>
            @endif
        </div>

        <div class="mb-3">
            <label>Thay ảnh đại diện (nếu muốn):</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label for="level_id">Level <span class="text-danger">*</span></label>
            <select name="level_id" id="level_id" required>
                <option value="">-- Select Level --</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                        {{ $level->level_name }}
                    </option>
                @endforeach
            </select>
            @error('level_id')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Trạng thái:</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ old('status', $account->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $account->status) == 0 ? 'selected' : '' }}>Tạm khóa</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Giới thiệu:</label>
            <textarea name="about" class="form-control">{{ old('about', $account->about) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('accountAdmin.list') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<link rel="stylesheet" href="{{ asset('assets/css/account/update.css') }}">
@endsection
