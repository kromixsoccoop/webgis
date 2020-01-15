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
		<meta name="keywords" content="a" />
		<meta name="author" content=""/>
		
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
							<h5 class="txt-dark">Lista Utenti</h5>
						</div>
					
						<!-- Breadcrumb -->
						<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
							<ol class="breadcrumb">
								<li><a href="index.html">Dashboard</a></li>
								<li class="active"><span>Lista Utenti</span></li>
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
										<h6 class="panel-title txt-dark">Cerca un Utente</h6>
									</div>
									<div class="pull-right">
										<a href="addUtente.php" class="btn btn-sm btn-info">Nuovo Utente</a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<form action="" id="" method="get">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label mb-10 text-left">Nome</label>
														<input type="text" class="form-control" name="nome" id="nome" value="">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label mb-10 text-left">Cognome</label>
														<input type="text" class="form-control" name="cognome" id="cognome" value="">
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
					<?php

						require_once("include/paginazione.inc.php");

						$ricerca = isset($_GET['s']);

						if($ricerca)
						{
							$q = "";
						}
						else
						{
							$q = "SELECT * FROM wg_progetti ORDER BY id DESC";
						}

						$pag = new Paginazione($q, 25, "p");

					?>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Lista Utenti</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped mb-0">
												<thead class="bg-dark">
													<tr>
														<th>Nome</th>
														<th>Cognome</th>
														<th>Nome Utente</th>
														<th>Livello</th>
														<th>Data Creazione</th>
														<th class="text-nowrap"></th>
												</tr>
												</thead>
												<tbody>
												<?php
													if($record = $pag->Show())
													{
														foreach($record as $riga)
														{
												?>
													<tr class="txt-dark">
														<td><?=dequotes($riga['nome'])?></td>
														<td><?=dequotes($riga['cognome'])?></td>
														<td><?=dequotes($riga['utente'])?></td>
														<td><?=dequotes($riga['livello'])?></td>
														<td><?=dequotes($riga['inserimento'])?></td>
														<td><?=date("d/m/Y", strtotime($riga['data_progetto']))?></td>
														<td class="text-nowrap">
															<a href="#" class="mr-25 text-warning" data-toggle="tooltip" data-original-title="Modifica Utente"><i class="fa fa-pencil m-r-10"></i></a> 
															<a href="#" class="text-danger" data-toggle="tooltip" data-original-title="Elimina Utente"><i class="fa fa-close"></i> </a> 
														</td>
													</tr>
												<?php
														}
													}
													else
													{
												?>
													<tr class="txt-dark">
														<td colspan="7">Nessun progetto trovato ...</td>
													</tr>
												<?php
													}
												?>
													
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
