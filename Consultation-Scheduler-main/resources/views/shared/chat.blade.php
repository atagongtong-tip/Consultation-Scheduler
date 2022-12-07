<div class="container-fluid inbox g-0">
  <div class="row clearfix">
    <div class="col-md-8">
      <div class="card chat-app">
        <div class="card-body p-0">
          <div class="chat position-relative">
            @if (isset($conversation))
              <div class="chat-header clearfix">
                  <div class="row">
                    <div class="col-md-8 d-flex justify-content-start align-items-center">
                      <div>
                        <div class="avatars">
                          @foreach ($conversation->participants as $participant)
                            <img src="{{ $participant->user->photo }}" class="avatars__item bg-secondary">
                          @endforeach
                        </div>
                      </div>
                      <div class="chat-about">
                        <h6 class="mb-0">
                          {{ \App\Helpers\Utils::formatArray($conversation->participants->map(function($participant) {
                            if($participant->user->role_id === 2) {
                                return $participant->user->teacherProfile->prefix ?? ''.' '.$participant->user->first_name.' '.$participant->user->last_name; 
                            }

                            return $participant->user->first_name.' '.$participant->user->last_name; 
                          })) }} Chat Conversation
                        </h6>
                      </div>
                    </div>
                    <div class="col-md-4 hidden-sm d-flex justify-content-end align-items-center">
                      <a href="javascript:void(0);" class="btn btn-link me-1"><i class="fa fa-image"></i></a>
                    </div>
                  </div>
              </div>
              <div class="chat-history">
                <ul class="m-b-0" id="chat-history">
                </ul>
              </div>
              <div class="chat-message clearfix" style="bottom: 0;">
                <form id="chat-message" action="{{ route('inbox.send', $conversation->id) }}" method="POST">
                  @csrf
                  <div class="input-group mb-3">
                    <input type="text" name="message" class="form-control" placeholder="Enter text here...">
                    <button class="btn btn-outline-secondary" type="submit">
                      <i class="fas fa-paper-plane"></i>
                    </button>
                  </div>
                </form>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-3">Details</h4>
          <dl class="row">
            <dt class="col-sm-3 text-muted">Schedule</dt>
            <dd class="col-sm-9 h5 text-dark"><span class="" style="color: rgb(0, 168, 152);">{{ \Carbon\Carbon::parse($conversation->appointment->start_schedule)->format('F d, Y, H:i A') }}</span></dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3 text-muted">Subject</dt>
            <dd class="col-sm-9 h6 text-dark">{{ $conversation->appointment->subject ?? 'N/A' }}</dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3 text-muted">Description</dt>
            <dd class="col-sm-9 h6 text-dark">{{ $conversation->appointment->description }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>