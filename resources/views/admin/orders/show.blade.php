@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<h1 class="h3 mb-4">Order #{{ $order->id }}</h1>
<div class="card mb-4">
    <div class="card-body">
        <p><strong>Customer:</strong> {{ $order->user->name ?? $order->customer_name }}</p>
        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Notes:</strong> {{ $order->notes ?? '-' }}</p>
        <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
        <h6>Items:</h6>
        <ul>
            @foreach($order->orderItems as $item)
                <li>{{ $item->product->name ?? 'Product deleted' }} x {{ $item->quantity }}</li>
            @endforeach
        </ul>
    </div>
</div>
<a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left"></i> Back to Orders</a>
@endsection