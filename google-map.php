<?php
	include 'include/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Arkigis</title>
		<meta name="description" content="Hound is a Dashboard & Admin Site Responsive Template by hencework." />
		<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Hound Admin, Houndadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
		<meta name="author" content="hencework"/>
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<link href="vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.css" rel="stylesheet" type="text/css">

		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		<link href="dist/css/custom.css" rel="stylesheet" type="text/css">

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
			<div class="fixed-sidebar-left">
				<ul class="nav navbar-nav side-nav nicescroll-bar">
					<li class="navigation-header">
						<span>Metadati</span> 
						<i class="zmdi zmdi-more"></i>
					</li>
					<li>
						<a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="fa fa-users mr-20" aria-hidden="true"></i><span class="right-nav-text">Servizi al Cittadino</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
						<ul id="maps_dr" class="collapse collapse-level-1">
							<li>
								<a href="#" data-toggle="collapse" data-target="#pages_dr"> <i class="fa fa-street-view" aria-hidden="true"></i> &nbsp;<span>Ricerca Particella</span></a>
							</li>
							<li>
								<a href="#" id="mostra-second-lay" data-toggle="collapse" data-target="#pages_dr2"><i class="fa fa-map-pin" aria-hidden="true"></i> &nbsp;Piani di Classifica</a>
							</li>
							<li>
								<a href="#" data-toggle="collapse" data-target="#pages_dr3"><i class="fa fa-cogs" aria-hidden="true"></i> &nbsp;Lavori in Corso</a>
							</li>
						</ul>
					</li>
					
					<li>
						<a href="javascript:void(0);" id="primo-lay" data-toggle="collapse" data-target="#pages_dr"><div class="pull-left"><i class="fa fa-map mr-20" aria-hidden="true"></i><span class="right-nav-text">Mappe</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
						<ul id="pages_dr" class="collapse collapse-level-1 two-col-list">
								
							<div class="row">
								<div class="col-md-12">
									<div class="tab">
										<button class="tablinks" onclick="tabs(event, 'strati')">Strati</button>
										<button class="tablinks" onclick="tabs(event, 'basi')">Basi</button>
										<button class="tablinks" onclick="tabs(event, 'legenda')">Legenda</button>
									</div>
											
									<div id="strati" class="tabcontent">
										<blockquote>Tasto destro sui singoli layer per accedere alle funzionalità aggiuntive</blockquote>											  	
										<ul id="treeview">
											<li> <i class="fa fa-angle-right"></i>
												<label>
												<input id="xnode-0" data-id="custom-0" type="checkbox" />
												Catasto </label>
												<ul>
												<li> <i class="fa fa-angle-right"></i>
													<label>
													<input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" />
													Comune </label>
													<ul>
													<li>
														<label>
														<input class="hummingbirdNoParent" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox" />
														Foglio 20 </label>
													</li>
													<li>
														<label>
														<input class="hummingbirdNoParent" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" />
														Particcella 1 </label>
													</li>
													</ul>
												</li>
												<li> <i class="fa fa-angle-right"></i>
													<label>
													<input  id="xnode-0-2" data-id="custom-0-2" type="checkbox" />
													Irriguo </label>
													<ul>
													<li>
														<label>
														<input class="hummingbirdNoParent" id="xnode-0-2-1" data-id="custom-0-2-1" type="checkbox" />
														Rete di Colo </label>
													</li>
													<li>
														<label>
														<input class="hummingbirdNoParent" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" />
														Bocchette </label>
													</li>
													</ul>
												</li>
												</ul>
											</li>
										</ul>	  
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
										
									<div id="legenda" class="tabcontent">
										<h3>Legenda</h3>
										<p></p>
									</div>
								</div>
							</div>
							
						</ul>
					</li>

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
			
			<!-- Right Setting Menu -->
			<div class="setting-panel">
				<ul class="right-sidebar nicescroll-bar pa-0">
					<li class="layout-switcher-wrap">
						<ul>
							<li>
								<span class="layout-title">Risultati</span>

								<div class="row">
									<div class="col-md-12">
										<div style="margin: 10px 20px 0px 0px;" class="panel panel-info card-view">
											<div class="refresh-container">
												<div class="la-anim-1"></div>
											</div>
											<div class="panel-heading ">
												<div class="pull-left">
													<h6 class="panel-title txt-dark">Pratiche</h6>
												</div>
												<div class="pull-right">
													<a class="pull-left inline-block mr-15" data-toggle="collapse" href="#collapse_1" aria-expanded="true">
														<i style="color: #fff;" class="zmdi zmdi-chevron-down"></i>
														<i style="color: #fff;" class="zmdi zmdi-chevron-up"></i>
													</a>
													<div class="pull-left inline-block dropdown mr-15">
														<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i style="color: #fff;" class="zmdi zmdi-more-vert"></i></a>
														<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
															<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
															<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
															<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
														</ul>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<div id="collapse_1" class="panel-wrapper collapse in" aria-expanded="true">
												<div class="panel-body">
													<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="heading_10">
																<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_10" aria-expanded="false" class="collapsed"><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i style="color: #fff;" class="ti-plus"></i></span><span class="minus-ac"><i style="color: #fff;" class="ti-minus"></i></span></div>Pratica n. 001/2016</a> 
															</div>
															<div id="collapse_10" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">
																<div style="background: #4E6877;" class="panel-body pa-15">
																	<div class="tab-struct custom-tab-1 mt-40">
																		<ul role="tablist" class="nav nav-tabs" id="myTabs_7">
																			<li style="width: 50%;" class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_7" href="#home_7">Istanza</a></li>
																			<li style="width: 50%;" role="presentation"><a data-toggle="tab" id="profile_tab_7" role="tab" href="#profile_7" aria-expanded="false">Anagrafica</a></li>
																		</ul>
																		<div class="tab-content" id="myTabContent_7">
																			<div id="home_7" class="tab-pane fade active in" role="tabpanel">
																				<div class="row">
																					<div class="col-md-6">
																						<p><strong>Numero Pratica</strong></p>
																						<p><strong>Anno</strong></p>
																						<p><strong>Faldone</strong></p>
																						<p><strong>Operatore</strong></p>
																						<p><strong>Responsabile del Procedimento</strong></p>
																						<p><strong>Stato della pratica</strong></p>	
																					</div>
																					<div class="col-md-6">
																						<p>2016/037</p>
																						<p>2016</p>
																						<p>20/2017</p>
																						<p>Antonio Caprino</p>
																						<p>Fabio Cappellieri</p>
																						<p>Conclusa</p>
																					</div>
																				</div>
																			</div>
																			<div id="profile_7" class="tab-pane fade" role="tabpanel">
																				<div class="row">
																					<div class="col-md-6">
																						<p><strong>Cognome</strong></p>
																						<p><strong>Nome</strong></p>
																						<p><strong>Nascita</strong></p>
																						<p><strong>Residenza</strong></p>
																					</div>
																					<div class="col-md-6">
																						<p>Caprino</p>
																						<p>Antonio</p>
																						<p>11/02/1993</p>
																						<p>Crotone</p>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="heading_11">
																<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_11" aria-expanded="false"><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i style="color: #fff;" class="ti-plus"></i></span><span class="minus-ac"><i style="color: #fff;" class="ti-minus"></i></span></div>Pratica n. 001/2016</a>
															</div>
															<div id="collapse_11" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
																<div style="background: #4E6877;" class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, </div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="heading_12">
																<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_12" aria-expanded="false"><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i style="color: #fff;" class="ti-plus"></i></span><span class="minus-ac"><i style="color: #fff;" class="ti-minus"></i></span></div>Pratica n. 001/2016</a>
															</div>
															<div id="collapse_12" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
																<div style="background: #4E6877;" class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, inable VHS. </div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</li>
						</ul>
					</li>
				</ul>
				
			</div>
			<button id="setting_panel_btn" class="btn btn-info btn-circle setting-panel-btn shadow-2dp"><i class="zmdi zmdi-settings"></i></button>
			<!-- /Right Setting Menu -->
			
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
										<button title="Dati Progetto" class="btn left-label btn-info btn-lable-wrap all-btn">
											<span class="btn-label"><i style="color: #FFF; position: relative; top: 3px;" class="fa fa-info-circle"> </i></span>
										</button>
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
									<div class="panel-body">
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
		
		<!-- Screenshot -->
		<div class="modal fade" id="screen" tabindex="-1" role="dialog" aria-labelledby="screen">
			<div style="width: 1000px;" class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color: #fff;" aria-hidden="true">&times;</span></button>
						<h5 class="modal-title" id="screen">Screenshot Mappa</h5>
						<small style="padding-left: 0px;">Compila il form per segnalare un guasto.</small>
					</div>
					<div class="modal-body">
						<div style="width: 100%;" id="imgMap"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-xs pull-left" data-dismiss="modal">Chiudi</button>
						<button type="button" class="btn btn-success btn-xs">Scarica Screenshot</button>
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

		<!-- Google Map JavaScript -->
		

		<!-- Tabs -->
		<script src="dist/js/custom.js"></script>

		<!-- Treeview -->
		<script src="dist/js/hummingbird-treeview.js"></script>

		<script type="text/javascript" src="vendors/html2canvas/html2canvas.min.js"></script>
		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7jca5iL-nLyladEfsgi82vLv1Sb3VJlU&libraries=geometry"></script>
		<script type="text/javascript" src="dist/js/maps-api.js"></script>
		
		
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
		</script>
		
	</body>
</html>