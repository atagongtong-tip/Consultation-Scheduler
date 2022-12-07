@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Edit Profile</h3>
    </div>
    <div class="card border-0 shadow-sm">
      <div class="card-body p-5">
        @include('common.edit-profile')
      </div>
    </div>
  </div>
@endsection
@section('javascript')
@endsection