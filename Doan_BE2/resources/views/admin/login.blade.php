<form action="{{ route('admin.login') }}" method="POST" class="login-form">
    @csrf

    <h2 class="form-title">Đăng nhập quản trị</h2>

    <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div class="form-group">
        <button type="submit">Đăng nhập</button>
    </div>

    @if($errors->any())
    <div class="form-errors">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif
</form>
<style>
    .login-form {
        max-width: 400px;
        margin: 80px auto;
        padding: 30px 25px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-title {
        text-align: center;
        margin-bottom: 25px;
        color: #2c3e50;
        font-size: 24px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #34495e;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
    }

    .form-group button {
        width: 100%;
        padding: 10px 15px;
        background: #007bff;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .form-group button:hover {
        background: #0056b3;
    }

    .form-errors p {
        color: red;
        font-size: 14px;
        margin: 5px 0 0;
    }
</style>