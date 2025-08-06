@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="mb-4">
            <h1 class="h2 font-weight-bold text-dark">Shopping Cart</h1>
        </div>

        @if($cartItems->count() > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h5 font-weight-semibold text-dark mb-3">Cart Items ({{ $cartItems->count() }})</h2>
                            
                            <div>
                                @foreach($cartItems as $item)
                                <div class="d-flex align-items-center p-3 border rounded mb-3">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 mr-3">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100x100?text=No+Image' }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="img-thumbnail" style="width:80px; height:80px; object-fit:cover;">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-grow-1">
                                        <h3 class="h6 font-weight-bold text-dark mb-1">{{ $item->product->name }}</h3>
                                        <p class="mb-0 text-muted small">{{ $item->product->category->name }}</p>
                                        <p class="mb-0 text-secondary small">SKU: {{ $item->product->sku }}</p>
                                        
                                        @if($item->product->sale_price)
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="h6 font-weight-bold text-danger">${{ number_format($item->product->sale_price, 2) }}</span>
                                                <span class="small text-muted ml-2"><del>${{ number_format($item->product->price, 2) }}</del></span>
                                            </div>
                                        @else
                                            <div class="h6 font-weight-bold text-dark mt-1">${{ number_format($item->product->price, 2) }}</div>
                                        @endif
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="ml-3">
                                        <form action="{{ route('cart.update', $item->product) }}" method="POST" class="form-inline">
                                            @csrf
                                            @method('PUT')
                                            <label for="quantity-{{ $item->id }}" class="mr-2 small font-weight-bold text-secondary">Qty:</label>
                                            <input type="number" 
                                                   name="quantity" 
                                                   id="quantity-{{ $item->id }}" 
                                                   value="{{ $item->quantity }}" 
                                                   min="0" 
                                                   max="{{ $item->product->stock_quantity }}"
                                                   class="form-control form-control-sm mr-2" style="width:60px;">
                                            <button type="submit" class="btn btn-link btn-sm text-primary p-0">Update</button>
                                        </form>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="ml-3 text-right">
                                        <div class="h6 font-weight-bold text-dark mb-0">${{ number_format($item->subtotal, 2) }}</div>
                                        <div class="small text-muted">{{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</div>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="ml-3">
                                        <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm text-danger p-0">
                                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Clear Cart Button -->
                            <div class="mt-4 pt-3 border-top">
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger font-weight-bold p-0">
                                        Clear Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h5 font-weight-semibold text-dark mb-3">Order Summary</h2>
                            
                            <div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="font-weight-medium">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax (10%):</span>
                                    <span class="font-weight-medium">${{ number_format($total * 0.1, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping:</span>
                                    <span class="font-weight-medium">$10.00</span>
                                </div>
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="h6 font-weight-bold text-dark">Total:</span>
                                        <span class="h6 font-weight-bold text-dark">${{ number_format($total + ($total * 0.1) + 10, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <div class="mt-4">
                                @auth
                                    <a href="{{ route('checkout.index') }}" 
                                       class="btn btn-primary btn-block font-weight-bold">
                                        Proceed to Checkout
                                    </a>
                                @else
                                    <div>
                                        <p class="small text-muted text-center mb-2">Please login to proceed with checkout</p>
                                        <a href="{{ route('login') }}" 
                                           class="btn btn-primary btn-block font-weight-bold mb-2">
                                            Login to Checkout
                                        </a>
                                        <a href="{{ route('register') }}" 
                                           class="btn btn-light btn-block font-weight-bold">
                                            Create Account
                                        </a>
                                    </div>
                                @endauth
                            </div>

                            <!-- Continue Shopping -->
                            <div class="mt-3">
                                <a href="{{ route('products.index') }}" 
                                   class="btn btn-light btn-block font-weight-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-5">
                <svg class="mb-3" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                </svg>
                <h3 class="h6 font-weight-bold text-dark">Your cart is empty</h3>
                <p class="small text-muted">Start shopping to add items to your cart.</p>
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary font-weight-bold">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection