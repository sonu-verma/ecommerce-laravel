@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Product Details</h4>
        <div>
            <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
            <form action="{{ route('admin.products.destroy', $product->slug) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
            </form>
        </div>
    </div>
    <div class="card-body row">
        <div class="col-md-4">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid mb-3">
            @endif
            @if($product->images)
                <div class="mb-2">
                    @foreach((array)$product->images as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Additional Image" class="img-thumbnail me-2 mb-2" width="80">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h5>{{ $product->name }}</h5>
            <p><strong>Category:</strong> {{ $product->category->name ?? '-' }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            @if($product->sale_price)
                <p><strong>Sale Price:</strong> ${{ number_format($product->sale_price, 2) }}</p>
            @endif
            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
            <p><strong>SKU:</strong> {{ $product->sku }}</p>
            <p><strong>Status:</strong> {!! $product->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</p>
            <p><strong>Featured:</strong> {!! $product->is_featured ? '<span class="badge bg-info">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</p>
            <p><strong>Weight:</strong> {{ $product->weight ?? '-' }}</p>
            <p><strong>Dimensions:</strong> {{ $product->dimensions ?? '-' }}</p>
        </div>
    </div>
</div>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Products</a>
@endsection