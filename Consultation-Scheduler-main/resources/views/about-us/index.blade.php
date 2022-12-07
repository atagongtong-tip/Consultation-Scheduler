@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="card border-0 bg-transparent">
      <div class="card-body">
        <div class="mb-4">
          <h2 class="text-danger mb-0 mt-3">About Us</h2>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body text-center">
                <img src="{{ asset('images/mark.jpg') }}" class="rounded-circle bg-secondary mb-4" width="150" height="150" alt="...">
                <h6 class="text-dark">Mark Angelou Barcibal</h6>
                <p class="small text-secondary">Bachelor of Science in Computer Engineering Railway Engineering</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body text-center">
                <img src="{{ asset('images/kyle.jpg') }}" class="rounded-circle bg-secondary mb-4" width="150" height="150" alt="...">
                <h6 class="text-dark">Kyle Rowin Hernandez</h6>
                <p class="small text-secondary">Bachelor of Science in Computer Engineering System Administration</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body text-center">
                <img src="{{ asset('images/aldrich.jpg') }}" class="rounded-circle bg-secondary mb-4" width="150" height="150" alt="...">
                <h6 class="text-dark">Aldrich Macadangdang</h6>
                <p class="small text-secondary">Bachelor of Science in Computer Engineering Railway Engineering</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-4 offset-md-1">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body text-center">
                <img src="{{ asset('images/arvin.jpg') }}" class="rounded-circle bg-secondary mb-4" width="150" height="150" alt="...">
                <h6 class="text-dark">Arvin Tagongtong</h6>
                <p class="small text-secondary">Bachelor of Science in Computer Engineering System Administration</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body text-center">
                <img src="{{ asset('images/avatars/user.png') }}" class="rounded-circle bg-secondary mb-4" width="150" height="150" alt="...">
                <h6 class="text-dark">Jonathan Taylar</h6>
                <p class="small text-secondary mb-0">Adviser</p>
                <p class="small text-secondary">Doctor of Engineering</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
@endsection