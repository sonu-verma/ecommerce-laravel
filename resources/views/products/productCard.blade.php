 <div class="col-12 col-md-6 col-lg-{{ isset($column) && $column ? $column : 3 }}">
    <div class="card h-100 shadow-sm">
        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://ecohealthinstitute.com.free/touche/img/product-placeholder.png' }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text small text-muted mb-2">{{ $product->category->name }}</p>
            <div class="mb-2">
                @if($product->sale_price)
                    <span class="fw-bold text-danger">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-muted text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                    <span class="badge bg-danger ms-2">{{ $product->discount_percentage }}% OFF</span>
                @else
                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <div class="d-flex gap-2 mt-auto">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary btn-sm flex-fill">View Details</a>
                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-fill">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>