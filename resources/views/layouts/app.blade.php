<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Ecommerce Store')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="min-vh-100 bg-light d-flex flex-column">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i> Cart
                                @php
                                    $cartService = app(\App\Services\CartService::class);
                                    $cartCount = $cartService->getCartItemCount();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('orders.my-orders') }}"><i class="bi bi-bag"></i> My Orders</a></li>
                                    @if(Auth::user()->is_admin)
                                        <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-speedometer2"></i> Admin Panel</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow-1">
            <div class="container py-4">
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
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-white mt-auto py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <h5>About Us</h5>
                        <p>Your trusted online shopping destination for quality products.</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-white-50"><i class="bi bi-house"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-white-50"><i class="bi bi-box"></i> Products</a></li>
                            <li><a href="{{ route('cart.index') }}" class="text-white-50"><i class="bi bi-cart3"></i> Cart</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5>Customer Service</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white-50"><i class="bi bi-envelope"></i> Contact Us</a></li>
                            <li><a href="#" class="text-white-50"><i class="bi bi-truck"></i> Shipping Info</a></li>
                            <li><a href="#" class="text-white-50"><i class="bi bi-arrow-counterclockwise"></i> Returns</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5>Connect With Us</h5>
                        <a href="#" class="text-white-50 me-2"><i class="bi bi-facebook"></i> Facebook</a>
                        <a href="#" class="text-white-50"><i class="bi bi-twitter"></i> Twitter</a>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</small>
                </div>
            </div>
        </footer>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 