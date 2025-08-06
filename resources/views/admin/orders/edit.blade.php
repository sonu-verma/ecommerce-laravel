@extends('admin.layouts.app')

@section('title', 'Edit Order')

@section('content')
<h1 class="h3 mb-4">Edit Order #{{ $order->id }}</h1>
<div class="card mb-4">
    <div class="card-body">
        <h5>Order Details</h5>
        <p><strong>Customer:</strong> {{ $order->user->name ?? $order->customer_name }}</p>
        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Notes:</strong> {{ $order->notes ?? '-' }}</p>
        <h6>Items:</h6>
        <ul>
            @foreach($order->orderItems as $item)
                <li>{{ $item->product->name ?? 'Product deleted' }} x {{ $item->quantity }}</li>
            @endforeach
        </ul>
    </div>
</div>
<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">Notes</label>
        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Update Order</button>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection