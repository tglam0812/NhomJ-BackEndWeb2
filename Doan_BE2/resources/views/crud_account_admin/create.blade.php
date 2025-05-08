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
@endsection
<style>.account-admin-create {
    padding: 30px 0;
    background-color: #f9f9f9;
    min-height: 100vh;
}

.account-admin-create .container {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.account-admin-create h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 26px;
    color: #333;
}

.form-account-admin .form-group {
    margin-bottom: 20px;
}

.form-account-admin label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #444;
}

.form-account-admin input[type="text"],
.form-account-admin input[type="email"],
.form-account-admin input[type="password"],
.form-account-admin input[type="date"],
.form-account-admin input[type="file"],
.form-account-admin select,
.form-account-admin textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
}

.form-account-admin .radio-group {
    display: flex;
    gap: 20px;
}

.form-account-admin .radio-group label {
    font-weight: normal;
    color: #333;
}

.form-account-admin .error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.btn-save, .btn-cancel {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    text-decoration: none;
    text-align: center;
}

.btn-save {
    background-color: #28a745;
    color: white;
}

.btn-save:hover {
    background-color: #218838;
}

.btn-cancel {
    background-color: #dc3545;
    color: white;
}

.btn-cancel:hover {
    background-color: #c82333;
}
</style>