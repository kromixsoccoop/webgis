<?php session_start();
	require_once("include/db.php");
	require_once("include/functions.php");

	if(is_logged())
	{
		phpRedir("index.php");
	}

	if(isset($_POST['login']))
	{
		$user = aquotes($_POST['user']);
		$pass = md5($_POST['pass']);
		$remember = ($_POST['remember']) ? true : false;

		$s = $db->Query("SELECT id, user, pass, livello, nome, cognome FROM wg_utenti WHERE user = '$user' AND pass = '$pass' AND attivo = '1'");

		if($db->Found($s))
		{
			$f = $db->getObject($s);

			$_SESSION['usid'] = (int)$f->id;
			$_SESSION['user'] = dequotes($f->user);
			$_SESSION['fullname'] = dequotes($f->nome." ".$f->cognome);

			if($remember)
			{
				setcookie("usid", (int)$f->id, ((((time() + 60) * 60) * 24) * 365));
				setcookie("check", md5($f->id.$f->pass), ((((time() + 60) * 60) * 24) * 365));
			}

			$db->Query("UPDATE wg_utenti SET last_access = NOW() WHERE id = '".$f->id."'");

			scrivi_reg("Login effettuato", "Login");

			$_SESSION['success'] = "Login eseguito correttamente!";
			phpRedir("index.php");
		}
		else
		{
			$_SESSION['error'] = "Dati di login errati";
			error_reg("Login errato da ".$_SERVER['REMOTE_ADDR'], "Login");
		}
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
		
		<div class="wrapper pa-0">		
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page">
				<div class="container-fluid">
					<!-- Row -->
					<div class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
											<h6 class="text-center nonecase-font txt-grey">
												<img src="img/logo.png" />
											</h6>
										</div>	
										<div class="form-wrap">
											<form action="" method="post">
												<div class="form-group">
													<label class="control-label-login mb-10" for="user">Nome Utente</label>
													<input type="text" tabindex="1" class="form-control" autofocus="autofocus" required="" id="user" name="user" placeholder="">
												</div>
												<div class="form-group">
													<label class="pull-left control-label-login mb-10" for="pass">Password</label>
													<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="forgot-password.html">Password dimenticata?</a>
													<div class="clearfix"></div>
													<input type="password" tabindex="2" class="form-control" required="" id="pass" name="pass" placeholder="">
												</div>
												
												<div class="form-group">
													<div class="checkbox checkbox-primary pr-10 pull-left">
														<input id="remember" tabindex="3" name="remember" type="checkbox">
														<label for="remember"> Ricordami</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group text-center">
													<input type="hidden" name="login" value="1" id="login">
													<button type="submit" tabindex="4" class="btn btn-info btn-sm btn-rounded">Login</button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
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
		
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
	</body>
</html>
