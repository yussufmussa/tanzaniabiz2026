<nav class="navbar navbar-expand bg-navbar dashboard-topbar mb-4">
    <button id="sidebarToggleTop" class="btn rounded-circle mr-3">
        <i class="la la-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown border-left pl-3 ml-4">
            <a class="nav-link dropdown-toggle after-none" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user-thumb user-thumb-sm position-relative">
                    <img src="{{ auth()->user()->profile_picture ? asset('photos/general/'.auth()->user()->profile_picture) : asset('photos/general/user.png')}}" alt="author-image">
                    <div class="status-indicator bg-success"></div>
                </div>
                <span class="ml-2 small font-weight-medium d-none d-lg-inline">{{auth()->user()->name}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right animated--grow-in py-2" aria-labelledby="userDropdown">
                <a class="dropdown-item text-color font-size-15" href="{{route('owner.profile.edit')}}">
                    <i class="la la-user mr-2 text-gray font-size-18"></i>
                    Profile
                </a>
                <a class="dropdown-item text-color font-size-15" href="{{route('owner.listings.create')}}">
                    <i class="la la-plus-circle mr-2 text-gray font-size-18"></i>
                    Add Listing
                </a>

                <a class="dropdown-item text-color font-size-15" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='las la-lock'></i>
                    <span key="t-logout">Log out</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</nav><!-- end dashboard-topbar -->