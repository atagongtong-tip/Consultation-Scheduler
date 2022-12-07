@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">{{ ! empty($status) ? ($status === 'Cancelled' ? 'Declined/Cancelled' : $status).' Requests' : 'Appointments' }} </h3>
      @if(! empty($status))
      <div style="width: 150px;">
        <div class="dropdown w-100">
          <button class="btn btn-warning w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Status: {{ $status }}
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('appointments.status', 'Pending') }}">Pending</a></li>
            <li><a class="dropdown-item" href="{{ route('appointments.status', 'Approved') }}">Approved</a></li>
            <li><a class="dropdown-item" href="{{ route('appointments.status', 'Completed') }}">Completed</a></li>
            <li><a class="dropdown-item" href="{{ route('appointments.status', 'Cancelled') }}">Declined/Cancelled</a></li>
          </ul>
        </div>
      </div>
      @endif
    </div>
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white py-3">
        <div class="row">
          <div class="col-md-8 d-flex justify-content-start align-items-center">
            <h5 class="mb-0">List</h5>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <input 
                type="text" 
                class="form-control search-data border-right-0"
                data-url="{{ url()->full() }}"
                data-target="#datas"
                placeholder="Search ..." 
              >
              <div class="input-group-append">
                <button class="btn btn-outline-secondary border-left-0 border bg-white" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="datas">
          @include('appointments.list')
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
@endsection