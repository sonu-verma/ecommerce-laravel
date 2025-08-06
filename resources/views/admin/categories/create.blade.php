@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content')
<h1 class="h3 mb-4">Add Category</h1>
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
    <button type="submit" class="btn btn-success">Create Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection