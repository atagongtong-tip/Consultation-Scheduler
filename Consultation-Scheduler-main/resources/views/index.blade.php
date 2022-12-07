@extends('layouts.app-no-nav-and-footer')
@section('styles')
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3 d-flex align-items-center justify-content-center min-vh-100">
      <div>
        <h1 class="text-center">{{ config('app.name') }}</h1>
        <img src="{{ asset('images/5251-removebg-preview.png') }}" class="w-100 mb-4">
        <div class="d-grid gap-2 mb-4">
          <a class="btn btn-lg btn-teal" href="{{ route('register', ['type' => 'teacher']) }}">SIGN UP AS A TEACHER</a>
          <a class="btn btn-lg btn-teal" href="{{ route('register', ['type' => 'student']) }}">SIGN UP AS A STUDENT</a>
        </div>
        <div class="text-center">
          <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
          <a href="{{ route('about-us') }}">About Consultation Scheduler</a>
        </div> 
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
@endsection