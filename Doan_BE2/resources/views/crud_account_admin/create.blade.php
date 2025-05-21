@extends('dashboard')

@section('content')
<main class="account-admin-create">
    <div class="container">
        <h2>Add New Account Admin</h2>
        <form action="{{ route('accountAdmin.store') }}" method="POST" enctype="multipart/form-data" class="form-account-admin">
            @csrf

            <div class="form-group">
                <label for="full_name">Full Name <span class="text-danger">*</span></label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" required>
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Gender <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Male</label>
                    <label><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Female</label>
                    <label><input type="radio" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}> Other</label>
                </div>
                @error('gender')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" id="date" name="date" value="{{ old('date') }}" required>
                @error('date')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address <span class="text-danger">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
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

            <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}> Active</label>
                    <label><input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}> Inactive</label>
                </div>
                @error('status')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="about">About</label>
                <textarea id="about" name="about" rows="4">{{ old('about') }}</textarea>
                @error('about')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                @error('avatar')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Account</button>
                <a href="{{ route('accountAdmin.list') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</main>
<link rel="stylesheet" href="{{ asset('assets/css/account/create.css') }}">
@endsection