@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-4 mb-0">{{ $data->name }} Department</h1>
  </div>
  <div class="row mb-5">
    <div class="col-md-8 offset-md-2">
      <form action="{{ route('search.index') }}">
        <div class="input-group mb-3 rounded" style="height: 50px;">
          <input type="search" name="search" class="form-control input-lg rounded-5 me-2" placeholder="Search Professor..." value="{{ $search }}">
          <button class="btn btn-outline-secondary btn-lg rounded-5 d-flex justify-content-center align-items-center" type="submit" style="width: 100px;">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <div>
    <div class="mb-3">
      @foreach($list as $data)
        <a href="{{ route('profile.profile', $data->id) }}" class="text-decoration-none text-black">
          <div class="card bg-primary border-0 shadow-sm mb-3" style="--bs-bg-opacity: .1;">
            <div class="card-body">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img src="{{ $data->photo }}" width="60" height="60" class="rounded-circle">
                </div>
                <div class="flex-grow-1 ms-3">
                  <h4 class="mb-0">{{ $data->teacherProfile->prefix ?? '' }} {{ $data->first_name }} {{ $data->last_name }}</h4>
                  <p class="mb-0 text-muted">{{ $data->teacherProfile->expertise ?? 'N/A' }}</p>
                  <p class="mb-0">{{ \App\Helpers\Utils::formatArray($data->courses->map(function($course) { return $course->long_name; })) }}</p>
                </div>
              </div>
            </div>
          </div>
        </a>
      @endforeach
    </div>
    @include('shared.pagination')
  </div>
</div>
@endsection