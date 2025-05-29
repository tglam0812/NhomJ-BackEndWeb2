@extends('dashboard')
@section('content')
<div class="container">
    <h2>Update Account Admin</h2>

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
            <label for="full_name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name', $account->full_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $account->email) }}" required>
        </div>

        <!-- Đổi pass
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>  -->

        <div class="mb-3">
            <label for="phone">Phone Number <span class="text-danger">*</span></label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $account->phone) }}" required>
        </div>

        <div class="mb-3">
            <label>Gender <span class="text-danger">*</span></label>
            <div>
                <label><input type="radio" name="gender" value="male" {{ old('gender', strtolower($account->gender)) == 'male' ? 'checked' : '' }}> Male</label>&nbsp;&nbsp;
                <label><input type="radio" name="gender" value="female" {{ old('gender', strtolower($account->gender)) == 'female' ? 'checked' : '' }}> Female</label>&nbsp;&nbsp;
                <label><input type="radio" name="gender" value="other" {{ old('gender', strtolower($account->gender)) == 'other' ? 'checked' : '' }}> Other</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="date">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $account->date) }}" required>
        </div>

        <div class="mb-3">
            <label for="address">Address <span class="text-danger">*</span></label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $account->address) }}" required>
        </div>

        <div class="mb-3">
            <label for="level_id">Level <span class="text-danger">*</span></label>
            <select name="level_id" id="level_id" class="form-control" required>
                <option value="">-- Select Level --</option>
                @foreach ($levels as $level)
                <option value="{{ $level->level_id }}" {{ old('level_id', $account->level_id) == $level->level_id ? 'selected' : '' }}>
                    {{ $level->level_name }}
                </option>
                @endforeach
            </select>
            @error('level_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status <span class="text-danger">*</span></label>
            <div>
                <label><input type="radio" name="status" value="1" {{ old('status', $account->status) == 1 ? 'checked' : '' }}> Active</label>&nbsp;&nbsp;
                <label><input type="radio" name="status" value="0" {{ old('status', $account->status) == 0 ? 'checked' : '' }}> Inactive</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="about">About</label>
            <textarea id="about" name="about" class="form-control" rows="4">{{ old('about', $account->about) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Current Avatar</label><br>
            @if ($account->avatar)
            <img src="{{ asset('storage/' . $account->avatar) }}" width="100" alt="avatar">
            @else
            <p>No avatar uploaded.</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="avatar">Change Avatar</label>
            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Account</button>
        <a href="{{ route('accountAdmin.list') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/account/update.css') }}">
@endsection