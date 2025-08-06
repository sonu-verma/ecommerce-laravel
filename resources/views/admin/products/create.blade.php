@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
<h1 class="h3 mb-4">Add Product</h1>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="col-md-6">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0" required>
        </div>
        <div class="col-md-4">
            <label for="sale_price" class="form-label">Sale Price</label>
            <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price') }}" step="0.01" min="0">
        </div>
        <div class="col-md-4">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}" min="0" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" required>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Main Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>
    </div>
    <div class="mb-3">
        <label for="images" class="form-label">Additional Images</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured</label>
            </div>
        </div>
        <div class="col-md-3">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" step="0.01" min="0">
        </div>
        <div class="col-md-3">
            <label for="dimensions" class="form-label">Dimensions</label>
            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions') }}">
        </div>
    </div>
    <button type="submit" class="btn btn-success">Create Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection