@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Category</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                @if($category->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.show', $category->slug) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                <a href="{{ route('admin.categories.edit', $category->slug) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No categories found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@if(method_exists($categories, 'links'))
    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endif
@endsection