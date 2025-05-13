<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Phiếu Giảm Giá')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font: Optional -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #1f1f1f;
            color: #f5f5f5;
            font-family: 'Quicksand', sans-serif;
        }
        .btn-primary, .btn-success {
            border-radius: 8px;
        }
        .container {
            background-color: #2a2a2a;
            border-radius: 12px;
            padding: 30px;
        }
        h2 {
            color: #ffb347;
            text-align: center;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>@yield('title')</h2>
        <hr class="mb-4">
        @yield('content')
    </div>
</body>
</html>
