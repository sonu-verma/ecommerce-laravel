@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container-fluid">
    <h1>Orders List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection