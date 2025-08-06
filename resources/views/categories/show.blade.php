@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h2 fw-bold mb-2">{{ $category->name }}</h1>
        <p class="text-muted">{{ $category->description }}</p>
    </div>
    @if($category->products && $category->products->count() > 0)
        <div class="row g-4">
            @foreach($category->products as $product)
                @include('products.productCard', ['product' => $product])
            @endforeach
        </div>
    @else
        <div class="alert alert-info mt-4">No products found in this category.</div>
    @endif
</div>
@endsection