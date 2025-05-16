<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
        }
        .sidebar {
            width: 220px;
            background: #f4f4f4;
            padding: 20px;
            height: 100vh;
            box-sizing: border-box;
        }
        .sidebar h3 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a, .sidebar ul li form button {
            color: #007bff;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: normal;
        }
        .sidebar ul li form button:hover,
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background: #fafafa;
            min-height: 100vh;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Admin Menu</h3>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('products.index') }}">Products</a></li>
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
            <li><a href="{{ route('orders.index') }}">Orders</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="content">
        <h1>@yield('title', 'Admin Dashboard')</h1>
        @yield('content')
    </div>
</body>
</html>
