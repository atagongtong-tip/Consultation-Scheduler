@extends('layouts.app-no-nav-and-footer')
@section('styles')
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3 d-flex align-items-center justify-content-center min-vh-100">
      <div class="card bg-transparent border-0 w-100">
        <div class="card-header bg-transparent border-0">
          <h5 class="mb-0 text-capitalize">{{ $type }} {{ __('Registration') }}</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('register') }}" data-ajax="true">
            @csrf
            @php
              $roles = [
                'student' => 3,
                'teacher' => 2,
              ];
            @endphp
            <div class="alert alert-primary" role="alert">
              Notes: Use TIP email (**@tip.edu.ph) only
            </div>
            <input type="hidden" name="role_id" value="{{ $roles[$type] }}">
            <div class="row">
              <div class="col">
                @include('generate.input', [
                  'label' => 'First Name',
                  'name' => 'first_name',
                  'value' => '',
                  'formGroupClass' => '',
                ])
              </div>
              <div class="col">
                @include('generate.input', [
                  'label' => 'Last Name',
                  'name' => 'last_name',
                  'value' => '',
                  'formGroupClass' => '',
                ])
              </div>
            </div>
            @include('generate.input', [
              'label' => 'Email',
              'name' => 'email',
              'value' => '',
              'placeholder' => '@tip',
              'formGroupClass' => '',
            ])
            @include('generate.input', [
              'label' => 'Password',
              'type' => 'password',
              'name' => 'password',
              'value' => '',
              'formGroupClass' => '',
            ])
            @include('generate.input', [
              'label' => 'Confirm Password',
              'type' => 'password',
              'name' => 'password_confirmation',
              'value' => '',
              'formGroupClass' => '',
            ])
            <p>Registering means that you agree with our <a href="#" class="">Privacy Policy</a></p>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-teal mb-5">
              {{ __('Register') }}
              </button>
            </div>
            <div class="text-center">
              <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
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