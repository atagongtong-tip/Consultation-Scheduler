@include('shared.pagination')
@if(count($list))
<div class="mb-3">
  @foreach ($list as $data)
    <div class="card bg-primary border-0 shadow-sm mb-3" style="--bs-bg-opacity: .1;">
      <div class="card-body">
        <div class="d-flex">
          <div class="flex-shrink-0">
            <img src="{{ (auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin') ? $data->user->photo : $data->teacher->photo }}" width="60" height="60" class="rounded-circle">
          </div>
          <div class="flex-grow-1 ms-3">
            @if(auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin')
              <h5 class="mb-0 text-dark text-decoration-none">{{ $data->user->first_name }} {{ $data->user->last_name }}</h5>
              <p class="mb-0 text-muted text-decoration-none">{{ $data->user->studentProfile->year }}, {{ $data->user->studentProfile->course->name }}, {{ $data->user->studentProfile->major }}</p>
              <p class="text-dark text-decoration-none">Student No. {{ $data->user->studentProfile->student_no }}</p>
              <h6 class="mb-0">{{ $data->subject ?? 'N/A' }}</h6>
            @else
              <h5 class="mb-0 text-dark text-decoration-none">{{ $data->teacher->first_name }} {{ $data->teacher->last_name }}</h5>
              <p class="mb-0 text-dark text-decoration-none">{{ $data->teacher->teacherProfile->expertise ?? 'N/A' }}</p>
              <p class="text-dark text-decoration-none">{{ \App\Helpers\Utils::formatArray($data->teacher->courses->map(function($course) { return $course->name; })) }}</p>
            @endif
            @if(empty($status))
            <p class="mb-0">{{ $data->status }}</p>
            @endif
          </div>
          <div>
            <button class="btn btn-teal" type="button" data-bs-toggle="modal" data-bs-target="#view-{{ $data->id }}">
              View @if($data->status === 'Pending') Request @endif
            </button>
            <div class="modal" tabindex="-1" id="view-{{ $data->id }}">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">View @if($data->status === 'Pending') Request @endif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex mb-4">
                      <div class="flex-shrink-0">
                        <img src="{{ (auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin') ? $data->user->photo : $data->teacher->photo }}" width="60" height="60" class="rounded-circle">
                      </div>
                      <div class="flex-grow-1 ms-3">
                        @if(auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin')
                          <h5 class="mb-0 text-dark text-decoration-none">{{ $data->user->first_name }} {{ $data->user->last_name }}</h5>
                          <p class="mb-0 text-muted text-decoration-none">{{ $data->user->studentProfile->year }}, {{ $data->user->studentProfile->course->name }}, {{ $data->user->studentProfile->major }}</p>
                          <p class="text-dark text-decoration-none">Student No. {{ $data->user->studentProfile->student_no }}</p>
                          <h6 class="mb-0">{{ $data->subject ?? 'N/A' }}</h6>
                        @else
                          <h5 class="mb-0 text-dark text-decoration-none">{{ $data->teacher->teacherProfile->prefix ?? '' }} {{ $data->teacher->first_name }} {{ $data->teacher->last_name }}</h5>
                          <p class="mb-0 text-dark text-decoration-none">{{ $data->teacher->teacherProfile->expertise ?? 'N/A' }}</p>
                          <p class="text-dark text-decoration-none">{{ \App\Helpers\Utils::formatArray($data->teacher->courses->map(function($course) { return $course->name; })) }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="card mb-3">
                      <div class="card-header border-0 bg-white">
                        Details
                      </div>
                      <div class="card-body">
                        <dl class="row">
                          <dt class="col-sm-3 text-muted">Schedule</dt>
                          <dd class="col-sm-9 h5 text-dark"><span class="" style="color: rgb(0, 168, 152);">
                            {{ \Carbon\Carbon::parse($data->start_schedule)->format('F d, Y') }} 
                            {{ \Carbon\Carbon::parse($data->start_schedule)->format('g:i A') }} - {{Carbon\Carbon::parse($data->end_schedule)->format('g:i A') }}</span></dd>
                        </dl>
                        <dl class="row">
                          <dt class="col-sm-3 text-muted">Subject</dt>
                          <dd class="col-sm-9 h6 text-dark">{{ $data->subject ?? 'N/A' }}</dd>
                        </dl>
                        <dl class="row">
                          <dt class="col-sm-3 text-muted">Description</dt>
                          <dd class="col-sm-9 h6 text-dark">{{ $data->description }}</dd>
                        </dl>
                        @if($data->status !== 'Pending' && $data->status !== 'Cancelled' && $data->status !== 'Declined')
                          <dl class="row">
                            <dt class="col-sm-3 text-muted">Consultation Type</dt>
                            <dd class="col-sm-9 h6 text-dark">{{ $data->type }}</dd>
                          </dl>
                          @if($data->type === 'Video Platform')
                          <dl class="row">
                            <dt class="col-sm-3 text-muted">Video Consultation Meeting Link</dt>
                            <dd class="col-sm-9 h6 text-dark">
                              @if(auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin')
                                <a href="https://{{ $data->meeting_url }}" class="text-info text-decoration-none"><i class='bx bx-camera-home'></i>  {{ $data->meeting_url }}</a>
                              @else
                              <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true">
                                <input type="hidden" name="type" value="{{ $data->type }}">
                                <div class="d-flex justify-content-center align-items-start">
                                  <div class="input-group me-2">
                                    <span class="input-group-text bg-white" id="inputGroup-sizing-sm">
                                      <i class='bx bx-camera-home'></i>
                                    </span>
                                    <input type="text" class="form-control" name="meeting_url" placeholder="Video Consultation Meeting Link" value="{{ $data->meeting_url }}">
                                  </div>
                                  <button class="btn btn-outline-secondary" type="submit">Save</button>
                                </div>
                              </form>
                              @endif
                            </dd>
                          </dl>
                          @else
                          <dl class="row">
                            <dt class="col-sm-3 text-muted">Chat Link</dt>
                            <dd class="col-sm-9 h6 text-dark"><a href="{{ route('inbox.show', $data->conversation_id) }}" class="text-info text-decoration-none"><i class='bx bxs-chat'></i> Open Chat</a></dd>
                          </dl>
                          @endif
                        @endif
                        <dl class="row">
                          <dt class="col-sm-3 text-muted">Status</dt>
                          <dd class="col-sm-9 h6 text-dark">{{ $data->status }}</dd>
                        </dl>
                      </div>
                    </div>
                    @if((auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin') && $data->status === 'Pending')
                      <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true" id="ApprovedForm">
                        <input type="hidden" name="status" value="Approved">
                        <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label me-3">Choose Consultation Type: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="chat" value="Chat Consultation">
                            <label class="form-check-label" for="chat" style="color: rgb(0, 168, 152);">
                              <i class='bx bxs-chat'></i> Chat Consultation
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="video" value="Video Platform">
                            <label class="form-check-label" for="video" style="color: rgb(0, 168, 152);">
                              <i class='bx bx-camera-home'></i> Video Platform
                            </label>
                          </div>
                        </div>
                      </form>
                    @endif
                  </div>
                  @if((auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin') && $data->status === 'Pending')
                    <div class="modal-footer">
                      <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true">
                        <input type="hidden" name="status" value="Declined">
                        <button type="submit" class="btn btn-danger">Decline</button>
                      </form>
                      <button type="button" class="btn btn-success" onclick="$('#ApprovedForm').submit();">Approve</button>
                    </div>
                  @endif
                  @if((auth()->user()->role->slug === 'teacher' || auth()->user()->role->slug === 'admin'))
                    @if($data->status === 'Approved')
                      <div class="modal-footer">
                        <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true">
                          <input type="hidden" name="status" value="Cancelled">
                          <button type="submit" class="btn btn-danger">Cancel Appointment</button>
                        </form>
                        <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true">
                          <input type="hidden" name="status" value="Completed">
                          <button type="submit" class="btn btn-success">Completed</button>
                        </form>
                      </div>
                    @endif
                  @else
                    @if($data->status === 'Approved')
                      <div class="modal-footer">
                        <form method="POST" action="{{ route('appointments.update', $data->id) }}" data-ajax="true">
                          <input type="hidden" name="status" value="Cancelled">
                          <button type="submit" class="btn btn-danger">Cancel Appointment</button>
                        </form>
                      </div>
                    @endif
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@else
<div class="text-center p-5">
  <p class="text-muted">No {{ ! empty($status) ? $status.' Request' : 'Appointment' }} Yet</p>
</div>
@endif
@include('shared.pagination')