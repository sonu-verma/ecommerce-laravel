@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Order #{{ $order->id }}</h1>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Notes:</strong> {{ $order->notes ?? '-' }}</p>
            <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <h6>Items:</h6>
            <ul>
                @foreach($order->orderItems as $item)
                    <li>{{ $item->product->name ?? 'Product deleted' }} x {{ $item->quantity }} @ ${{ number_format($item->price, 2) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <a href="{{ route('orders.my-orders') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to My Orders</a>
</div>
@endsection