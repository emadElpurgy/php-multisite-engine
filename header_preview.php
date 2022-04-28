<?php 
	$connectionDetails = require_once ("config.php");
	require_once ("db.php");
	$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
	$getSiteResult = query_result($getSiteQuery);
	$siteId = $getSiteResult[0]['site_id'];
	$pageReadyScript = '';
	$getInfoQuery = '
	select 
		`attributes`.`attribute_name`,
		`site_attributes`.`attribute_value`
	from 
		`site_attributes` 
		inner join `attributes` on(`attributes`.`attribute_id` = `site_attributes`.`attribute_id`)
	where 
		`site_attributes`.`site_id` = '.$siteId;
	$getInfoResult = query_result($getInfoQuery);
	$siteInfoArray = array();
	if(count($getInfoResult) > 0){
		foreach($getInfoResult as $value){	
			$siteInfoArray[strtolower(str_replace(" ","_",$value['attribute_name']))] = $value['attribute_value'];
		}
	}
	function info($attrbuteName){
		global $siteInfoArray;
		if(isset($siteInfoArray[$attrbuteName])){
			echo $siteInfoArray[$attrbuteName];
		}
	}	
	$getSocialLinksQuery = '
	select 
		`attributes`.`attribute_name`,
		`site_attributes`.`attribute_value`
	from 
		`site_attributes` 
		inner join `attributes` on(`attributes`.`attribute_id` = `site_attributes`.`attribute_id`)
	where 
		`site_attributes`.`site_id` = '.$siteId.'
		and 
		`attributes`.`attribute_id` in (13,14,15,16,17,18)
		and 
		`site_attributes`.`attribute_value` <> ""';
	$socialLinks = query_result($getSocialLinksQuery);
	$getSiteHeaderSlidesQuery = 'select * from `site_header_slides` where `site_id` = '.$siteId;
	if(isset($_GET['id']) && $_GET['id'] > 0){
        $getSiteHeaderSlidesQuery.=' and `id` = '.$_GET['id'];
    }
	$headSlides = query_result($getSiteHeaderSlidesQuery);

	$getSitePagesQuery = '
	select
		`pages`.`id`,
		`page_name`,
		replace(lower(convert(`page_name` using UTF8))," ","-")as "url"
	from 
		`pages`
	where 
		`pages`.`site_id` = '.$siteId.'
		and 
		`pages`.`page_of` = 0';
	$pages = query_result($getSitePagesQuery);
	$urlArg = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
	$pluginPages = array();
	$pagesFullUrl = array();
	function drawMenu($siteId,$parent,$urlArg,$parentUrl){
		global $pluginPages,$pagesFullUrl;
		$getSitePagesQuery = '
		select
			`pages`.`id`,
			replace(lower(convert(`page_name` using UTF8))," ","-")as "url",
			replace(lower(convert(`plugins`.`plugin_name` using UTF8))," ","-")as "plugin_url",
			`pages`.`page_name`,
			`pages`.`home`,
			`pages`.`plugin_id`
		from 
			`pages`
			left join `plugins` on(`plugins`.`plugin_id` = `pages`.`plugin_id`)
		where 
			`pages`.`site_id` = '.$siteId.'
			and 
			`pages`.`publish` = 1 
			and 
			`pages`.`page_of` = '.$parent;
		$pages = query_result($getSitePagesQuery);
		if(count($pages) > 0){
			foreach($pages as $page){
				if(in_array($page['url'],$urlArg)){
					$current = '<span class="sr-only">(current)</span>';
					$currentClass = 'active';
				}else{
					$current = '';
					$currentClass = '';
				}
				$checkSubMenusQuery = 'select `pages`.`id`,`page_name` from `pages`	where `pages`.`site_id` = '.$siteId.' and `pages`.`publish` = 1 and `pages`.`page_of` = '.$page['id'];
				$subPages = query_result($checkSubMenusQuery);
				if(count($subPages) > 0){
					$parentGroup = 'navGroup'.$parent;
					echo '
					<li class="nav-item '.$currentClass.'">							
						<a class="nav-link text-nowrap" href="#collapseMenu'.$page['id'].'" aria-expanded="false" data-toggle="collapse" aria-controls="collapseMenu'.$page['id'].'" role="button"><i class="fa fa-bars" aria-hidden="true" data-toggle="collapse"></i>&nbsp;'.$page['page_name'].$current.'</a>
						<div class="collapse  position-absolute" id="collapseMenu'.$page['id'].'" data-parent="#'.$parentGroup.'">
							<div class="container-fluid bg-dark bg-inverse ">
								<div class="p-2 m-0 text-white">
									<!-- Collapsible Menu here -->
										<ul class="navbar-nav" id="navGroup'.$page['id'].'">';
											drawMenu($siteId,$page['id'],$urlArg,$parentUrl.$page['url'].'/');
										echo'
										</ul>
								</div>
							</div>							
						</div>
					</li>';
				}else{
					if($urlArg[0] == ""){
						if($page['home'] == "1"){
							$linkUrl = '#'.$page['url'];
						}elseif($page['plugin_id'] > 0){
							$linkUrl = '#'.$page['plugin_url'];
						}else{
							$linkUrl = '/'.$parentUrl.$page['url'];	
						}
					}elseif($page['plugin_id'] == "4"){
						$linkUrl = '/';
					}else{
						$linkUrl = '/'.$parentUrl.$page['url'];
					}
					echo '<li class="nav-item '.$currentClass.'"><a class="nav-link text-nowrap" href="'.$linkUrl.'">'.$page['page_name'].$current.'</a></li>';
					$pagesFullUrl['p_'.$page['id']] = $linkUrl;
				}
				if($page['plugin_id'] > 0){
					$pluginPages['p_'.$page['plugin_id']] = '/'.$parentUrl.$page['url'];
				}
			}
		}		
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php info("website_name"); ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap-ltr.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="/css/landing.style.css" rel="stylesheet">
	<!-- image gallery -->
	<link href="/css/lightgallery.css" rel="stylesheet">
    <!-- animate css -->
    <link href="/css/animate.min.css" rel="stylesheet">
	<!-- site intro -->
	<link href="https://cdn.jsdelivr.net/lightgallery/1.3.9/css/lightgallery.min.css" rel="stylesheet">
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
		        </div>
		        <!-- Collapsible content -->
		    </div>
		</nav>
		<!--/.Navbar-->
		<?php 				
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
		?>
	</header>
	<!--Main layout-->
	<main class="mt-5">
		<div class="container">
        <div>
    </main>
        <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/js/mdb.min.js"></script>
    <!-- image gallery -->
    <script type="text/javascript" src="/js/lightgallery.js"></script>
    <!-- jquery aniview-->
	<!--Google Maps-->
	<script src="https://maps.google.com/maps/api/js"></script>
    <!-- animate -->
    <script type="text/javascript" src="/js/jquery.aniview.js"></script>
	<script>
	    $('.carousel').carousel({
	        interval: 10000,
			pause: "false"
	    })
		$("a[href^='#']").on('click', function(e) {
			// prevent default anchor click behavior
			e.preventDefault();
			//remove active calss from navbar links
			//$('.navbar-nav>.active').removeClass('active');
			//add active calss to selected navbar link
   			$(this).parent('li').addClass('active');
			// store hash
   			var hash = this.hash;
		   // animate
		   $('html, body').animate({
		       scrollTop: $(hash).offset().top
		    }, 300, function(){
		       // when done, add hash to url
		       // (default click behaviour)
		       window.location.hash = hash;
		    });
		});
	</script>	
	<!-- Google Maps settings -->
	<script>
		//Regular map
		function regular_map() {
			var var_location = new google.maps.LatLng(<?php info('lat'); ?>, <?php info('long'); ?>);
			var var_mapoptions = {
				center: var_location,
				zoom: 14
			};
			var var_map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);
			var var_marker = new google.maps.Marker({
				position: var_location,
				map: var_map,
				title: "<?php  info('address'); ?>"
			});
		}
		$('.anim').AniView({animateThreshold: 100,scrollPollInterval: 0});
		//alert("<? echo $_GET['go']; ?>");
		$(document).ready(function(){
			<?php 
				echo $pageReadyScript;
			?>
		});
	</script>
</body>
</html>	
