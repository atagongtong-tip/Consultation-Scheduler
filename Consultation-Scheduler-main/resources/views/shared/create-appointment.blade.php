<button class="btn btn-teal" type="button" data-bs-toggle="modal" data-bs-target="#create-appointment">
  <i class='bx bx-calendar-event'></i> Schedule Appointment
</button>
<form method="POST" action="{{ route('appointments.create') }}" data-ajax="true">
  <div class="modal" tabindex="-1" id="create-appointment">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title">Schedule Appointment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="position-relative">
                    <h4 class="text-center mb-4">Select Available Slot</h4>
                    <div id="calendar"></div>
                  </div>
                  <input type="hidden" name="teacher_id" value="{{ $data->id }}">
                  <input type="hidden" name="start_schedule" id="start_schedule">
                  <input type="hidden" name="end_schedule" id="end_schedule">
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="alert alert-primary" role="alert">
                Please wait for the calendar to fully load
              </div>
              <h4 class="text-center mb-4">Your selected date is:</h4>
              <h4 id="date-selected" class="text-success  text-center">No Date Selected Yet</h4>
              @include('generate.input', [
                'label' => 'Subject',
                'name' => 'subject',
                'value' => '',
                'formGroupClass' => 'mb-3'
              ])
              @include('generate.textarea', [
                'label' => 'Description',
                'rows' => 7,
                'name' => 'description',
                'value' => '',
                'formGroupClass' => 'mb-3'
              ])
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>
@php
  $schedules = [];
  $teacherAvailability = $data->teacherAvailability()->get();
  $teacherAppointments = $data->teacherAppointments()->where(['status' => 'Approved'])->get();
  foreach($teacherAvailability as $key => $availability) {
    $schedules[] = [
      'id' => $availability->id,
      'day' => $availability->day,
      'label' => date("g:i A", strtotime($availability->time_start)).' - '.date("g:i A", strtotime($availability->time_end)),
      'time_start' => $availability->time_start,
      'time_end' => $availability->time_end,
    ];
  }
@endphp
<script type="text/javascript">
    const teacher_appointments = JSON.parse('{!! json_encode($teacherAppointments) !!}');
    const schedules = JSON.parse('{!! json_encode($schedules) !!}');

    function isAvailable(date) {
      for (var i = teacher_appointments.length - 1; i >= 0; i--) {
        if (teacher_appointments[i].start_schedule === date) {
          return false;
        }
      }

      return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(() => {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          dateClick: function(event) {
            // alert(JSON.stringify(event));
          },
          validRange: function(nowDate) {
            return {
              start: nowDate,
              // end: nowDate.add(1, 'months')
            };
          },
          editable: true,
          events: schedules.map(schedule => ({
            title: `${schedule.label}`,
            startRecur: schedule.time_start,
            endRecur: schedule.time_end,
            daysOfWeek: [schedule.day],
            color: 'green',   // an option!
            textColor: 'white',
            schedule: schedule,
          })),
          eventDidMount: function(info) {
            const schedule = info.event.extendedProps.schedule;

            info.el.style.backgroundColor = isAvailable(`${moment(info.event.start).format('YYYY-MM-DD')} ${schedule.time_start}`) ? 'green' : 'grey';
            info.el.style.borderColor = isAvailable(`${moment(info.event.start).format('YYYY-MM-DD')} ${schedule.time_start}`) ? 'green' : 'grey';
          },
          eventClick: function(info) {
            info.jsEvent.preventDefault();
            const schedule = info.event.extendedProps.schedule;

            if (!isAvailable(`${moment(info.event.start).format('YYYY-MM-DD')} ${schedule.time_start}`)) {
              return alert('Not Available');
            }

            const selected = document.getElementById('date-selected');
            selected.innerHTML = `${moment(info.event.start).format('LL')} ${schedule.label}`

            $('#start_schedule').val(`${moment(info.event.start).format('YYYY-MM-DD')} ${schedule.time_start}`);
            $('#end_schedule').val(`${moment(info.event.start).format('YYYY-MM-DD')} ${schedule.time_end}`);
          }
        });
        setTimeout(() => {calendar.render()}, 1000);
      }, 2000);
    });
</script>