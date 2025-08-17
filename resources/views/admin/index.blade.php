<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Preskool - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Preskool Admin Template</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="asset/assets/img/favicon.png">

	<!-- Theme Script js -->
	<script src="asset/assets/js/theme-script.js"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="asset/assets/css/bootstrap.min.css">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/icons/feather/feather.css">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/tabler-icons/tabler-icons.css">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/daterangepicker/daterangepicker.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/select2/css/select2.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="asset/assets/plugins/fontawesome/css/all.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="asset/assets/css/bootstrap-datetimepicker.min.css">

	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="asset/assets/plugins/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="asset/assets/plugins/owlcarousel/owl.theme.default.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="asset/assets/css/style.css">

</head>

<body>

	<div id="global-loader">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<div class="header">

			<!-- Logo -->
			<div class="header-left active">
				<a href="index.html" class="logo logo-normal">
					<img src="asset/assets/img/logo.svg" alt="Logo">
				</a>
				<a href="index.html" class="logo-small">
					<img src="asset/assets/voter/logo/logo.png" alt="Logo">
				</a>
				<a href="index.html" class="dark-logo">
					<img src="asset/assets/img/logo-dark.svg" alt="Logo">
				</a>
				<a id="toggle_btn" href="javascript:void(0);">
					<i class="ti ti-menu-deep"></i>
				</a>
			</div>
			<!-- /Logo -->

			<a id="mobile_btn" class="mobile_btn" href="#sidebar">
				<span class="bar-icon">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</a>

			<div class="header-user">
				<div class="nav user-menu">

					<!-- Search -->
					<div class="nav-item nav-search-inputs me-auto">
						<!-- <div class="top-nav-search">
							<a href="javascript:void(0);" class="responsive-search">
								<i class="fa fa-search"></i>
							</a>
							<form action="#" class="dropdown">
								<div class="searchinputs" id="dropdownMenuClickable">
									<input type="text" placeholder="Search">
									<div class="search-addon">
										<button type="submit"><i class="ti ti-command"></i></button>
									</div>
								</div>
							</form>
						</div> -->
					</div>
					<!-- /Search -->

						<div class="pe-1">
							<a href="#" id="dark-mode-toggle"
								class="dark-mode-toggle activate btn btn-outline-light bg-white btn-icon me-1">
								<i class="ti ti-moon"></i>
							</a>
							<a href="#" id="light-mode-toggle"
								class="dark-mode-toggle btn btn-outline-light bg-white btn-icon me-1">
								<i class="ti ti-brightness-up"></i>
							</a>
						</div>
				</div>
			</div>

						
			
		<!-- /Header -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
        
            <ul>
                <li><a href="index.html" class="active">Admin Dashboard</a></li>

                {{-- Add Voter Link --}}
                <li>
                    <a href="{{ route('members.create') }}" class="{{ request()->routeIs('members.create') ? 'active' : '' }}">
                        ➕ Add Voter
                    </a>
                </li>

                {{-- Voter List Link --}}
                <li>
                    <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.index') ? 'active' : '' }}">
                        📋 Voter List
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="asset/assets/js/jquery-3.7.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="asset/assets/js/bootstrap.bundle.min.js"></script>

	<!-- Daterangepikcer JS -->
	<script src="asset/assets/js/moment.js"></script>
	<script src="asset/assets/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="asset/assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Feather Icon JS -->
	<script src="asset/assets/js/feather.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="asset/assets/js/jquery.slimscroll.min.js"></script>

	<!-- Chart JS -->
	<script src="asset/assets/plugins/apexchart/apexcharts.min.js"></script>
	<script src="asset/assets/plugins/apexchart/chart-data.js"></script>

	<!-- Owl JS -->
	<script src="asset/assets/plugins/owlcarousel/owl.carousel.min.js"></script>

	<!-- Select2 JS -->
	<script src="asset/assets/plugins/select2/js/select2.min.js"></script>

	<!-- Counter JS -->
	<script src="asset/assets/plugins/countup/jquery.counterup.min.js"></script>
	<script src="asset/assets/plugins/countup/jquery.waypoints.min.js">	</script>

	<!-- Custom JS -->
	<script src="asset/assets/js/script.js"></script>

</body>

</html>