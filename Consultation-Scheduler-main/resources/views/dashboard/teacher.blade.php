<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-sm-8">
      <h3 class="mb-0">Dashboard</h3>
    </div>
    <div class="col-sm-4 d-flex justify-content-end align-items-center">
      <a class="btn btn-teal" href="{{ route('teacher-availability.index') }}">
        <i class='bx bx-calendar-check'></i> Manage Schedule Availability
      </a>
    </div>
  </div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-4 mb-0">Hi, {{ auth()->user()->teacherProfile->prefix ?? '' }} {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h1>
  </div>
  <div class="row text-center mb-5">
    <div class="col-md-3 mb-3">
      <a href="{{ route('appointments.status', 'Pending') }}" class="text-decoration-none text-dark" role="button">
        <div class="counter hvr-grow w-100 d-flex justify-content-between align-items-center p-3">
          <img src="{{ asset('images/icons/request.png') }}" class="fa-2x me-2">
          <div>
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{ $requests }}</h2>
            <p class="count-text">Request</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('appointments.status', 'Approved') }}" class="text-decoration-none text-dark" role="button">
        <div class="counter hvr-grow w-100 d-flex justify-content-between align-items-center p-3">
          <img src="{{ asset('images/icons/approve.png') }}" class="fa-2x me-2">
          <div>
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{ $approved }}</h2>
            <p class="count-text">Approved</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('appointments.status', 'Completed') }}" class="text-decoration-none text-dark" role="button">
        <div class="counter hvr-grow w-100 d-flex justify-content-between align-items-center p-3">
          <img src="{{ asset('images/icons/check.png') }}" class="fa-2x me-2">
          <div>
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{ $completed }}</h2>
            <p class="count-text">Completed</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('appointments.status', 'Cancelled') }}" class="text-decoration-none text-dark" role="button">
        <div class="counter hvr-grow w-100 d-flex justify-content-between align-items-center p-3">
          <img src="{{ asset('images/icons/close.png') }}" class="fa-2x me-2">
          <div>
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{ $cancelled }}</h2>
            <p class="count-text">Declined/Cancelled</p>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div>
    <h4 class="mb-3">Current Consultation Schedule</h4>
    @php
      $appointments = auth()->user()->teacherAppointments()
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
      <div class="text-center p-5">
        <p class="text-muted">No Consultation Schedule</p>
      </div>
    @endif
  </div>
</div>