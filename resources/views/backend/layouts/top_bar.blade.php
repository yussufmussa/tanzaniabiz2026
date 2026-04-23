<header id="page-topbar">
  <div class="navbar-header">
    <div class="d-flex">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
          <span class="logo-sm">
            <img src="{{asset('uploads/general/' . $setting->logo)}}" alt="logo-sm" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{asset('uploads/general/' . $setting->logo)}}" alt="logo-dark" height="23">
          </span>
        </a>

        <a href="/dashboard" class="logo logo-light">
          <span class="logo-sm">
            <img src="{{asset('uploads/general/' . $setting->logo)}}" alt="logo-sm-light" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{asset('uploads/general/' . $setting->logo)}}" alt="logo-light" height="23">
          </span>
        </a>
      </div>

      <button type="button" class="btn btn-sm px-3 font-size-16 vertinav-toggle header-item waves-effect" id="vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
      </button>

      <button type="button" class="btn btn-sm px-3 font-size-16 horinav-toggle header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
        <i class="fa fa-fw fa-bars"></i>
      </button>

    </div>

    <div class="d-flex">

      <div class="dropdown d-inline-block d-lg-none ms-2">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
        </div>
      </div>

      <div class="dropdown d-none d-lg-inline-block ms-1">
        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
          <i class="mdi mdi-fullscreen"></i>
        </button>
      </div>

      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="rounded-circle header-profile-user" src="{{auth()->user()->profile_picture === 'user.png' ? asset('uploads/profilePictures/user.png') : asset('uploads/profilePictures/'. auth()->user()->profile_picture) }}" alt="Profile Pic">
          <span class="d-none d-xl-inline-block ms-1"></span>
          <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <!-- item-->
          <h6 class="dropdown-header">Welcome </h6>
          <a class="dropdown-item" href="{{route('profile.edit')}}"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle" key="t-profile">Profile</span></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i>
            <span key="t-logout">Log out</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </a>
        </div>
      </div>

    </div>
  </div>
</header>
