<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Hound I Fast build Admin dashboard for any platform</title>
		<meta name="description" content="Hound is a Dashboard & Admin Site Responsive Template by hencework." />
		<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Hound Admin, Houndadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
		<meta name="author" content="hencework"/>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		
		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper theme-4-active pimary-color-red">
		
			<!-- Top Menu Items -->
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="mobile-only-brand pull-left">
					<div class="nav-header pull-left">
						<div class="logo-wrap">
							<a href="index.html">
								<span class="brand-text">Arkigis</span>
							</a>
						</div>
					</div>	
					<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
					<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
					<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
					<form id="search_form" role="search" class="top-nav-search collapse pull-left">
						<div class="input-group">
							<input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
							<span class="input-group-btn">
							<button type="button" class="btn  btn-default" data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
							</span>
						</div>
					</form>
				</div>
				<div id="mobile_only_nav" class="mobile-only-nav pull-right">
					<ul class="nav navbar-right top-nav pull-right">
						<li>
							<a id="open_right_sidebar" href="#">Cambia Mappa</a>
						</li>
						<li class="dropdown app-drp">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-settings top-nav-icon"></i></a>							
						</li>
					</ul>
				</div>	
			</nav>   
			<!-- /Top Menu Items -->
			
			<!-- Left Sidebar Menu -->
			<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
				<li class="navigation-header">
					<span>Menu</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="widgets.html"><div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"><span class="label label-warning">8</span></div><div class="clearfix"></div></a>
				</li>
				<li>
					<a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Gruppi Cartografici</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="dashboard_dr" class="collapse collapse-level-1">
						<li>
							<a class="active-page" href="index.html">Lista Gruppi</a>
						</li>
					</ul>
				</li>

				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>ACL</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_dr"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">Utenti</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_dr" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="panels-wells.html">Lista Utenti</a>
						</li>
					</ul>
				</li>
				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>LAW</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#pages_dr"><div class="pull-left"><i class="zmdi zmdi-google-pages mr-20"></i><span class="right-nav-text">Normative</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="pages_dr" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="blank.html">Lista Normative</a>
						</li>
					</ul>
				</li>
				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>CDU</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#dropdown_dr_lv1"><div class="pull-left"><i class="zmdi zmdi-filter-list mr-20"></i><span class="right-nav-text">Profili CDU</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="dropdown_dr_lv1" class="collapse collapse-level-1">
						<li>
							<a href="#">Aggiungi Profilo</a>
						</li>
						<li>
							<a href="#">Lista Profili</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
			<!-- /Left Sidebar Menu -->				
				
			<!-- Main Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					
					<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
							<h5 class="txt-dark">form layout</h5>
						</div>
					
						<!-- Breadcrumb -->
						<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
							<ol class="breadcrumb">
								<li><a href="index.html">Dashboard</a></li>
								<li><a href="#"><span>form</span></a></li>
								<li class="active"><span>form-layout</span></li>
							</ol>
						</div>
						<!-- /Breadcrumb -->
					
					</div>
					<!-- /Title -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Cerca un Progetto</h6>
									</div>
									<div class="pull-right">
										<a href="#" class="btn btn-sm btn-info">Nuovo Progetto</a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<form action="" id="" method="get">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label mb-10 text-left">Nome Progetto</label>
														<input type="text" class="form-control" name="" id="" value="">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label mb-10 text-left">Data Progetto</label>
														<input type="date" class="form-control" name="data" id="" value="">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<button style="padding: 11px;" type="button" class="btn btn-sm btn-block mt-30 btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">Cerca</span></button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Cerca un Progetto</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped mb-0">
												<thead class="bg-dark">
													<tr>
														<th>Progetto</th>
														<th>Data Progetto</th>
														<th class="text-nowrap"></th>
												</tr>
												</thead>
												<tbody>
													<tr class="txt-dark">
														<td>Progetto 1</td>
														<td>09/12/2019</td>
														<td class="text-nowrap">
															<a href="#" style="color: #234151;" class="mr-25 text-dark" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil text-dark m-r-10"></i></a> 
															<a href="#" style="color: #234151" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-close text-dark"></i> </a> 
														</td>
													</tr>
													<tr class="txt-dark">
														<td>Progetto 1</td>
														<td>09/12/2019</td>
														<td class="text-nowrap">
															<a href="#" style="color: #234151;" class="mr-25 text-dark" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil text-dark m-r-10"></i></a> 
															<a href="#" style="color: #234151" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-close text-dark"></i> </a> 
														</td>
													</tr>
													<tr class="txt-dark">
														<td>Progetto 1</td>
														<td>09/12/2019</td>
														<td class="text-nowrap">
															<a href="#" style="color: #234151;" class="mr-25 text-dark" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil text-dark m-r-10"></i></a> 
															<a href="#" style="color: #234151" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-close text-dark"></i> </a> 
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				</div>
				
				<!-- Footer -->
				<footer class="footer container-fluid pl-30 pr-30">
					<div class="row">
						<div class="col-sm-12">
							<p>2020 &copy; Consorzio di Bonifica Ionio Crotonese</p>
						</div>
					</div>
				</footer>
				<!-- /Footer -->
			
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
	
		<!-- Fancy Dropdown JS -->
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
		<!-- Owl JavaScript -->
		<script src="vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
		<!-- Switchery JavaScript -->
		<script src="vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
	</body>
</html>
