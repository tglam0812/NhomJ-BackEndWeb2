<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
</head>

<body>
    <header>
        <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
    }

    nav {
        background-color: #343a40;
        padding: 10px;
        text-align: center;
    }

    nav a {
        color: #ffffff;
        text-decoration: none;
        margin: 0 15px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #ffc107;
    }

    .container {
        max-width: 960px;
        margin: auto;
        padding: 40px 20px;
    }

    h3 {
        margin-bottom: 30px;
        color: #2c3e50;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .card + .card {
        margin-top: 20px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    textarea.form-control {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        resize: vertical;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        padding: 10px 15px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .text-muted {
        color: #6c757d;
    }

    .border {
        border: 1px solid #dee2e6 !important;
        border-radius: 6px;
        background-color: #f8f9fa;
        padding: 12px;
    }
</style>


        <nav>
            <a href="{{ route('products.list') }}">Products</a>
            <a href="{{ route('categories.list') }}">Category</a>
            <a href="{{ route('accountAdmin.list') }}">User</a>
            <a href="{{ route('phieugiam.index') }}">Giam gia</a>
            <a href="{{ route('admin.messages') }}">Phản hồi KH</a>
        </nav>
    </header>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>