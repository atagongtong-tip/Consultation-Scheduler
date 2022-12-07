@extends('layouts.dashboard')
@section('styles')
@endsection
@section('content')
  <div class="container-fluid">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-5">
        <div class="row">
          <div class="col-md-2">
            <div class="d-flex justify-content-center align-items-center">
              <img src="{{ $data->photo }}" width="150" height="150" class="rounded-circle">
            </div>
          </div>
          <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-start">
              <h1 class="mb-2">{{ $data->teacherProfile->prefix ?? '' }} {{ $data->first_name }} {{ $data->last_name }}</h1>
              <div>
                @include('shared.create-appointment')
              </div>
            </div>
            <h5 class="text-muted">{{ $data->teacherProfile->expertise ?? 'N/A' }}</h5>
            <p class="mb-5">{{ \App\Helpers\Utils::formatArray($data->courses->map(function($course) { return $course->long_name; })) }}</p>
            <h4>About The Professor</h4>
            <p class="mb-5">{{ $data->teacherProfile->about ?? 'N/A' }}</p>
            <h4>Upcoming Schedules</h4>
            @php
              $appointments = $data->teacherAppointments()
              ->where(['status' => 'Approved'])
              ->where('start_schedule' , '>=' , \Carbon\Carbon::now()->toDateTimeString())
              ->orderBy('id', 'DESC')
              ->get();
            @endphp
            @if(count($appointments))
              @foreach($appointments as $key => $schedule)
                <div class="card bg-info border-0 shadow-sm mb-3" style="--bs-bg-opacity: .5;">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="w-100 mb-0 d-flex justify-ceontent-start align-items-start">    
                          <div class="">
                            <h3 class="mb-0 text-white">{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('d') }}</h3>
                            <h6 class="mb-0 text-white">{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('M') }}</h6>
                          </div>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0 text-dark text-decoration-none">Consultation</h5>
                        <p class="mb-0 text-dark text-decoration-none">{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('l') }}, {{ \Carbon\Carbon::parse($schedule->start_schedule)->format('g:i a') }} - {{ \Carbon\Carbon::parse($schedule->end_schedule)->format('g:i a') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <p class="text-muted">No Upcoming Schedule</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
@endsection