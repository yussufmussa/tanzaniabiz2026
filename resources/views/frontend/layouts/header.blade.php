 <!-- Start Navigation -->
 <div class="header header-light dark-text head-border">
     <div class="container">
         <nav id="navigation" class="navigation navigation-landscape">
             <div class="nav-header">
                 <a class="nav-brand" href="/">
                     <img src="{{asset('uploads/general/'.$setting->logo)}}" class="logo" alt="TanzaniaBiz logo" width="150" height="40" />
                 </a>
                 <div class="nav-toggle"></div>
                 <div class="mobile_nav">
                     <ul>
                         <li>
                             <a href="/login"  class="theme-cl fs-lg">
                                 <i class="lni lni-user"></i>
                             </a>
                         </li>
                         <li>
                             <a href="/register" class="crs_yuo12 w-auto text-white theme-bg">
                                 <span class="embos_45"><i class="fas fa-plus me-2"></i>Add Business</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </div>
             <div class="nav-menus-wrapper" style="transition-property: none;">
                 <ul class="nav-menu">

                     <li class="{{request()->is('/') ? 'active' : ''}}"><a href="/">Home</a></li>
                     <li class="{{request()->is('business/categories') ? 'active' : ''}}"><a href="/business/categories">Browse Businessess</a></li>
                     <li class="{{request()->is('jobs') ? 'active' : ''}}"><a href="/jobs-in-tanzania">Jobs</a></li>
                     <li class="{{request()->is('events') ? 'active' : ''}}"><a href="/upcomming-events">Upcomming Events</a></li>
                     <li class="{{request()->is('blog/*') ? 'active' : ''}}"><a href="/blog">Our Blog</a></li>
                     <li class="{{request()->is('contact') ? 'active' : ''}}"><a href="/contact-us">Contact</a></li>


                 </ul>

                 @if(!auth()->user())
                 <ul class="nav-menu nav-menu-social align-to-right">
                     <li>
                         <a href="/login"  class="ft-bold">
                             <i class="fas fa-sign-in-alt me-1 theme-cl"></i>Log In
                         </a>
                     </li>
                     <li class="add-listing">
                         <a href="/register">
                             <i class="fas fa-plus me-2"></i>Add Your Business
                         </a>
                     </li>
                 </ul>
                 @endif

                 @if(auth()->check())
                 <ul class="nav-menu nav-menu-social align-to-right">
                     <li class="add-listing">

                         <a   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <i class="lni lni-power-switch"></i>Logout
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                             </form>
                     </li>
                 </ul>
                 @endif
             </div>
         </nav>
     </div>
 </div>
 <!-- End Navigation -->
