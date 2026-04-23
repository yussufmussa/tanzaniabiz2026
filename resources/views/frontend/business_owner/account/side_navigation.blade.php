<div class="collapse" id="MobNav">
	<div class="goodup-dashboard-nav sticky-top">
		<div class="goodup-dashboard-inner">
			<ul data-submenu-title="Main Navigation">
				<li class="{{request()->is('owner/dashboard') ? 'active' : ''}}"><a href="{{route('business_owner.dashboard')}}"><i class="lni lni-dashboard me-2"></i>Dashboard</a></li>
				<li class="{{request()->is('owner/listings') ? 'active' : ''}}"><a href="{{route('business-listings.index')}}"><i class="lni lni-files me-2"></i>My Listings</a></li>
				<li class="{{request()->is('owner/listings/create') ? 'active' : ''}}"><a href="{{route('business-listings.add')}}"><i class="lni lni-add-files me-2"></i>Add Listing</a></li>
			</ul>
			
			<ul data-submenu-title="My Accounts">
				<li class="{{request()->is('owner/profile') ? 'active' : ''}}"><a href="{{route('profile.edit')}}"><i class="lni lni-user me-2"></i>My Profile </a></li>
				<li>
					<a class="text-color font-size-15" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<i class="lni lni-power-switch me-2"></i>
						Log out
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
