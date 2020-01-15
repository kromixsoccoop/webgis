<?php session_start();
	require_once("include/db.php");
	require_once("include/functions.php");

	/*if(!is_logged())
	{
		phpRedir("login.php");
	}*/

	/*if(!isLevel('admin'))
	{
		phpRedir("index.php");
	}*/

	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Arkigis</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content=""/>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<!-- Bootstrap Dropify CSS -->
		<link href="vendors/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
		
		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		
		<link href="vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.css" rel="stylesheet" type="text/css">
		
		<!-- Treeview -->
		<link href="dist/css/hummingbird-treeview.css" rel="stylesheet">
	</head>
	
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper theme-4-active pimary-color-red">
		
			<!-- Top Menu Items -->
			<?php include 'include/header.php'; ?>
			<!-- /Top Menu Items -->
			
			<!-- Left Sidebar Menu -->
			<?php include 'include/menu.php'; ?>
			<!-- /Left Sidebar Menu -->				
					<!-- Main Content -->
					<div class="page-wrapper">
						<div class="container-fluid">
							
							<!-- Title -->
							<div class="row heading-bg">
								<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
									<h5 class="txt-dark">Nuovo Utente</h5>
								</div>
							
								<!-- Breadcrumb -->
								<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
									<ol class="breadcrumb">
										<li><a href="index.html">Dashboard</a></li>
										<li><a href="#"><span>Lista Utenti</span></a></li>
										<li class="active"><span>Nuovo Utente</span></li>
									</ol>
								</div>
								<!-- /Breadcrumb -->
							
							</div>
							<!-- /Title -->
							
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default card-view">
										<div class="panel-wrapper collapse in">
											<div class="panel-body">
												<form action="" id="" method="get" enctype="multipart/form-data">
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="nome">Nome <sup>*</sup></label>
																<input type="text" class="form-control" name="nome" id="nome" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="data_progetto">Cognome <sup>*</sup></label>
																<input type="text" class="form-control" name="cognome" id="cognome" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="email">Email <sup>*</sup></label>
																<input type="text" class="form-control" name="email" id="email" value="">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="user">Nome Utente <sup>*</sup></label>
																<input type="text" class="form-control" name="user" id="user" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="pass">Password <sup>*</sup></label>
																<input type="password" class="form-control" name="pass" id="pass" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="rip_pass">Ripeti Password <sup>*</sup></label>
																<input type="password" class="form-control" name="rip_pass" id="rip_pass" value="">
															</div>
														</div>
													</div>
													<hr />
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="livello">Livello <sup>*</sup></label>
																<input type="text" class="form-control" name="livello" id="livello" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="attivo">Utente Attivo <sup>*</sup></label>
																<select class="form-control" name="attivo" id="attivo">
																	<option value="0">No</option>
																	<option value="1">Si</option>
																</select>
															</div>
														</div>
													</div>													
													<div class="row">
														<div class="col-md-12">
															<div class="pull-left">
																<a href="utenti.php" class="btn btn-sm btn-danger">Indietro</a>
															</div>
															<div class="pull-right">
																<a href="#" class="btn btn-sm btn-success">Salva</a>
															</div>
														</div>
													</div>
													
												</form>
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
			<?php
				if($_GET['act'] == 'addLayer')
				{
			?>
					<!-- Main Content -->
					<div class="page-wrapper">
						<div class="container-fluid">
							
							<!-- Title -->
							<div class="row heading-bg">
								<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
									<h5 class="txt-dark">Nuovo Layer</h5>
								</div>
							
								<!-- Breadcrumb -->
								<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
									<ol class="breadcrumb">
										<li><a href="index.html">Dashboard</a></li>
										<li><a href="#"><span>Progetti</span></a></li>
										<li class="active"><span>Nuovo Layer</span></li>
									</ol>
								</div>
								<!-- /Breadcrumb -->
							
							</div>
							<!-- /Title -->
							
							<div class="row">
								<div class="col-md-4">
									<div style="padding-bottom: 15px;" class="panel panel-default card-view">
										<div class="panel-wrapper collapse in">
										
											<h5 class="txt-dark">Layer Caricati</h5>
											<hr />
											<ul id="treeview">
												<li> 
													<i class="fa fa-angle-right txt-dark"></i>
													<label style="color: #234151; width: 97%"><input id="xnode-0" data-id="custom-0" type="checkbox" /> Catasto <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
													<ul>
														<li> 
															<i class="fa fa-angle-right txt-dark"></i>
															<label style="color: #234151; width: 97%"><input id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> Comune <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
															<ul>
																<li>
																	<label style="color: #234151; width: 100%"><input class="hummingbirdNoParent" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox" /> Foglio 20 <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
																</li>
																<li>
																	<label style="color: #234151; width: 100%"><input class="hummingbirdNoParent" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> Particcella 1 <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
																</li>
															</ul>
														</li>
														<li> 
															<i class="fa fa-angle-right txt-dark"></i>
															<label style="color: #234151; width: 97%"><input id="xnode-0-2" data-id="custom-0-2" type="checkbox" />Irriguo <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
															<ul>
																<li>
																	<label style="color: #234151; width: 100%"><input class="hummingbirdNoParent" id="xnode-0-2-1" data-id="custom-0-2-1" type="checkbox" /> Rete di Colo <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
																</li>
																<li>
																	<label style="color: #234151; width: 100%"><input class="hummingbirdNoParent" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" /> Bocchette <a href="#" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a></label>
																</li>
															</ul>
														</li>
													</ul>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="panel panel-default card-view">
										<div class="panel-wrapper collapse in">
											<div class="panel-body">
												<form action="" id="" method="post" enctype="multipart/form-data">
													<div class="row">
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="nome">Nome Layer <sup>*</sup></label>
																<input type="text" class="form-control" name="nome" id="nome" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="layer">Layer <sup>*</sup></label>
																<select class="form-control" name="layer" id="layer">
																	<option value="0"></option>
																	<option value="1">Root</option>
																	<option value="2">Catasto</option>
																	<option value="3">Irriguo</option>
																</select>
															</div>
														</div>
													</div>
													<br />
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label style="font-weight: 500;" class="control-label mb-10 text-left">Carica file .kml</label>
																<input type="file" id="qgis" name="qgis" class="form-control dropify" data-max-file-size="2M" />
															</div>
														</div>
													</div>
													<hr />
													<div class="row">
														<div class="col-md-12">
															<div class="pull-left">
																<a href="progetti.php" class="btn btn-sm btn-danger">Indietro</a>
															</div>
															<div class="pull-right">
																<a href="#" class="btn btn-sm btn-success">Salva</a>
															</div>
														</div>
													</div>
													
												</form>
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
			<?php
				}
			?>
			
		
		</div>
		<!-- /#wrapper -->
		
		<!-- jQuery -->
		<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
		
		<!-- Bootstrap Daterangepicker JavaScript -->
		<script src="vendors/bower_components/dropify/dist/js/dropify.min.js"></script>
		
		<!-- Form Flie Upload Data JavaScript -->
		<script src="dist/js/form-file-upload-data.js"></script>
		
		<!-- Treeview JavaScript -->
		<script src="vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.js"></script>

		<!-- Treeview Init JavaScript -->
		<script src="dist/js/treeview-data.js"></script>
		
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
		
		<!-- Tabs -->
		<script src="dist/js/custom.js"></script>
		
		<!-- Treeview -->
		<script src="dist/js/hummingbird-treeview.js"></script>
	</body>
</html>
