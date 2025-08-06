@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
        <div class="row g-4">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="mb-3">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600?text=No+Image' }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                </div>
                @if($product->images && count($product->images) > 0)
                <div class="row g-2">
                    @foreach($product->images as $image)
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="img-fluid rounded border">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Product Details -->
            <div class="col-lg-6">
                <h1 class="h2 fw-bold mb-2">{{ $product->name }}</h1>
                <p class="lead text-muted mb-3">{{ $product->category->name }}</p>
                <!-- Price -->
                <div class="mb-3">
                    @if($product->sale_price)
                        <span class="h3 fw-bold text-danger">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="h5 text-muted text-decoration-line-through ms-3">${{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-danger ms-3">{{ $product->discount_percentage }}% OFF</span>
                    @else
                        <span class="h3 fw-bold">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
                <!-- Stock Status -->
                <div class="mb-3">
                    @if($product->isInStock())
                        <span class="badge bg-success">In Stock ({{ $product->stock_quantity }} available)</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>
                <!-- Description -->
                <div class="mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                <!-- Product Details -->
                <ul class="list-group mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>SKU:</span>
                        <span class="fw-semibold">{{ $product->sku }}</span>
                    </li>
                    @if($product->weight)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Weight:</span>
                        <span class="fw-semibold">{{ $product->weight }} kg</span>
                    </li>
                    @endif
                    @if($product->dimensions)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Dimensions:</span>
                        <span class="fw-semibold">{{ $product->dimensions }}</span>
                    </li>
                    @endif
                </ul>
                <!-- Add to Cart -->
                @if($product->isInStock())
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group mb-3" style="max-width: 200px;">
                        <label class="input-group-text" for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Add to Cart</button>
                </form>
                @else
                <div class="alert alert-warning">This product is currently out of stock.</div>
                @endif
            </div>
        </div>
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h2 class="h4 fw-bold mb-4">Related Products</h2>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}" alt="{{ $relatedProduct->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <div class="mb-2">
                                @if($relatedProduct->sale_price)
                                    <span class="fw-bold text-danger">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                    <span class="text-muted text-decoration-line-through ms-2">${{ number_format($relatedProduct->price, 2) }}</span>
                                    <span class="badge bg-danger ms-2">{{ $relatedProduct->discount_percentage }}% OFF</span>
                                @else
                                    <span class="fw-bold">${{ number_format($relatedProduct->price, 2) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-secondary btn-sm flex-fill mb-2">View Details</a>
                            @if($relatedProduct->isInStock())
                            <form action="{{ route('cart.add', $relatedProduct) }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Add to Cart</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 