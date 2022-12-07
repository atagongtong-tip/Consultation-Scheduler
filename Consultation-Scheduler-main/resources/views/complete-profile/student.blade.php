<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Complete Profile</h3>
  </div>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <h1 class="mb-4">Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h1>
      <div class="card border-0 shadow-sm">
        <div class="card-body p-5">
          <div class="alert alert-info" role="alert">
            Please complete your profile first.
          </div>
          <form method="POST" action="{{ route('complete-profile.student') }}" data-ajax="true">
            @csrf
            @include('generate.select', [
              'label' => 'Year',
              'name' => 'year',
              'value' => '',
              'options' => [
                [
                  'name' => '1st Year',
                  'value' => '1st Year',
                ],
                [
                  'name' => '2nd Year',
                  'value' => '2nd Year',
                ],
                [
                  'name' => '3rd Year',
                  'value' => '3rd Year',
                ],
                [
                  'name' => '4th Year',
                  'value' => '4th Year',
                ],
              ],
              'formGroupClass' => 'mb-3'
            ])
            @include('generate.select', [
              'label' => 'Course',
              'name' => 'course_id',
              'value' => '',
              'options' => $courses->map(function($course) {
                  return [
                    'name' => $course->long_name,
                    'value' => $course->id,
                  ];
              }),
              'formGroupClass' => 'mb-3'
            ])
            @include('generate.input', [
              'label' => 'Major',
              'name' => 'major',
              'value' => '',
              'formGroupClass' => 'mb-3'
            ])
            @include('generate.input', [
              'label' => 'Student No',
              'name' => 'student_no',
              'value' => '',
              'formGroupClass' => 'mb-3'
            ])
            @include('generate.textarea', [
              'label' => 'Tell us more about you? (Optional)',
              'name' => 'about',
              'value' => '',
              'formGroupClass' => 'mb-3'
            ])
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-teal">
              {{ __('Submit') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>