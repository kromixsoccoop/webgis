<?php session_start();
	require_once("include/db.php");
	require_once("include/functions.php");

	include 'include/upload.inc.php';


	if(!is_logged())
	{
		phpRedir("login.php");
	}

	if(!isLevel('admin'))
	{
		phpRedir("index.php");
	}

	
	if(isset($_POST['sendProgetto']))
	{


		$nome_progetto = aquotes($_POST['nome_progetto']);
		$data_progetto = aquotes($_POST['data_progetto']);
		$descrizione = aquotes($_POST['descrizione']);

		$nfoto = (int)$_POST['nfoto'];
		$visibilita = (int)$_POST['visibilita'];
		
		if(!empty($nome_progetto) && $data_progetto != '0000-00-00' && !empty($descrizione))
		{
			$s1 = $db->Query("INSERT INTO wg_progetti (nome_progetto, data_progetto, descrizione, visibilita) VALUES ('$nome_progetto', '$data_progetto', '$descrizione', '$visibilita')");

			$id_progetto = $db->lastID();



			for($i=1; $i<=$nfoto; $i++)
			{
				$titolo_foto = aquotes($_POST['titolo_foto'. $i]);
				$nome_foto = aquotes($_FILES['foto'. $i]['name']);
				$ordine_foto = aquotes($_POST['ordine_foto'. $i]);

				if(!empty($nome_foto))
				{
					$foto = new Uploader('foto'. $i);
					$foto->set_opt('controllo estensione', true);
					$foto->set_opt('estensioni consentite', 'jpg, png, jpeg, JPG, JPEG, PNG');
					$foto->set_opt('sovrascrittura', false);

					if(!$foto->upload('dati/foto-progetti/'))
					{
						$_SESSION['warning'] = "Progetto modificato ma alcune foto presentano degli errori: $foto->getError()";
					}
					else
					{
						$s2 = $db->Query("INSERT INTO wg_progetti_foto (id_progetto, nome_foto, foto, ordine) VALUES ('$id_progetto', '$titolo_foto', '".$foto->getName()."', '$ordine_foto')");
					}
				}
			}

			$_SESSION['success'] = "Progetto modificato con successo!";
			phpRedir("progetti.php");
		}
		else
		{
			$_SESSION['error'] = "Compilare tutti i campi obbligatori";
		}
	}

	if(isset($_POST['modProgetto']))
	{


		$nome_progetto = aquotes($_POST['nome_progetto']);
		$data_progetto = aquotes($_POST['data_progetto']);
		$descrizione = aquotes($_POST['descrizione']);

		$iddt = (int)$_POST['iddt'];
		$nfoto = (int)$_POST['nfoto'];
		$visibilita = (int)$_POST['visibilita'];
		
		if(!empty($nome_progetto) && $data_progetto != '0000-00-00' && !empty($descrizione))
		{
			$s1 = $db->Query("UPDATE wg_progetti SET nome_progetto = '$nome_progetto', data_progetto = '$data_progetto', descrizione = '$descrizione', visibilita = '$visibilita' WHERE id = '$iddt'");

			$id_progetto = $iddt;

			for($i=1; $i<=$nfoto; $i++)
			{
				$titolo_foto = aquotes($_POST['titolo_foto'. $i]);
				$nome_foto = aquotes($_FILES['foto'. $i]['name']);
				$ordine_foto = aquotes($_POST['ordine_foto'. $i]);

				if(!empty($nome_foto))
				{
					$foto = new Uploader('foto'. $i);
					$foto->set_opt('controllo estensione', true);
					$foto->set_opt('estensioni consentite', 'jpg, png, jpeg, JPG, JPEG, PNG');
					$foto->set_opt('sovrascrittura', false);

					if(!$foto->upload('dati/foto-progetti/'))
					{
						$_SESSION['warning'] = "Progetto caricato ma alcune foto presentano degli errori: $foto->getError()";
					}
					else
					{
						$s2 = $db->Query("INSERT INTO wg_progetti_foto (id_progetto, nome_foto, foto, ordine) VALUES ('$id_progetto', '$titolo_foto', '".$foto->getName()."', '$ordine_foto')");
					}
				}
			}

			$_SESSION['success'] = "Progetto caricato con successo!";
			phpRedir("progetti.php");
		}
		else
		{
			$_SESSION['error'] = "Compilare tutti i campi obbligatori";
		}
	}

	if(isset($_POST['sendLayer']))
	{
		$nome_layer = aquotes($_POST['nome_layer']);
		
		$id_progetto = (int)$_POST['id_progetto'];
		$id_madre = (int)$_POST['id_madre'];
		$visibilita = (int)$_POST['visibilita'];
		$ordine = (int)$_POST['ordine'];

		$colore = aquotes($_POST['colore']);
		$coloreinterno = aquotes($_POST['coloreinterno']);
		$forzatura = (int)$_POST['forzatura'];

		if(substr($colore, 0, 1) != '#') $colore = '#' . $colore;
		if(substr($coloreinterno, 0, 1) != '#') $coloreinterno = '#' . $coloreinterno;

		$qgis = $_FILES['qgis']['name'];

		$nomegis = '';

		if($forzatura == 0)
		{
			$forzalinea = 0;
			$forzapoligono = 0;
		}
		elseif($forzatura == 1)
		{
			$forzalinea = 0;
			$forzapoligono = 1;
		}
		elseif($forzatura == 2)
		{
			$forzalinea = 1;
			$forzapoligono = 0;
		}

		if(!empty($qgis))
		{
			$gis = new Uploader('qgis');
			$gis->set_opt('controllo estensione', true);
			$gis->set_opt('estensioni consentite', 'kml, KML');
			$gis->set_opt('sovrascrittura', false);

			if(!$gis->upload('dati/layers/'))
			{
				$_SESSION['warning'] = "Layer inserito ma il KML presenta degli errori: $gif->getError()";
			}
			else
			{
				$nomegis = $gis->getName();

				$tiposhape = 0;

				// interpreto i dati GIS
				$kml = simplexml_load_file("dati/layers/".$nomegis);

				$folder = $kml->Document->Folder;

				$elementiGIS = array();
				$attributi = array();

				// ogni poligono
				foreach($folder->Placemark as $particella)
				{
					$schema = $particella->ExtendedData->SchemaData;

					$infoparticella = array();

					if(count($schema->SimpleData) > 0)
					{

						foreach($schema->SimpleData as $attributo)
						{
							$testuale = dequotes($attributo->asXML());

							if(preg_match("#name=\"([^\"]+)\"#", $testuale, $q))
							{
								if(!in_array(sanitize_attributes(addslashes((string)$q[1])), $attributi))
									$attributi[] = sanitize_attributes(addslashes((string)$q[1]));

									

								$valattr = preg_match("#>([^<]+)<#", $testuale, $qat);

								

								$infoparticella['attributi'][sanitize_attributes(addslashes($q[1]))] = sanitize_attributes(addslashes((string)$qat[1]));
							}
						}
					}

					
					$poligono = $particella->Polygon;

					

					if(!$poligono) $poligono = $particella->MultiGeometry->Polygon;

					

					if($poligono && $poligono->outerBoundaryIs)
					{

						if($tiposhape == 0)
						{
							$tiposhape = 2;
						}
						else
						{
							$tiposhape = 0;
						}

						foreach($poligono->outerBoundaryIs as $bordo)
						{
							$scoordinate = $bordo->LinearRing->coordinates;
							
							//$coordinate = explode(" ", $scoordinate);
							$coordinate = preg_split("#[\s]+#", trim($scoordinate));
							
							
							
							$valco = array();
							
							foreach($coordinate as $coo)
							{
								if(!empty($coo))
								{
									$co2 = explode(",", $coo);
								
									$valco[] = array(addslashes(trim((float)$co2[1])), addslashes(trim((float)$co2[0])));
								}
							}
							
							$infoparticella['bordi'][] = $valco;
						}

						foreach($poligono->innerBoundaryIs as $bordo)
						{
							$scoordinate = $bordo->LinearRing->coordinates;
							//$coordinate = explode(" ", $scoordinate);
							$coordinate = preg_split("#[\s]+#", trim($scoordinate));
							
							
							$valco = array();
							
							foreach($coordinate as $coo)
							{
								if(!empty($coo))
								{
									$co2 = explode(",", $coo); 
								
									$valco[] = array(addslashes(trim((float)$co2[1])), addslashes(trim((float)$co2[0])));
								}
							}
							
							$infoparticella['interno'][] = $valco;
						}
					}
					


					// linee
					$lineePoligono = $particella;

					if($lineePoligono->MultiGeometry)
					{

						if($tiposhape == 0)
						{
							$tiposhape = 3;
						}
						else
						{
							$tiposhape = 0;
						}

						foreach($lineePoligono->MultiGeometry as $bordo)
						{
							$scoordinate = $bordo->LineString->coordinates;
							
							//$coordinate = explode(" ", $scoordinate);
							$coordinate = preg_split("#[\s]+#", trim($scoordinate));
							
							
							$valco = array();
							
							foreach($coordinate as $coo)
							{
								if(!empty($coo))
								{
									$co2 = explode(",", $coo);
								
									$valco[] = array((trim((float)$co2[1])), (trim((float)$co2[0])));
								}
							}
							
							$infoparticella['coo'][] = $valco;

							
						}
					}

					if($lineePoligono->LineString)
					{	
						if($tiposhape == 0)
						{
							$tiposhape = 3;
						}
						else
						{
							$tiposhape = 0;
						}

						foreach($lineePoligono->LineString as $bordo)
						{
							$scoordinate = $bordo->coordinates;
							
							//$coordinate = explode(" ", $scoordinate);
							$coordinate = preg_split("#[\s]+#", trim($scoordinate));
							
							


							$valco = array();
							
							foreach($coordinate as $coo)
							{
								if(!empty($coo))
								{
									$co2 = explode(",", $coo);
								
									$valco[] = array((trim((float)$co2[1])), (trim((float)$co2[0])));
								}
							}
							
							$infoparticella['coo'][] = $valco;

						}
					}

					if($lineePoligono->Point)
					{
						if($tiposhape == 0)
						{
							$tiposhape = 1;
						}
						else
						{
							$tiposhape = 0;
						}

						// punti
						foreach($lineePoligono->Point as $bordo)
						{
							$scoordinate = $bordo->coordinates;
							
							//$coordinate = explode(" ", $scoordinate);
							$coordinate = preg_split("#[\s]+#", trim($scoordinate));
							
							
							$valco = array();
							
							foreach($coordinate as $coo)
							{
								if(!empty($coo))
								{
									$co2 = explode(",", $coo);
								
									$valco[] = array(addslashes(trim((float)$co2[1])), addslashes(trim((float)$co2[0])));
								}
							}
							
							$infoparticella['punti'][] = $valco;

							
						}
					}

					// aggiungo gli elementi del layer
					$elementiGIS[] = $infoparticella;
				}
			}

			

			$qgis = serialize($elementiGIS);
			$attri = serialize($attributi);

			//print_r($attri);
			//die();

			$template = "<h3>Propriet&agrave;</h3>";

			foreach($attributi as $proprieta)
			{
				$template .= "<p><strong>".stripslashes($proprieta).":</strong> {{".stripslashes($proprieta)."}}</p>";
			}

			$add = $db->Query("INSERT INTO wg_progetti_layers (id_progetto, id_madre, nome_layer, ordine, visibilita, colore, coloreinterno, forzalinea, forzapoligono, attributi, template, boundaries, tiposhape) VALUES ('$id_progetto', '$id_madre', '$nome_layer', '$ordine', '$visibilita', '$colore', '$coloreinterno', '$forzalinea', '$forzapoligono', '$attri', '$template', '$qgis', '$tiposhape')");
		}
		else
		{
			$add = $db->Query("INSERT INTO wg_progetti_layers (id_progetto, id_madre, nome_layer, ordine, visibilita, colore, coloreinterno, forzalinea, forzapoligono, attributi, template, boundaries) VALUES ('$id_progetto', '$id_madre', '$nome_layer', '$ordine', '$visibilita', '$colore', '$coloreinterno' '$forzalinea', '$forzapoligono', '', '', '')");

		}

		if($add)
		{
			phpRedir("addProgetto.php?act=addLayer&prj=".$id_progetto);
		}


	}


	if(isset($_POST['sendTemplate']))
	{
		$summernote = aquotes($_POST['summernote']);

		$lyr = (int)$_POST['lyr'];
		$prj = (int)$_POST['prj'];

		$mod = $db->Query("UPDATE wg_progetti_layers SET template  = '$summernote' WHERE id_progetto = '$prj' AND id = '$lyr'");

		$_SESSION['success'] = "Template modificato correttamente per il layer";
		phpRedir("addProgetto.php?act=addLayer&prj=".$id_progetto);
	}
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
		
		<!-- Summernote css -->
		<link rel="stylesheet" href="vendors/bower_components/summernote/dist/summernote.css" />
		
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
			<?php
										
				if(empty($_GET['act']))
				{

					if(isset($_GET['prj']))
					{
						$prj = (int)$_GET['prj'];

						// dati progetto

						$s = $db->Query("SELECT * FROM wg_progetti WHERE id = '$prj'");

						if($db->Found($s))
						{
							$f = $db->getObject($s);

							$modifica = true;
						}
						else
						{
							$modifica = false;
							
						}


					}
					else
					{
						$modifica = false;
					}
					
			?>
					<!-- Main Content -->
					<div class="page-wrapper">
						<div class="container-fluid">
							
							<!-- Title -->
							<div class="row heading-bg">
								<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
									<h5 class="txt-dark">Nuovo Progetto</h5>
								</div>
							
								<!-- Breadcrumb -->
								<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
									<ol class="breadcrumb">
										<li><a href="index.html">Dashboard</a></li>
										<li><a href="#"><span>Progetti</span></a></li>
										<li class="active"><span>Nuovo Progetto</span></li>
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
												<form action="" id="formProgetto" method="post" enctype="multipart/form-data">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="nome_progetto">Nome Progetto <sup>*</sup></label>
																<input type="text" class="form-control" name="nome_progetto" id="nome_progetto" value="<?=dequotes($f->nome_progetto)?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="data_progetto">Data Progetto <sup>*</sup></label>
																<input type="date" class="form-control" name="data_progetto" id="data_progetto" value="<?=dequotes($f->data_progetto)?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="visibilita">Visibilit&agrave; Progetto <sup>*</sup></label>
																<select class="form-control" name="visibilita" id="visibilita">
																	<option <?=($f->visibilita == 0) ? 'selected="selected"' : ''; ?> value="0">Pubblico</option>
																	<option <?=($f->visibilita == 1) ? 'selected="selected"' : ''; ?> value="1">Solo Admin</option>
																	<option <?=($f->visibilita == 2) ? 'selected="selected"' : ''; ?> value="2">Tecnici e Admin</option>
																	<option <?=($f->visibilita == 3) ? 'selected="selected"' : ''; ?> value="3">Consorziate, Tecnici e Admin</option>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="descrizione">Descrizione <sup>*</sup></label>
																<textarea rows="3" class="form-control" name="descrizione" id="descrizione"><?=dequotes($f->descrizione)?></textarea>
															</div>
														</div>
													</div>
													<hr />
													<div class="row">
														<div class="col-md-12">
															<p class="mb-20" style="color: #234151; font-weight: 500;">Allega Foto</p>
														</div>
													</div>
													<div id="nuovefoto">
														
													</div>
													<input type="hidden" name="nfoto" id="nfoto" value="0" />
													<div class="row">
														<div class="col-md-12">
															<p class="text-center"><a class="btn btn-sm btn-info" onclick="addNewFoto()">Aggiungi Foto</a></p>
														</div>
													</div>
													<br />
													<br />
													<?php
													if($modifica)
													{
														$nf = $db->Query("SELECT * FROM wg_progetti_foto WHERE id_progetto = '$prj' ORDER BY ordine ASC");

														if($db->Found($nf))
														{
													?>
													<div class="row">
														<div class="col-md-12">
															<div class="table-responsive">
																<table class="table table-striped mb-0">
																	<thead class="bg-dark">
																		<tr>
																			<th>Titolo</th>
																			<th>Nome File</th>
																			<th width="20">Ordine</th>
																			<th class="text-nowrap"></th>
																	</tr>
																	</thead>
																	<tbody>
																	<?php
																		while($fnf = $db->getObject($nf))
																		{
																	?>
																		<tr class="txt-dark" id="foto_<?=$fnf->id?>">
																			<td><?=dequotes($fnf->nome_foto)?></td>
																			<td><?=dequotes(basename($fnf->foto))?></td>
																			<td><?=dequotes($fnf->ordine)?></td>
																			<td class="text-nowrap text-right">
																				<a href="javascript:;" onclick="delFoto(<?=$fnf->id?>)" data-toggle="tooltip" data-original-title="Elimina file"><i class="fa fa-close text-danger"></i> </a> 
																			</td>
																		</tr>
																	<?php
																		}
																	?>
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<script type="text/javascript">
														function delFoto(id)
														{
															if(confirm("Sei sicuro di voler eliminare questa foto per il progetto?"))
															{
																$.post("ajax/_delFotoProgetto.php", "id=" + id, function(dati)
																{
																	if(dati == '1')
																	{
																		$('tr#foto_' + id).remove();
																	}
																	else
																	{
																		error("Errore durante la cancellazione della foto...");
																	}
																});
															}
														}
													</script>
													<?php
														}
													}
													?>
													<hr />
													<div class="row">
														<div class="col-md-12">
															<div class="pull-left">
																<a href="progetti.php" class="btn btn-sm btn-danger">Indietro</a>
															</div>
															<input type="hidden" name="iddt" id="iddt" value="<?=$prj?>">
															<div class="pull-right">
																<input type="hidden" name="<?=($modifica) ? 'mod' : 'send'; ?>Progetto" id="<?=($modifica) ? 'mod' : 'send'; ?>Progetto" value="1" />
																<a href="javascript:;" onclick="creaProgetto()" class="btn btn-sm btn-success">Salva</a>
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
				elseif($_GET['act'] == 'addLayer')
				{
					$prj = (int)$_GET['prj'];
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
												<li> 
													<i class="fa fa-angle-right txt-dark"></i>
													<label style="color: #234151; width: 97%"><input id="xnode-0" data-id="custom-0" type="checkbox" /> <?=dequotes($fg->nome_layer)?> <a href="javascript:;" onclick="delLayer(<?=$fg->id?>, <?=$prj?>)" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a><?php if(!empty($fg->attributi)): ?> <a href="addProgetto.php?act=modLayer&prj=<?=$prj?>&lyr=<?=$fg->id?>" title="Modifica template Layer" style="float: right;margin-right: 10px"><i class="fa fa-cog txt-primary"></i></a><?php endif; ?></label>
													<?php
														treeviewLayers($fg->id, $prj);
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
									</div>
								</div>
								<div class="col-md-8">
									<div class="panel panel-default card-view">
										<div class="panel-wrapper collapse in">
											<div class="panel-body">
												<form action="" id="formLayers" method="post" enctype="multipart/form-data">
													<div class="row">
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="nome_layer">Nome Layer <sup>*</sup></label>
																<input type="text" class="form-control" name="nome_layer" id="nome_layer" value="">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="id_madre">Inserisci dentro a <sup>*</sup></label>
																<select class="form-control" name="id_madre" id="id_madre">
																	<option value="0">- root -</option>
																<?php
																	$g = $db->Query("SELECT id, nome_layer FROM wg_progetti_layers WHERE id_madre = '0'");

																	while($fg = $db->getObject($g))
																	{
																?>
																	<option value="<?=$fg->id?>"><?=dequotes($fg->nome_layer)?></option>
																<?php
																		selectLayers($fg->id);
																	}
																?>
																</select>
															</div>
														</div>
													</div>
													<br />
													<div class="row">
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="visibilita">Visibilit&agrave; Layer <sup>*</sup></label>
																<select class="form-control" name="visibilita" id="visibilita">
																	<option value="0">Pubblico</option>
																	<option value="1">Solo Admin</option>
																	<option value="2">Tecnici e Admin</option>
																	<option value="3">Consorziati, Tecnici e Admin</option>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="ordine">Ordine <sup>*</sup></label>
																<input type="number" class="form-control" name="ordine" id="ordine" value="1">
															</div>
														</div>
													</div>
													<br />
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="colore">Colore linea</label>
																<input type="text" class="form-control jscolor" name="colore" id="colore" value="#FFFFFF">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="coloreinterno">Colore riempimento</label>
																<input type="text" class="form-control jscolor" name="coloreinterno" id="coloreinterno" value="#FFFFFF">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label mb-10 text-left font-500" for="forzatura">Forzatura poligono</label>
																<select class="form-control" name="forzatura" id="forzatura">
																	<option value="0">Nessuna</option>
																	<option value="1" title="Le linee saranno automaticamente chiuse se non fatto da GIS, e verra applicato un riempimento">Forza Poligono</option>
																	<option value="2" title="I poligoni non verranno riempiti, e solo le linee saranno visibili">Forza Linee</option>
																</select>
															</div>
														</div>
													</div>
													<br />
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label style="font-weight: 500;" class="control-label mb-10 text-left">Carica file .kml</label>
																<input type="file" id="qgis" name="qgis" class="form-control dropify" data-max-file-size="20M" />
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
																<input type="hidden" name="id_progetto" id="id_progetto" value="<?=$prj?>" />
																<input type="hidden" name="sendLayer" id="sendLayer" value="1" />
																<a href="javascript:;" onclick="caricaLayer()" class="btn btn-sm btn-success">Salva</a>
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
						<script type="text/javascript">
							function caricaLayer()
							{
								var nome_layer = $('input#nome_layer').val();
								var ordine = $('input#ordine').val();

								if(nome_layer != '' && ordine != '')
								{
									$('form#formLayers').submit();
								}
							}
						</script>
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
				elseif($_GET['act'] == 'modLayer')
				{
					$prj = (int)$_GET['prj'];
					$lyr = (int)$_GET['lyr'];

					// ottengo il template salvato
					$dasa = $db->Query("SELECT template FROM wg_progetti_layers WHERE id_progetto = '$prj' AND id = '$lyr'");
					$fasa = $db->getObject($dasa);
			?>
			
					<!-- Main Content -->
					<div class="page-wrapper">
						<div class="container-fluid">
							
							<!-- Title -->
							<div class="row heading-bg">
								<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
									<h5 class="txt-dark">Modifica Layer</h5>
								</div>
							
								<!-- Breadcrumb -->
								<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
									<ol class="breadcrumb">
										<li><a href="index.html">Dashboard</a></li>
										<li><a href="#"><span>Progetti</span></a></li>
										<li class="active"><span>Modifica Layer</span></li>
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
												<li> 
													<i class="fa fa-angle-right txt-dark"></i>
													<label style="color: #234151; width: 97%"><input id="xnode-0" data-id="custom-0" type="checkbox" /> <?=dequotes($fg->nome_layer)?> <a href="javascript:;" onclick="delLayer(<?=$fg->id?>, <?=$prj?>)" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a><?php if(!empty($fg->attributi)): ?> <a href="addProgetto.php?act=modLayer&prj=<?=$prj?>&lyr=<?=$fg->id?>" title="Modifica template Layer" style="float: right;margin-right: 10px"><i class="fa fa-cog txt-primary"></i></a><?php endif; ?></label>
													<?php
														treeviewLayers($fg->id, $prj);
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
									</div>
								</div>
								<div class="col-md-8">
									<div class="panel panel-default card-view">
										<div class="panel-wrapper collapse in">
											<div class="panel-body">
												<form action="" id="formTemplate" method="post">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<textarea class="summernote" name="summernote"><?=dequotes($fasa->template)?></textarea>
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
																<input type="hidden" name="id_progetto" id="id_progetto" value="<?=$prj?>" />
																<input type="hidden" name="id_layer" id="id_layer" value="<?=$lyr?>" />
																<input type="hidden" name="sendTemplate" id="sendTemplate" value="1" />
																<a href="javascript:;" onclick="$('form#formTemplate').submit()" class="btn btn-sm btn-success">Salva</a>
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
						<script type="text/javascript">
							function caricaLayer()
							{
								var nome_layer = $('input#nome_layer').val();
								var ordine = $('input#ordine').val();

								if(nome_layer != '' && ordine != '')
								{
									$('form#formLayers').submit();
								}
							}
						</script>
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
		
		<!-- Summernote Plugin JavaScript -->
		<script src="vendors/bower_components/summernote/dist/summernote.min.js"></script>
			
		<!-- Summernote Wysuhtml5 Init JavaScript -->
		<script src="dist/js/summernote-data.js"></script>
		
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
		<script src="dist/js/jscolor.js"></script>
		<script src="dist/js/custom.js"></script>
		
		<!-- Treeview -->
		<script src="dist/js/hummingbird-treeview.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function()
			{
				
				$("#treeview").hummingbird();
			});

			function addNewFoto()
			{
				var nfoto = parseInt($('input#nfoto').val());

				nfoto += 1;

				$('div#nuovefoto').append('<div class="row"><div class="col-md-4"><div class="form-group"><label class="control-label mb-10 text-left font-500" for="titolo_foto' + nfoto + '">Titolo</label><input type="text" class="form-control" name="titolo_foto' + nfoto + '" id="titolo_foto1" value=""></div></div><div class="col-md-4"><div class="form-group"><label class="control-label mb-10 text-left font-500" for="foto' + nfoto + '">Foto</label><input type="file" class="form-control" name="foto' + nfoto + '" id="foto' + nfoto + '" value=""></div></div><div class="col-md-4"><div class="form-group"><label class="control-label mb-10 text-left font-500" for="ordine_foto' + nfoto + '">Ordine</label><input type="number" class="form-control" name="ordine_foto' +  nfoto + '" id="ordine_foto' +  nfoto + '" value=""></div></div></div>');

				$('input#nfoto').val(nfoto);
			}

			function creaProgetto()
			{
				var nome_progetto = $('input#nome_progetto').val();
				var data_progetto = $('input#data_progetto').val();
				var descrizione = $('textarea#descrizione').val();

				if(nome_progetto != '' && data_progetto != '' && data_progetto != '00/00/0000' && data_progetto != '0000-00-00' && descrizione != '')
				{
					$('form#formProgetto').submit();
				}
				else
				{
					alert("Compilare tutti i campi obbligatori ...");
				}
			}

			function delLayer(id, $prj)
			{
				if(confirm("Sei sicuro di voler eliminare definitivamente questo layer dalla mappa del progetto?"))
				{
					$.post("ajax/_delLayer.php", "id=" + id, function(dati)
					{
						if(dati == '1')
						{
							location.href="addProgetto.php?act=addLayer&prj=" + $prj;
						}
						else
						{
							error("Impossibile eliminare questo layer ...")
						}
					});
				}
			}
		</script>
	</body>
</html>
