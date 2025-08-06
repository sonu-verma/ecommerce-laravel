@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { background: #f8fafc; }
        .sidebar {
            min-height: 100vh;
            background: #212529;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #adb5bd;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: #fff;
            background: #343a40;
        }
        .sidebar .nav-link i { margin-right: 8px; }
    </style>
</head>
<body>
@if(Auth::check() && Auth::user()->is_admin)
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar py-4">
            <div class="position-sticky">
                <h4 class="px-3 mb-4">Admin Panel</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="#">
                            <i class="bi bi-house"></i> Master
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-tags"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-bag"></i> Orders
                        </a>
                    </li>
                </ul>
                <hr class="my-4">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-arrow-left"></i> Back to Store
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-start"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@else
    <div class="container py-5 text-center">
        <h2>Unauthorized</h2>
        <p>You do not have access to this page.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>