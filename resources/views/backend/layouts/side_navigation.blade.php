<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                {{-- Dashboard --}}
                @role('admin|editor|writer')
                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect">
                            <i class='bx bxs-dashboard'></i>
                            <span key="t-dashboard">Dashboard</span>
                        </a>
                    </li>
                @endrole

                @canany(['view.business_listings', 'manage.business_listings'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class='bx bxs-group'></i>
                            <span key="t-apps">Business Listings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            @canany(['view.business_listings', 'manage.business_listings'])
                                <li>
                                    <a href="{{ route('listings.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Submitted Listings</span>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['view.packages', 'manage.packages'])
                                <li>
                                    <a href="{{ route('packages.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Packages</span>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['view.categories', 'manage.categories'])
                                <li>
                                    <a href="{{ route('categories.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('subcategories.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Sub Categories</span>
                                    </a>
                                </li>
                            @endcanany
                             @canany(['view.cities', 'manage.cities'])
                                <li>
                                    <a href="{{ route('cities.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Cities</span>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['view.social_medias', 'manage.social_medias'])
                                <li>
                                    <a href="{{ route('socialmedias.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Social Medias</span>
                                    </a>
                                </li>
                            @endcanany

                        </ul>
                    </li>
                @endcanany

                {{-- Users --}}
                @canany(['view.users', 'manage.users', 'view.roles', 'manage.roles', 'view.login_history'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class='bx bxs-group'></i>
                            <span key="t-apps">Users</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            @canany(['view.users', 'manage.users'])
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Users</span>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['view.roles', 'manage.roles'])
                                <li>
                                    <a href="{{ route('roles.index') }}">
                                        <span><i class='bx bx-list-ul'></i>Roles</span>
                                    </a>
                                </li>
                            @endcanany

                            @can('view.login_history')
                                <li>
                                    <a href="{{ route('login.history') }}">
                                        <span><i class='bx bx-list-ul'></i>Login History</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcanany

                {{-- Settings --}}
                @canany(['manage.general_settings', 'manage.seo'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class='bx bxs-cog'></i>
                            <span key="t-apps">Settings</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">

                            @can('manage.general_settings')
                                <li>
                                    <a href="{{ route('general.settings') }}">
                                        <span><i class='bx bx-list-ul'></i>General Settings</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('mail.settings') }}">
                                        <span><i class='bx bx-envelope'></i>Mail Configurations</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('google.recaptcha') }}">
                                        <span><i class='bx bxs-bot'></i>Google Recaptcha</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('social.login.settings') }}">
                                        <span><i class='bx bxl-facebook-circle'></i>Social Logins</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('system.info') }}">
                                        <span><i class='bx bxs-package'></i>System Info</span>
                                    </a>
                                </li>
                            @endcan

                            @can('manage.seo')
                                <li>
                                    <a href="{{ route('seo') }}">
                                        <span><i class='bx bx-list-ul'></i>SEO Manager</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcanany

                {{-- Profile --}}
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin','manager','writer','business_owner','editor']))
                    <li>
                        <a href="{{ route('profile.edit') }}" class="waves-effect">
                            <i class='bx bx-user-circle'></i>
                            <span>Profile</span>
                        </a>
                    </li>
                @endif

                {{-- Logout --}}
                <li>
                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='fas fa-sign-out-alt'></i>
                        <span>Logout</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>