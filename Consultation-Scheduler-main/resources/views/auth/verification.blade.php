@extends('layouts.app-no-nav-and-footer')
@section('styles')
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4 offset-md-4 d-flex align-items-center justify-content-center min-vh-100">
      <div class="card bg-transparent border-0 w-100">
        <div class="card-header bg-transparent border-0">
          <h1>{{ __('Verify Email') }}</h1>
        </div>
        <div class="card-body">
          <div class="alert alert-success" role="alert">
            Please check your email for verification code.
          </div>
          <form method="POST" action="{{ route('verification.post') }}" data-ajax="true">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            @include('generate.input', [
              'label' => 'Enter Verification Code',
              'name' => 'code',
              'value' => '',
              'formGroupClass' => '',
            ])
            <button type="submit" class="btn btn-primary mb-5">
            {{ __('Submit') }}
            </button>
          </form>
          <form method="POST" action="{{ route('verification.resend') }}" data-ajax="true">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn btn-link p-0 m-0">{{ __('click here to request another') }}</button>.
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
@endsection