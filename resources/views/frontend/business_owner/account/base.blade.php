@include('frontend.business_owner.account.header_files')
<body>
<div id="main-wrapper">
		
            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->
            <!-- Start Navigation -->
			@include('frontend.layouts.header')
			<!-- End Navigation -->
			<div class="clearfix"></div>
			<!-- ============================================================== -->
			<!-- Top header  -->
			<!-- ============================================================== -->
			
			<!-- ======================= dashboard Detail ======================== -->
			<div class="goodup-dashboard-wrap gray px-4 py-5">
				<a class="mobNavigation" data-bs-toggle="collapse" href="#MobNav" role="button" aria-expanded="false" aria-controls="MobNav">
					<i class="fas fa-bars me-2"></i>Dashboard Navigation
				</a>
				@include('frontend.business_owner.account.side_navigation')
				
                @yield('contents')
				
					
					<!-- footer -->
				    @include('frontend.business_owner.account.footer')
				</div>
				
			</div>
			<!-- ======================= dashboard Detail End ======================== -->
			
			<a id="tops-button" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
			

		</div>

@include('frontend.business_owner.account.footer_files')