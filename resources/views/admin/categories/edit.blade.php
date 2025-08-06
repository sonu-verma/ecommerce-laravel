@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<h1 class="h3 mb-4">Edit Category</h1>
<form action="{{ route('admin.categories.update', $category->slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" class="img-thumbnail mt-2" width="120">
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
    <button type="submit" class="btn btn-success">Update Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
<form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this category?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete Category</button>
</form>
@endsection