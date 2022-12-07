@extends('layouts.app-no-nav-and-footer')
@section('styles')
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4 offset-md-4 d-flex align-items-center justify-content-center min-vh-100">
      <div class="card bg-transparent border-0 w-100">
        <div class="card-header bg-transparent border-0">
          <div class="d-flex justify-content-center align-items-center mb-4">
            <img src="{{ asset('apple-icon.png') }}" width="100" height="100"> 
          </div>
          <h5 class="mb-0">{{ __('Login') }}</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('login') }}" data-ajax="true">
            <input type="hidden" name="ref" value="{{ $ref ?? '' }}">
            @csrf
            @include('generate.input', [
              'label' => 'Email',
              'name' => 'email',
              'value' => '',
              'formGroupClass' => '',
            ])
            @include('generate.input', [
              'label' => 'Password',
              'type' => 'password',
              'name' => 'password',
              'value' => '',
              'formGroupClass' => '',
            ])
            <div class="d-flex justify-content-between align-items-start mb-3">
              <a class="btn btn-link p-0" href="{{ route('password.request') }}">
              {{ __('Forgot Your Password?') }}
              </a>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
                </label>
              </div>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-teal mb-5">
              {{ __('Login') }}
              </button>
            </div>
            <div class="text-center">
              <p>Don't have an account? <a href="{{ route('index') }}">Register</a></p>
            </div> 
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
@endsection