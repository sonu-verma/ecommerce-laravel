@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-3"><i class="bi bi-funnel me-2"></i>Filters</h3>
                        <!-- Search -->
                        <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                            <label for="search" class="form-label"><i class="bi bi-search me-1"></i>Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control mb-2">
                        </form>
                        <!-- Categories -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-tags me-1"></i>Categories</label>
                            <div class="list-group">
                                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">All Categories</a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Price Range -->
                        <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <label class="form-label"><i class="bi bi-currency-dollar me-1"></i>Price Range</label>
                            <div class="row g-2 mb-2">
                                <div class="col">
                                    <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="form-control">
                                </div>
                                <div class="col">
                                    <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-funnel me-1"></i>Apply Filter</button>
                        </form>
                        <!-- Sort -->
                        <form method="GET" action="{{ route('products.index') }}" id="sort-form" class="mb-3">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if(request('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            <label for="sort" class="form-label"><i class="bi bi-sort-down me-1"></i>Sort By</label>
                            <select name="sort" id="sort" onchange="this.form.submit()" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>
                        </form>
                        <!-- Clear Filters -->
                        @if(request('search') || request('category') || request('min_price') || request('max_price') || request('sort'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x-circle me-1"></i>Clear All Filters</a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="mb-4">
                    <h1 class="h2 fw-bold">Products</h1>
                    @if($products->total() > 0)
                        <p class="text-muted">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products</p>
                    @endif
                </div>
                @if($products->count() > 0)
                    <div class="row g-4">
                        @foreach($products as $product)
                            @include('products.productCard', ['product' => $product, 'column' => 4])
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="mt-4">
                        @if ($products->hasPages())
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </nav>
                        @endif
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <svg width="48" height="48" fill="currentColor" class="text-secondary mb-2" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4"/></svg>
                        </div>
                        <h3 class="h5">No products found</h3>
                        <p class="text-muted">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 