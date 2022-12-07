<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="/" class="nav_logo text-decoration-none w-100 text-center"> 
        <img src="{{ asset('apple-icon.png') }}" width="25" height="25"> 
      </a>
      <div class="nav_list"> 
        <a href="{{ route('dashboard.index') }}" class="nav_link text-white text-decoration-none {{ Route::currentRouteName() === 'dashboard.index' ? 'active' : '' }}"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> 
        </a>
        <a href="{{ route('appointments.index') }}" class="nav_link text-white text-decoration-none {{ Route::currentRouteName() === 'appointments.index' ? 'active' : '' }}"> <i class='bx bxs-calendar-check'></i> <span class="nav_name">Appointments</span> 
        </a>
        <a href="{{ route('profile.index') }}" class="nav_link text-white text-decoration-none {{ Route::currentRouteName() === 'profile.index' ? 'active' : '' }}"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Profile</span> 
        </a>
        <a href="{{ route('profile.change-password') }}" class="nav_link text-white text-decoration-none {{ Route::currentRouteName() === 'profile.change-password' ? 'active' : '' }}"> <i class='bx bx-lock-alt nav_icon'></i> <span class="nav_name">Change Password</span> 
        </a>
    </div>
    <a href="{{ route('logout') }}" class="nav_link text-white text-decoration-none" onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </nav>
</div>