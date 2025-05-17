<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
</head>

<body>
    <header>

        <nav>
            <a href="{{ route('products.list') }}">Products</a>
            <a href="{{ route('categories.list') }}">Category</a>
            <a href="{{ route('accountAdmin.list') }}">User</a>
            <a href="{{ route('phieugiam.index') }}">Giam gia</a>
            <a href="{{ route('suppliers.list') }}">Supplier</a>
        </nav>
    </header>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>