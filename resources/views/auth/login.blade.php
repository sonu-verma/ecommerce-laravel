<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
    <div class="text-center mb-4">
      <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png" alt="Logo" width="48" height="48" class="mb-2">
      <h2 class="h4 mb-0">Sign in to your account</h2>
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
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" type="email" name="email" class="form-control" required autofocus autocomplete="email" value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
      </div>
      <div class="mb-3 d-flex justify-content-between align-items-center">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <a href="#" class="small text-decoration-none">Forgot password?</a>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </form>
    <div class="mt-3 text-center">
      <span class="text-muted">Not a member?</span>
      <a href="{{ route('register') }}" class="text-primary text-decoration-none">Register</a>
    </div>
  </div>
</div>
@endsection