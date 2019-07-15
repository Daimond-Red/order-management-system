@include('layouts.header')
	<!-- end:: Header -->
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

		<!-- begin:: Subheader -->
		<div class="kt-subheader kt-grid__item" id="kt_subheader">
			@yield('pageBar')
		</div>

		<!-- end:: Subheader -->

		<!-- begin:: Content -->
		<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
			@yield('content')
		</div>

		<!-- end:: Content -->
	</div>
@include('layouts.footer')