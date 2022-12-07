<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-4 mb-0">Find Your Desired Professor</h1>
  </div>
  <div class="row mb-5">
    <div class="col-md-8 offset-md-2">
      <form action="{{ route('search.index') }}">
        <div class="input-group mb-3 rounded" style="height: 50px;">
          <input type="search" name="search" class="form-control input-lg rounded-5 me-2" placeholder="Search Professor...">
          <button class="btn btn-outline-secondary btn-lg rounded-5 d-flex justify-content-center align-items-center" type="submit" style="width: 100px;">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <div>
    <h4 class="mb-3">Choose Department</h4>
    <div class="slider mb-5" data-slick='{"slidesToShow": 5, "slidesToScroll": 5}'>
      @foreach($courses as $course)
        <div class="p-3">
          <a href="{{ route('search.department', $course->id) }}" class="text-decoration-none text-black">
            <div class="card border-0 shadow-sm h-100 department">
              <img src="{{ $course->icon }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title mt-3">{{ $course->name }}</h5>
                <p class="mb-0 text-muted">Department</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
  <div>
    <h4 class="mb-3">Top Professors</h4>
    <div class="row mb-5">
      @foreach($top_professors as $top_professor)
        <div class="col-md-4 d-flex align-items-stretch">
          <div class="card border-0 shadow-sm mb-3 w-100">
            <a href="{{ route('profile.profile', $top_professor->id) }}" class="text-decoration-none text-black w-100">
              <div class="card-body">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img src="{{ $top_professor->photo }}" width="60" height="60" class="rounded-circle">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h4 class="mb-0">{{ $top_professor->teacherProfile->prefix ?? '' }} {{ $top_professor->first_name }} {{ $top_professor->last_name }}</h4>
                    <p class="mb-0 text-muted">{{ $top_professor->teacherProfile->expertise ?? 'N/A' }}</p>
                    <p class="mb-0">{{ \App\Helpers\Utils::formatArray($top_professor->courses->map(function($course) { return $course->name; })) }}</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@section('javascript')
  <script type="text/javascript">
    $(document).ready(function() {
      
      $('.slider').slick({
          autoplay: false,
          dots: true,
          infinite: false,
          arrows: true,
          rows: 0
      })
      .on('setPosition', function (event, slick) {
        slick.$slides.css('height', slick.$slideTrack.height() + 'px');
      });
      
    });
  </script>
@endsection