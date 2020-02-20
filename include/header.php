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
		<a style="font-size: 18px; position: relative; top: 20px; left: 20px;">SISTEMA INFORMATIVO TERRITORIALE IONIO CROTONESE</a>
		<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
	</div>
	<div id="mobile_only_nav" class="mobile-only-nav pull-right">
		<ul class="nav navbar-right top-nav pull-right">
			<?php
				if(!is_logged())
				{
			?>
				<li>
					<a href="login.php"><i class="zmdi zmdi-square-right"></i> &nbsp;Login</a>
				</li>
			<?php
				}
				else
				{
			?>
				<li>
				<a href="index.php">Benvenuto &nbsp;<strong style="font-size: 18px; color: #8FB7E1;"><?php
					if(isset($_SESSION['fullname']))
					{
						echo $_SESSION['fullname'];
					}
					?></strong></a>
				</li>
				<li class="dropdown auth-drp">
					<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><i class="zmdi zmdi-settings top-nav-icon"></i></a>
					<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
						<li>
							<a href="index.php"><i style="color: #fff;" class="zmdi zmdi-card"></i><span>Pannello di Controllo</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="index.php?act=out"><i style="color: #fff;" class="zmdi zmdi-power"></i><span>Log Out</span></a>
						</li>
					</ul>
				</li>
			<?php
				}
			?>
			
		</ul>
	</div>	
</nav>