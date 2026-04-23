<!-- Start Navigation -->
<div class="header header-light dark-text head-border">
	<div class="container-fluid px-4">
		<nav id="navigation" class="navigation navigation-landscape">
			<div class="nav-header">
				<a class="nav-brand" href="/">
					<img src="{{asset('photos/general/'.$setting->first()->logo)}}" class="logo" alt="TanzaniaBiz logo" />

				</a>
				<div class="nav-toggle"></div>
				<div class="mobile_nav">
					<ul>
						<li>
							<a href="/login" class="theme-cl fs-lg">
								<i class="lni lni-user"></i>
							</a>
						</li>
						<li>
							<a href="/register" class="crs_yuo12 w-auto text-white theme-bg">
								<span class="embos_45"><i class="fas fa-plus me-2"></i>Add Listing</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="nav-menus-wrapper">
				<form class="main-search-wrap fl-wrap half-column" method="get" action="{{route('listings.search')}}">@csrf
					<div class="main-search-item">
						<span class="search-tag">Find</span>
						<input type="text" class="form-control radius" name="keywords" placeholder="Nail salons, plumbers, takeout..." />
					</div>
					<div class="main-search-item">
						<span class="search-tag">Where</span>
						<input type="text" class="form-control" name="city" placeholder="Dar es salaam, mwanza" />
					</div>
					<div class="main-search-button">
						<button class="btn full-width theme-bg text-white" type="submit"><i class="fas fa-search"></i></button>
					</div>
				</form>

				<ul class="nav-menu nav-menu-social align-to-right">
					<li>
						<a href="/login" class="ft-bold">
							<i class="fas fa-sign-in-alt me-1 theme-cl"></i>Sign In
						</a>
					</li>
					<li class="add-listing">
						<a href="/register">
							<i class="fas fa-plus me-2"></i>Add Business
						</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>
<!-- End Navigation -->
<div class="clearfix"></div>
