@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Product</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? '-' }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock_quantity }}</td>
            <td>
                @if($product->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.products.show', $product->slug) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.products.destroy', $product->slug) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No products found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@if(method_exists($products, 'links'))
    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endif
@endsection