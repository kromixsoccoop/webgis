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
				<?php
				if(!is_logged())
				{
				?>
					<a href="login.php"><i class="zmdi zmdi-square-right"></i> &nbsp;Login</a>
				<?php
				}
				else
				{
				?>
				<a href="index.php">Benvenuto <strong><?php
				if(isset($_SESSION['fullname']))
				{
					echo $_SESSION['fullname'];
				}
				?></strong></a>
				<?php
				}
				?>
			</li>
		</ul>
	</div>	
</nav>