<?php session_start();

	//header("Access-Control-Allow-Origin: *");

	include("include/db.php");
	include("include/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Arkigis</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Kromix"/>
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<link href="vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.css" rel="stylesheet" type="text/css">

		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		<link href="dist/css/custom.css" rel="stylesheet" type="text/css">

		<!-- Treeview -->
		<link href="dist/css/hummingbird-treeview.css" rel="stylesheet">
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
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
			<div class="fixed-sidebar-left">
				<ul class="nav navbar-nav side-nav nicescroll-bar">
					<li class="navigation-header">
						<span><a href="index.php"><img style="margin-left: -15px" src="img/logo.png"></a></span> 
						<i class="zmdi zmdi-more"></i>
					</li>
					<li>
						<a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="fa fa-users mr-20" aria-hidden="true"></i><span class="right-nav-text">Progetti</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
						<?php
						
						
							$s1 = $db->Query("SELECT id, nome_progetto FROM wg_progetti ORDER BY data_progetto ASC");

							if($db->Found($s1))
							{
						?>
						<ul id="maps_dr" class="collapse collapse-level-1">
						<?php
							while($f1 = $db->getObject($s1))
							{
						?>
							<li>
								<a href="google-map.php?prj=<?=$f1->id?>"> <i class="fa fa-street-view" aria-hidden="true"></i> &nbsp;<span><?=dequotes($f1->nome_progetto)?></span></a>
							</li>
						<?php
							}
						?>
							
						</ul>
						<?php
							}
						?>
					</li>
					
					<?php
					if(!empty($_GET['prj']))
					{
						$prj = (int)$_GET['prj'];
					?>
					<li>
						
								
							<div class="row">
								<div class="col-md-12">
									<div class="tab">
										<button class="tablinks active" onclick="tabs(event, 'strati')">Strati</button>
										<button class="tablinks" onclick="tabs(event, 'basi')">Basi</button>
										<!--<button class="tablinks" onclick="tabs(event, 'legenda')">Legenda</button>-->
									</div>
											
									<div id="strati" class="tabcontent active">
										<?php
											$g = $db->Query("SELECT id, nome_layer, attributi FROM wg_progetti_layers WHERE id_madre = '0'");

											if($db->Found($g))
											{
										?>
										<ul id="treeview">
											<?php
												while($fg = $db->getObject($g))
												{
											?>
											<li> <?=(layerHasChild($fg->id)) ? '<i class="fa fa-angle-right"></i>' : ''; ?>
												<label style="width: 95%;">
													<div class="row">
														<div class="col-md-9">
															<?php if(!layerHasChild($fg->id)): ?>
															<input onclick="setLayer(<?=$fg->id?>)" id="xnode-<?=$fg->id?>" data-id="custom-<?=$fg->id?>" type="checkbox" />
															<?php endif; ?>
															<?=dequotes($fg->nome_layer)?>
														</div>
														<div class="col-md-3">
															<span style="background: <?=$colDentro?>; position: relative; top: 2; border: 2px solid <?=$colBordo?>; padding: 3px; float: right; margin-right: 10px;" class="badge mb-10">&nbsp;&nbsp;&nbsp;&nbsp;</span> <span style="margin-left: 10px;"><?=$fliv->nome_layer?></span>
															<img src="img/maps-icon.png" style="width: 20px; height: 20px; vertical-align: middle; float: right; margin-right: 10px;" class="mb-10"> <span style="margin-left: 10px;"><?=$fliv->nome_layer?></span>
														
															
														</div>
													</div>
													
													
													
												</label>
												<?php
													treeviewMapLayers($fg->id, $prj);
												?>
											</li>
											<?php
												}
											?>
										</ul>	 
										<?php
											}
										?>
									</div>
										
									<div id="basi" class="tabcontent">
										<div class="row">
											<div class="col-md-6">
												<!--<a href="#"><div class="map1">&nbsp;</div></a>-->
												<div class="map1" onclick="satellite()" style="cursor: pointer">&nbsp;</div>
											</div>
											<div class="col-md-6">
												<!--<a href="#"><div class="map2">&nbsp;</div></a>-->
												<div class="map2" onclick="roadmap()" style="cursor: pointer">&nbsp;</div>
											</div>
										</div>
									</div>
										
									<!--<div id="legenda" class="tabcontent">
										<div style="border-left: 1px solid #f1f1f1">
											<p class="ml-10 mt-10">
											<?php
												// colori livelli
												$liv = $db->Query("SELECT colore, coloreinterno, nome_layer, tiposhape FROM wg_progetti_layers WHERE id_progetto = '$prj' ORDER BY ordine ASC");

												while($fliv = $db->getObject($liv))
												{
													if($fliv->tiposhape != 1)
													{
														if($fliv->tiposhape == 0 || $fliv->tiposhape == 2)
														{
															$colBordo = $fliv->colore;
															$colDentro = $fliv->coloreinterno;
														}
														elseif($fliv->tiposhape == 3)
														{
															$colBordo = $fliv->colore;
															$colDentro = $fliv->colore;
														}
											?>
												<span style="background: <?=$colDentro?>; position: relative; top: 3px; border: 3px solid <?=$colBordo?>; padding: 10px;" class="badge mb-10">&nbsp;&nbsp;&nbsp;&nbsp;</span> <span style="margin-left: 10px;"><?=$fliv->nome_layer?></span><br>
											<?php
													}
													else
													{
											?>
														<img src="img/maps-icon.png" style="width: 37px; height: 37px; vertical-align: middle" class="mb-10"> <span style="margin-left: 10px;"><?=$fliv->nome_layer?></span><br>
													<?php			
													}
												}
											?>
												
											</p>
										</div>
									</div>-->
								</div>
							</div>
							
						
					</li>
					<?php
					}
					?>
					<li><hr class="light-grey-hr mb-10"/></li>

					<li>
						<a href="javascript:void(0);" id="primo-lay" data-toggle="collapse" data-target="#mappe"><div class="pull-left"><i class="fa fa-print mr-20" aria-hidden="true"></i>						</i><span class="right-nav-text">Stampa</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
						<ul id="mappe" class="collapse collapse-level-1 two-col-list">
								
							<div class="row">
								<div class="col-md-12">
									<div style="padding: 13px;" class="form-wrap">
										<form action="" id="" method="post">
											<div class="form-group">
												<label class="control-label text-left">Formato</label>
												<select class="form-control" name="formato" id="formato">
													<option value="0">A4</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label text-left">Scala</label>
												<select class="form-control" name="scala" id="scala">
													<option value="0">1:500</option>
													<option value="1">1:1000</option>
													<option value="2">1:2000</option>
													<option value="3">1:2500</option>
													<option value="4">1:5000</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label text-left">Dpi</label>
												<select class="form-control" name="dpi" id="dpi">
													<option value="0">150</option>
													<option value="1">300</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label text-left">Rotazione</label>
												<input type="number" class="form-control" name="rotazione" id="rotazione" value="" />
											</div>
											<div class="form-group">
												<label class="control-label text-left">Formato</label>
												<select class="form-control" name="formato" id="formato">
													<option value="0">PDF</option>
													<option value="1">JPG</option>
												</select>
											</div>

											<button type="submit" id="stampa" class="btn btn-xs btn-success btn-block">Crea Stampa</button>
										</form>
									</div>
								</div>
							</div>
							
						</ul>
					</li>
					<li>
						<a href="#" data-toggle="modal" data-target="#guasti"><div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Segnalazione Guasti e Disservizi</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
					</li>
				<?php if(is_logged()): ?>
					<li>
						<a href="index.php?act=out"><div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Logout</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
					</li>
				<?php endif; ?>
				</ul>
			</div>
			<!-- /Left Sidebar Menu -->
			
			<!-- Right Sidebar Menu -->
			<div class="fixed-sidebar-right">
				<ul class="right-sidebar">
					<li>
						<div  class="tab-struct custom-tab-1">
							<ul role="tablist" class="nav nav-tabs" id="right_sidebar_tab">
								<li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="chat_tab_btn" href="#chat_tab">3 Mappe Caricate</a></li>
							</ul>
							<div class="tab-content" id="right_sidebar_content">
								<div  id="chat_tab" class="tab-pane fade active in" role="tabpanel">
									<div class="chat-cmplt-wrap">
										<div class="chat-box-wrap">
											<div id="chat_list_scroll">
												<div class="nicescroll-bar">
													<ul class="chat-list-wrap">
														<li class="chat-list">
															<div class="chat-body">
																<a  href="#">
																	<div class="chat-data">
																		<div class="user-data">
																			<span class="name block capitalize-font">Mappa 1</span>
																			<span class="time block truncate txt-grey">Lorem ipsum dolor sit amet</span>
																		</div>
																		<div class="clearfix"></div>
																	</div>
																</a>
																<a  href="#">
																	<div class="chat-data">
																		<div class="user-data">
																			<span class="name block capitalize-font">Mappa 2</span>
																			<span class="time block truncate txt-grey">Lorem ipsum dolor sit amet</span>
																		</div>
																		<div class="clearfix"></div>
																	</div>
																</a>
																<a  href="#">
																	<div class="chat-data">
																		<div class="user-data">
																			<span class="name block capitalize-font">Mappa 3</span>
																			<span class="time block truncate txt-grey">Lorem ipsum dolor sit amet</span>
																		</div>
																		<div class="clearfix"></div>
																	</div>
																</a>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<!-- /Right Sidebar Menu -->
		<?php
			if(isset($prj))
			{
		?>
			<!-- Right Setting Menu -->
			<div class="setting-panel">
				<?php
					$pinfo = $db->Query("SELECT * FROM wg_progetti WHERE id = '$prj'");

					$finfo = $db->getObject($pinfo);
				?>
				<ul class="right-sidebar nicescroll-bar pa-0">
					<li class="layout-switcher-wrap">
						<ul>
							<li id="infoProgetto">
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-info card-view">
											<div class="panel-heading">
												<div class="pull-left">
													<h6 class="panel-title txt-light">INFORMAZIONI PROGETTO</h6>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="panel-wrapper collapse in">
												<div class="panel-body">
													<div class="panel-body pa-15">
														<div class="tab-struct custom-tab-1 mt-40">
															<ul role="tablist" class="nav nav-tabs" id="myTabs_7">
																<li style="width: 50%;" class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_7" href="#home_7">Informazioni</a></li>
																<li style="width: 50%;" role="presentation"><a data-toggle="tab" id="profile_tab_7" role="tab" href="#profile_7" aria-expanded="false">Foto</a></li>
															</ul>
															<div class="tab-content" id="myTabContent_7">
																<div id="home_7" class="tab-pane fade active in" role="tabpanel">
																	<div class="row">
																		<div class="col-md-6">
																			<p style="color: #2b2b2b"><span style="font-weight: 500;">Nome Progetto</span></p>
																			<p style="color: #2b2b2b"><span style="font-weight: 500;">Data Progetto</span></p>
																			<p style="color: #2b2b2b"><span style="font-weight: 500;">Descrizione</span></p>	
																		</div>
																		<div class="col-md-6">
																			<p style="color: #2b2b2b"><?=dequotes($finfo->nome_progetto)?></p>
																			<p style="color: #2b2b2b"><?=date("d/m/Y", strtotime($finfo->data_progetto));?></p>
																			<p style="color: #2b2b2b"><?=dequotes($finfo->descrizione)?></p>
																		</div>
																	</div>
																</div>
																<div id="profile_7" class="tab-pane fade" role="tabpanel">
																	<?php
																		// foto
																		$ffot = $db->Query("SELECT * FROM wg_progetti_foto WHERE id_progetto = '$prj' ORDER BY ordine ASC");

																		while($fot = $db->getObject($ffot))
																		{
																	?>
																	<div class="col-md-3">
																		<a data-fancybox="gallery" href="dati/foto-progetti/<?=$fot->foto?>" data-fancybox data-caption="<?=dequotes($fot->nome_foto)?>"><img style="width: 100%; height: 70px;" src="dati/foto-progetti/<?=$fot->foto?>"></a>
																	</div>
																	<?php
																		}
																	?>
																	
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li id="infoLayer" class="hidden">
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-info card-view">
											<div class="panel-heading">
												<div class="pull-left">
													<h6 class="panel-title txt-light">Informazioni</h6>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="panel-wrapper collapse in">
												<div class="panel-body">
													<div class="panel-body pa-15 contenutoLayer">
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="row">
									<div class="col-md-12 text-center">
										<!-- va inserito setting_panel_btn nel button se lo metto però appare giu -->
										<button type="button" class="btn btn-sm btn-info setting-panel-btn shadow-2dp" onclick="toggleRight();">Chiudi</button>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				
			</div>
		
			<!-- /Right Setting Menu -->
		<?php
			}
		?>
			<!-- Right Sidebar Backdrop -->
			<div class="right-sidebar-backdrop"></div>
			<!-- /Right Sidebar Backdrop -->
				
			<!-- Main Content -->
			<div class="page-wrapper">
				<div class="container-fluid">

					<!-- Row -->
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<button title="Ingrandisci Riquadro" class="btn left-label btn-info btn-lable-wrap all-btn" onclick="zoomIn()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px;" class="fa fa-search-plus"> </i></span>
										</button>
										<button title="Diminuisci Riquadro" class="btn left-label btn-info btn-lable-wrap all-btn" onclick="zoomOut()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px;" class="fa fa-search-minus"> </i></span>
										</button>
									<?php if(isset($prj)): ?>
										<button title="Dati Progetto"  class="btn left-label btn-info btn-lable-wrap all-btn" onclick="toggleRight()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 3px;" class="fa fa-info-circle"> </i></span>
										</button>
									<?php endif; ?>
										<button title="Misura Area" id="toggleArea" class="btn left-label btn-info btn-lable-wrap all-btn" onclick="mostraArea()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px;" class="ti-ruler-alt-2"> </i></span>
										</button>
										<button title="Misura Distanza" id="toggleRighello" class="btn left-label btn-info btn-lable-wrap all-btn" onclick="righello()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px;" class="fa fa-sort-numeric-asc"> </i></span>
										</button>
										<button data-toggle="modal" data-target="#screen" title="Screenshot" id="screenshot" class="btn left-label btn-info btn-lable-wrap all-btn" onclick="screenShot()">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px; font-size: 15px;" class="fa fa-camera"> </i></span>
										</button>
										<button data-toggle="modal" data-target="#guasti" title="Segnalazione guasti e Disservizi" class="btn left-label btn-info btn-lable-wrap all-btn">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 2px; font-size: 15px;" class="fa fa-flag"> </i></span>
										</button>
									</div>
									<div class="pull-right">
										<h2><span class="badge badge-info" id="infoMappa"></span></h2>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body mapContainer">
										<div id="map" style="height:750px; width: 100%"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-2">
										<div class="form-group mt-30 mb-30">
											<select class="form-control" id="scalaMap" onchange="cambiaZoom(this.options[this.selectedIndex].value)">
												<option value="0">Full MAP</option>
												<?php
													for($i=1;$i<23;$i++)
													{
												?>
												<option value="<?=$i?>">Zoom <?=$i?> | Scala 1:<?=getScala($i)?></option>
												<?php
													}
												?>
												
											</select>
										</div>
									</div>
									
									<div class="col-md-4">
										<button style="padding: 10px;" class="btn left-label btn-info btn-lable-wrap mt-30"><i class="fa fa-arrows-h"></i> &nbsp;&nbsp;<span id="currentLat"></span></button>
										<button style="padding: 10px;" class="btn left-label btn-info btn-lable-wrap mt-30"><i class="fa fa-arrows-v"></i> &nbsp;&nbsp;<span id="currentLng"></span></button>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->
					
				</div>
				
				<!-- Footer -->
				<footer class="footer container-fluid pl-30 pr-30">
					<div class="row">
						<div class="col-sm-12">
							<p>2019 &copy; Consorzio di Bonifica Ionio Crotonese</p>
						</div>
					</div>
				</footer>
				<!-- /Footer -->
			
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->

		<!-- Guasti e Disservizi -->
		<div class="modal fade" id="guasti" tabindex="-1" role="dialog" aria-labelledby="guasti">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color: #fff;" aria-hidden="true">&times;</span></button>
						<h5 class="modal-title" id="guasti">Guasti e Disservizi</h5>
						<small style="padding-left: 0px;">Compila il form per segnalare un guasto.</small>
					</div>
					<div class="modal-body">
						<form action="" id="" method="post">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="cx" class="control-label mb-5">Coordinata X</label>
										<input type="text" class="form-control" name="cx" id="cx" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="cy" class="control-label mb-5">Coordinata Y</label>
										<input type="text" class="form-control" name="cy" id="cy" value="" />
									</div>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="cognome" class="control-label mb-5">Cognome</label>
										<input type="text" class="form-control" name="cognome" id="cognome" value="" />	
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="nome" class="control-label mb-5">Nome</label>
										<input type="text" class="form-control" name="nome" id="cognome" value="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="data" class="control-label mb-5">Data</label>
										<input type="date" class="form-control" name="data" id="data" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #fff;" for="tipologia" class="control-label mb-5">Tipologia Disservizio</label>
										<select class="form-control" name="tipologia" id="tipologia">
											<option value="0">Canale</option>
											<option value="1">Fosso</option>
											<option value="2">Rete Irrigua</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label style="color: #fff;" for="oggetto" class="control-label mb-5">Oggetto</label>
										<input type="text" class="form-control" name="oggetto" id="oggetto" value="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label style="color: #fff;" for="messaggio" class="control-label mb-5">Messaggio</label>
										<textarea rows="3" class="form-control" name="messaggio" id="messaggio"></textarea>
									</div>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label style="color: #fff;" for="foto1" class="control-label mb-5">Allega Foto</label>
										<input type="file" class="form-control" name="foto1" id="foto1" value="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="file" class="form-control" name="foto2" id="foto2" value="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="file" class="form-control" name="foto3" id="foto3" value="" />
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-xs pull-left" data-dismiss="modal">Chiudi</button>
						<button type="button" class="btn btn-success btn-xs">Invia Segnalazione</button>
					</div>
				</div>
			</div>
		</div>
		<div class="wait-background"><span>ATTENDERE PREGO ...</span></div>
		
		<!-- Screenshot -->
		<div class="modal fade" id="screen" tabindex="-1" role="dialog" aria-labelledby="screen">
			<div style="width: 1000px;" class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color: #fff;" aria-hidden="true">&times;</span></button>
						<h5 class="modal-title" id="screen">Screenshot Mappa</h5>
						<small style="padding-left: 0px;">Compila il form per segnalare un guasto.</small>
					</div>
					<div class="modal-body">
						<div style="width: 100%; max-width: 100%;" id="imgMap"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-xs pull-left" data-dismiss="modal">Chiudi</button>
						<button type="button" id="downloadScreenshot" onclick="downloadScreenshot()" class="btn btn-success btn-xs">Scarica Screenshot</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

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

		<script type="text/javascript" src="vendors/html2canvas/html2canvas.min.js"></script>
		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7jca5iL-nLyladEfsgi82vLv1Sb3VJlU&libraries=geometry"></script>
		<script type="text/javascript" src="dist/js/maps-api.js"></script>
		
		<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

		
		
		<script type="text/javascript">
			$(document).ready(function()
			{
				$('#second-lay').hide();

				$( "#mostra-second-lay" ).on("click", function() {
				  $( "#second-lay" ).slideToggle( "slow", function() {
					// Animation complete.
				  });
				  //$('#primo-lay').hide();
				});	

				

				map = new google.maps.Map(document.getElementById('map'), {
				  center: {lat: 39.081563, lng: 17.135190},
				  zoom: 16,
				  disableDefaultUI: true,
				  zoomControl: false,
				  panControl: false,
				  fullscreenControl: true,
				  scaleControl: false,
				  streetViewControl: true,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				});

				$("#treeview").hummingbird();

				

			});

			$(function()
			{
				setTimeout(
					function() 
					{
						map.setOptions({streetViewControl: true});

						google.maps.event.addListener(map, 'mousemove', function (event) {
							displayCoordinates(event.latLng);               
						});

						$('#scalaMap').val(map.getZoom());
					}
				, 1000);
				
			});

			function setLayer(id)
			{
				wait();
				var idLayers = '';

				var centro = map.getCenter();
				var zoom = map.getZoom();
				var type = map.getMapTypeId();

				$('ul#treeview input:checked').each(function(indice, elemento)
				{
					idLayers += (elemento.id).replace("xnode-", "") + ',';
				});

				$.post("ajax/mapLayer.php", "idLayers=" + idLayers + "&center=" + encodeURIComponent(centro) + "&z=" + zoom + "&type=" + type, function(dati)
				{
					//eval(dati);
					
					$("div.mapContainer").html(dati);
					$("div.mapContainer").find("script").each(function(){
						
						eval($(this).text());
					});
					unwait();
				});
			}

			function toggleRight()
			{
				
				//$(".wrapper").toggleClass('open-setting-panel').removeClass('open-right-sidebar');
				if($('.setting-panel').hasClass("aperto"))
				{
					$('#infoLayer').removeClass("hidden").addClass("hidden");
					$('#infoProgetto').removeClass("hidden").addClass("hidden");
					$(".setting-panel").css("margin-right", "-660px").removeClass("aperto");
				}
				else
				{
					$('#infoLayer').removeClass("hidden").addClass("hidden");
					$('#infoProgetto').removeClass("hidden");
					$(".setting-panel").css("margin-right", "0px").addClass("aperto");
				}
				
				
			}
		</script>
		
	</body>
</html>