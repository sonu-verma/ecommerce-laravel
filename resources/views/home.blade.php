@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="py-4">
    <div class="container">
        <!-- Hero Section -->
        <div class="bg-primary bg-gradient rounded shadow mb-5 p-5 text-center text-white">
            <h1 class="display-4 mb-3">Welcome to Our Ecommerce Store</h1>
            <p class="lead mb-4">Discover amazing products at great prices</p>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg fw-semibold">Shop Now</a>
        </div>

        <!-- Featured Products -->
        @if($featuredProducts->count() > 0)
        <div class="mb-5">
            <h2 class="h2 fw-bold mb-4">Featured Products</h2>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                 @include('products.productCard', ['product' => $product])
                @endforeach
            </div>
        </div>
        @endif

        <!-- Categories -->
        @if($categories->count() > 0)
        <div class="mb-5">
            <h2 class="h2 fw-bold mb-4">Shop by Category</h2>
            <div class="row g-4">
                @foreach($categories as $category)
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="{{ route('categories.show', $category) }}" class="card h-100 shadow-sm text-decoration-none text-dark">
                        <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/400x200?text=' . urlencode($category->name) }}" alt="{{ $category->name }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text small text-muted">{{ $category->description }}</p>
                            <span class="badge bg-primary">{{ $category->products_count }} products</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Latest Products -->
        @if($latestProducts->count() > 0)
        <div class="mb-5">
            <h2 class="h2 fw-bold mb-4">Latest Products</h2>
            <div class="row g-4">
                @foreach($latestProducts as $product)
                 @include('products.productCard', ['product' => $product])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 