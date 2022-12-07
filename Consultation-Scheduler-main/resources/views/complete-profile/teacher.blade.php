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
          <form method="POST" action="{{ route('complete-profile.teacher') }}" data-ajax="true">
            @csrf
            @include('generate.select', [
              'label' => 'Prefix',
              'name' => 'prefix',
              'value' => '',
              'options' => [
                [
                  'name' => 'Ms',
                  'value' => 'Ms.',
                ],
                [
                  'name' => 'Miss',
                  'value' => 'Miss.',
                ],
                [
                  'name' => 'Mrs',
                  'value' => 'Mrs.',
                ],
                [
                  'name' => 'Mr',
                  'value' => 'Mr.',
                ],
                [
                  'name' => 'Doctor (Dr)',
                  'value' => 'Dr.',
                ], 
                [
                  'name' => 'Professor (Prof)',
                  'value' => 'Prof.',
                ], 
                [
                  'name' => 'Engineer (Eng)',
                  'value' => 'Eng.',
                ], 
              ],
              'formGroupClass' => 'mb-3'
            ])

            @include('generate.input', [
              'label' => 'Expertise',
              'name' => 'expertise',
              'value' => '',
              'formGroupClass' => 'mb-3'
            ])
            <label class="mb-2">Course</label>
            <ul class="list-group mb-3">
              @php
                $teacherCourses = [];
              @endphp
              @foreach($courses as $course)
                <li class="list-group-item">
                  @include('generate.checkbox', [
                    'label' => $course->name.' ('.$course->long_name.')',
                    'name' => 'courses[]',
                    'value' => $course->id,
                    'formGroupClass' => 'mb-0',
                    'checked' => in_array($course->id, $teacherCourses) ? true: false,
                  ])
                </li>
              @endforeach
            </ul>
            @include('generate.textarea', [
              'label' => 'Tell us more about you?',
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