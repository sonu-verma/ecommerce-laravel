@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Category Details</h4>
        <a href="{{ route('admin.categories.edit', $category->slug) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
        <form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $category->name }}</p>
        <p><strong>Slug:</strong> {{ $category->slug }}</p>
        <p><strong>Status:</strong> {!! $category->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</p>
        @if($category->image)
            <p><strong>Image:</strong></p>
            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="img-thumbnail" width="200">
        @endif
    </div>
</div>
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Categories</a>
@endsection