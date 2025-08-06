@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Orders</h2>
    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection