<?php 
	$connectionDetails = require_once ("config.php");
	require_once ("db.php");
	require_once ("functions.php");
	$siteId = getSiteId($_SERVER['HTTP_HOST']);
	getSiteInfo($siteId);
	$pageReadyScript = '';
	$socialLinks = getSocialLinks($siteId);
	$introSlides = getIntroSlides($siteId);
	$headSlides = getHeaderSlides($siteId);
	$urlArg = explode('/', trim($_SERVER['REQUEST_URI'], '/'));	
	if($_SESSION['siteInfoArray']['dir'] == 'ltr'){
		$SocialBarTextAlign = 'left';
		$SocialBarIconsAlign = 'right';
	}else{
		$SocialBarTextAlign = 'right';
		$SocialBarIconsAlign = 'left';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="google-signin-client_id" content="77034325127-mai3i5pssmtbudrobh0ucb12qdtcr8s2.apps.googleusercontent.com">
    <title><?php info("website_name"); ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap-<?php info('dir'); ?>.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
	
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
	<link rel="stylesheet" href="/css/style.css">

	<!-- facebook share button -->
	<meta property="og:url"           content="http://timberexecute.com" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Timber Execute" />
	<meta property="og:description"   content="Timber Execute Website" />
	<meta property="og:image"         content="http://timberexecute.com/img/1.png" />
	<!-- /facebook share button -->



    <link href="/css/landing.style.css" rel="stylesheet">
	<!-- image gallery -->
	<link href="/css/lightgallery.css" rel="stylesheet">
	<!-- product page-->
	<!-- animate css -->
    <link href="/css/animate.min.css" rel="stylesheet">
	<!-- site intro -->
	<link href="https://cdn.jsdelivr.net/lightgallery/1.3.9/css/lightgallery.min.css" rel="stylesheet">
	<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
	<style>
		.top-nav-collapse {
  			background-color: <?php info('navcolor');?>;
		}
		@media (max-width: 768px) {
			.navbar:not(.top-nav-collapse) {
    			background-color: <?php info('navcolor');?>;
			}
		}
		@media (min-width: 800px) and (max-width: 850px) {
			.navbar:not(.top-nav-collapse) {
				background-color: <?php info('navcolor');?>;
			}
		}
		<?php 
			$countSlides = 1;
			foreach($introSlides as $slide){
				echo '
				#view'.$countSlides.' {
					height:100vh;
					background: url("'.$slide['intro_img_url'].'")no-repeat center center fixed;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					background-size: cover;   
					-webkit-animation: zoom 20s;
					animation: zoom 20s;
				   
				}';
				$countSlides++;
			}
		?>
		.page-footer{
			background-color: <?php info('footercolor'); ?>;
		}
		.social-bar{
			background-color: <?php info('socialcolor'); ?>;
		}
		.button-color{
			background-color: <?php info('buttoncolor'); ?> !important;
		}
		.link-color{
			color:<?php info('buttoncolor'); ?> !important;
		}
	</style>
	<!--./site intro -->
</head>
<body>
    <!-- Start your project here-->
	<header>
		<!--Navbar-->
		<nav id="nav" class="navbar navbar-expand-lg navbar-dark  fixed-top scrolling-navbar">
		    <div class="container">
		        <!-- Navbar brand -->
		        <a class="navbar-brand" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>"><?php info("website_name"); ?></a>
		        <!-- Collapse button -->
		        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
		            aria-expanded="false" aria-label="Toggle navigation">
		            <span class="navbar-toggler-icon"></span>
		        </button>
		        <!-- Collapsible content -->
		        <div class="collapse navbar-collapse" id="basicExampleNav">
		            <!-- Links -->
		            <ul class="navbar-nav  mr-auto smooth-scroll" id="navGroup0">
						<?php  
							drawMenu($siteId,0,$urlArg,'');
						?>
		            </ul>
		            <!-- Links -->
					<!-- Social Icon  -->
					<ul class="navbar-nav nav-flex-icons">
						<?php
							foreach($socialLinks as $link){
								echo '
								<li class="nav-item"><a class="nav-link" href="'.$link['attribute_value'].'" title="'.$link['attribute_name'].'" target="new"><i class="fa fa-'.$link['attribute_name'].'"></i></a></li>';
							}
						?>
					</ul>

					<ul class="navbar-nav" >
						<!-- user menu -->
							<?php 							
								if(!isset($_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds']) || $_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'] ==""){
									require "glogin.php";
									echo'
									<li class="dropdown nav-item">
										<a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link"><img src="/img/avatar.png" class="avatar" alt="Avatar">Login<b class="caret"></b></a>		
										<ul class="dropdown-menu form-wrapper">
											<li>
												
												<p class="hint-text">Sign in with your Google account</p>
												<div class="form-group social-btn clearfix text-center" >
													<a href="'.$client->createAuthUrl().'" class="btn btn-primary "><i class="fa fa-google"></i> Google</a>
												</div>
												<div class="or-seperator"><b>or</b></div>';
												if(isset($_SESSION['message']) && $_SESSION['message'] != ""){
													echo'
													<p class="hint-text">'.$_SESSION['message'].'</p>';
													$_SESSION['message'] = "";
												}
												echo'
												<form action="/login.php" method="post">
													<div class="form-group">
														<input type="email" class="form-control" placeholder="Email" name="email" required="required">
													</div>
													<div class="form-group">
														<input type="password" class="form-control" placeholder="Password" name="password" required="required">
													</div>
													<div class="form-group text-center" >
														<input type="submit" class="btn btn-primary" value="Login">
													</div>
												</form>	
												<div class="or-seperator"><b>or</b></div>
												<p class="hint-text">Sign Up for a new account</p>
												<form action="/regester.php" method="post">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Name" name="name" required="required">
													</div>
													<div class="form-group">
														<input type="email" class="form-control" placeholder="Email" name="email" required="required">
													</div>
													<div class="form-group">
														<input type="password" class="form-control" placeholder="Password" name="password" required="required">
													</div>
													<div class="form-group text-center" >
														<input type="submit" class="btn btn-primary" value="Regester">
													</div>
												</form>													
											</li>
										</ul>
									</li>';
								}else{
									$getUserInfoQuery = 'select * from `users` where `id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'"';
									$userInfo = query_result($getUserInfoQuery);
									if($userInfo[0]['profile_image'] == ''){
										$userInfo[0]['profile_image']= '/img/Avatar.png';
									}
									echo '
									<li class="dropdown nav-item">
										<a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link"><img src="'.$userInfo[0]['profile_image'].'" class="avatar">'.$userInfo[0]['name'].'<b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li><a href="#"><i class="fa fa-user-o"></i> Wish list</a></li>
											<li><a href="'.$pluginPages['p_5'].'/cart"><i class="fa fa-cart-plus"></i> Cart</a></li>
											<li class="divider"></li>
											<li><a href="/logout.php"><i class="material-icons">&#xE8AC;</i> Logout</a></li>
										</ul>
									</li>';
								}
							?>
						<!--/user menu -->
					</ul>					
		        </div>
		        <!-- Collapsible content -->
				
		    </div>
		</nav>
		<!--/.Navbar-->
		<?php 				
			if($urlArg[0] ==""){
				echo'
				<!--site intro-->
				<div id="home-page" class="carousel slide carousel slide carousel-fade" data-ride="carousel">
					<!--Slides-->
					<div class="carousel-inner z-depth-1-half" role="listbox">';
						$countSlides = 1;
						foreach($introSlides as $slide){
							if($countSlides == 1){
								$activeSlide = 'active';
							}else{
								$activeSlide = '';
							}
							echo'
							<div class="carousel-item '.$activeSlide.'">
								<div class="view" id="view'.$countSlides.'">							
									<div class="mask rgba-black-light">
										<div class="container-fluid d-flex align-items-center justify-content-center h-100 animated fadeInUp">
											<div class="row d-flex justify-content-center text-center">
												<div class="col-md-12">
													<!-- Heading -->
													<h2 class="display-4 font-weight-bold white-text pt-5 mb-2">
														'.$slide['intro_head'].'
													</h2>
													<!-- Divider -->
													<hr class="hr-light">
													<!-- Description -->
													<h4 class="white-text my-4">
														'.$slide['intro_text'].'
													</h4>
													<a href="'.$pagesFullUrl['p_'.$slide['intro_link']].'" class="btn btn-outline-white">Read more<i class="fa fa-book ml-2"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>';
							$countSlides++;
						}						
						echo'
					</div>
					<!--/.Slides-->
				</div>
				<!--/.Mask-->';
			}else{
				echo '
				<!-- slider -->
				<div id="carousel-example-1z" class="carousel slide carousel slide carousel-fade" data-ride="carousel">
					<!--Indicators-->
					<ol class="carousel-indicators">';
						if(count($headSlides) > 0){
							$slideCount = 1;
							foreach($headSlides as $slide){
								if($slideCount == 1){
									$activeHSlide = 'active';
								}else{
									$activeHSlide = '';
								}
								echo'
								<li data-target="#carousel-example-1z" data-slide-to="'.($slideCount-1).'" class="'.$activeHSlide.'"></li>';
								$slideCount++;
							}
						}					
						echo'
					</ol>
					<!--/.Indicators-->
					<!--Slides-->
					<div class="carousel-inner z-depth-1-half" role="listbox">';
						if(count($headSlides) > 0){
							$slideCount = 1;
							foreach($headSlides as $slide){
								if($slideCount == 1){
									$activeHSlide = 'active';
								}else{
									$activeHSlide = '';
								}
								echo '
								<div class="carousel-item '.$activeHSlide.'">
									<div class="view">
										<img width="100%" src="/'.$slide['slide_img_url'].'">										
									</div>
									<div class="carousel-caption">
										<div class="animated fadeInDown">
											<h3 class="h3-responsive">'.$slide['slide_head'].'</h3>
											<p class="bbcArticleTitle">'.$slide['slide_text'].'</p>
										</div>
									</div>
								</div>';
								$slideCount++;
							}
						}
						echo'
					</div>
					<!--/.Slides-->
					<!--Controls-->
					<a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
					<!--/.Controls-->
				</div>
				<!-- /.slider -->';
			}
		?>
	</header>
	<!--Main layout-->
	<main class="mt-5">
		<div class="container">
			
	
