<div class="main-agile">
	<div class="header">
		<!-- navigation section -->
		<div class="w3_navigation">
			<div class="container">
				<nav class="navbar navbar-default">
					<div class="navbar-header navbar-left">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="logo">
							<h1><a class="navbar-brand" href="index.php">[社内ツール]</a></h1>
						</div>	
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
						<nav class="menu menu--miranda">
							<ul class="nav navbar-nav menu__list">
								<li class="menu__item menu__item--current"><a href="index.php" class="menu__link">Home</a></li>
								<li class="menu__item"><a href="#exampleModal" class="menu__link" data-toggle="modal">Login</a></li>
								<li class="menu__item"><a href="#signUpModal" class="menu__link" data-toggle="modal":>SignUp</a></li>
							</ul>
						</nav>
					</div>
				</nav>	
				<div class="clearfix"></div>
			</div>	
		</div>
		<!-- /navigation section -->
	</div>
</div>
<?php
	require_once("app/views/login.php");
	require_once("app/views/signup.php");
?>