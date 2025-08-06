@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="py-4">
    <div class="container">
        <div class="mb-4">
            <h1 class="h2 fw-bold">Checkout</h1>
        </div>
        <div class="row g-4">
            <!-- Checkout Form -->
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h5 fw-semibold mb-4">Shipping & Billing Information</h2>
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <!-- Shipping Address -->
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address *</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" required class="form-control" placeholder="Enter your complete shipping address">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Billing Address -->
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Billing Address *</label>
                                <textarea name="billing_address" id="billing_address" rows="3" required class="form-control" placeholder="Enter your complete billing address">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}" class="form-control" placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Notes -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">Order Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Any special instructions or notes for your order">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Place Order Button -->
                            <button type="submit" class="btn btn-primary w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Order Summary -->
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h5 fw-semibold mb-3">Order Summary</h2>
                        <!-- Cart Items -->
                        <ul class="list-group mb-4">
                            @foreach($cartItems as $item)
                            <li class="list-group-item d-flex align-items-center">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/50x50?text=No+Image' }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;">
                                <div class="flex-fill">
                                    <div class="fw-semibold">{{ $item->product->name }}</div>
                                    <div class="small text-muted">Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <!-- Order Totals -->
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Subtotal:</span>
                                <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Tax (10%):</span>
                                <span class="fw-semibold">${{ number_format($tax, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Shipping:</span>
                                <span class="fw-semibold">${{ number_format($shipping, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h5 mb-0 fw-bold">${{ number_format($total, 2) }}</span>
                            </li>
                        </ul>
                        <!-- Back to Cart -->
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">Back to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 