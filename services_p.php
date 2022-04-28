<?php 
	$getAllServicesQuery = 'select * from `services` where `site_id` = '.$siteId.' and `publish` = 1';
	$Services = query_result($getAllServicesQuery);
	/**** get argements ****/
	$mainPageId = 0;
	$pluginPageDetector = 0;
	$pluginArguments = array();
	foreach($urlArg as $arg){
		if($pluginPageDetector == 0){
			$getPageQuery = 'select * from `pages` where `id` > 0 and replace(lower(convert(`page_name` using UTF8))," ","-") = "'.strtolower($arg).'" and `pages`.`page_of` = '.$mainPageId;	
			$getPageResult = query_result($getPageQuery);
			if(count($getPageResult) > 0){
				$mainPageId = $getPageResult[0]['id'];
			}
		}else{
			array_push($pluginArguments,strtolower($arg));
		}
		if($getPageResult[0]['plugin_id'] > 0){
			$pluginPageDetector =1;
		}
	}
	/******* /get argements  ***/
	echo '
	<section id="services_section" class="text-center">
		<!-- Heading -->';
		if(count($pluginArguments) == 0){
			//plugin index 		
			echo '
			<h2 class="mb-5 font-weight-bold animated fadeInDown">Our Services</h2>
			<div class="row d-flex justify-content-center mb-4">';
				if(count($Services) > 0){				
					echo '
					<!--Grid row-->
					<div class="row">';
						foreach($Services as $service){
							echo '
							<!--Grid column-->
							<div class="col-sm-4 p-2 animated fadeInUp">
								<!--Card-->
								<div class="card h-100"  data-av-animation="rotateIn">
									<!--Card image-->
									<div class="view overlay">
										<img src="/'.$service['icon'].'" class="card-img-top" alt="">
										<a href="#"><div class="mask rgba-white-slight"></div></a>
									</div>		
									<!--Card content-->
									<div class="card-body">
										<!--Title-->
										<h4 class="card-title">'.$service['service_name'].'</h4>
										<!--Text-->
										<p class="card-text text-justify">'.$service['short_description'].'</p>
									</div>
									<div class="card-footer">
										<a href="'.$_SERVER['REQUEST_URI'].'/'.$service['slug'].'" class="btn btn-indigo button-color">Read More</a>
									</div>
								</div>
								<!--/.Card-->
							</div>
							<!--Grid column-->';
						}
						echo '
					</div>';
				}else{
					echo '<h2 class="mb-5 font-weight-bold">No Services Available Now</h2>';
				}
				echo'
			</div>';
		}else{
			$getServiceInfoQuery = 'select * from `services` where `site_id` = '.$siteId.' and `slug` = "'.$pluginArguments[0].'"';
			if($mode != 'preview'){
				$getServiceInfoQuery.=' and `publish` = 1';
			}
			$Service = query_result($getServiceInfoQuery);
			if(count($Service) > 0){
				echo '
				<h2 class="mb-5 font-weight-bold animated fadeInDown">'.$Service[0]['service_name'].'</h2>
				<!--Grid row-->
				<div class="row">
					<!--Grid column-->
					<div class="col-md-5 mb-4">
						<div class="anim"  data-av-animation="slideInRight">
							<h2>'.$Service[0]['service_name'].'</h2>
							<hr>
							<p class="text-justify">'.$Service[0]['description'].'</p>
						</div>
					</div>
					<!--Grid column-->
					<!--Grid column-->
					<div class="col-md-7 mb-4 ">
						<div class="view overlay z-depth-1-half anim" data-av-animation="slideInLeft">
							<img src="/'.$Service[0]['icon'].'" class="card-img-top" alt="">
							<div class="mask rgba-white-light"></div>
						</div>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->';
			}
		}
		echo '
	</section>';
?>
	
