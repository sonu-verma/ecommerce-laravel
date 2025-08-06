@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
    <div class="text-center mb-4">
      <i class="bi bi-person-plus display-4 text-primary mb-2"></i>
      <h2 class="h4 mb-0">Create your account</h2>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input id="name" name="name" type="text" class="form-control" required autofocus value="{{ old('name') }}">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" name="email" type="email" class="form-control" required value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" class="form-control" required autocomplete="new-password">
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
    </form>
    <div class="mt-3 text-center">
      <span class="text-muted">Already have an account?</span>
      <a href="{{ route('login') }}" class="text-primary text-decoration-none">Sign in</a>
    </div>
  </div>
</div>
@endsection