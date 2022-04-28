<?php 
	$getAllProjectsQuery = 'select * from `projects` where `site_id` = '.$siteId;
	if($mode != 'preview'){
		$getAllProjectsQuery.=' and `publish` = 1';
	}
	$Projects = query_result($getAllProjectsQuery);
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
	<section id="projects_section" class="text-center">
		<!-- Heading -->';
		if(count($pluginArguments) == 0){
			//plugin index 		
			echo '
			<h2 class="mb-5 font-weight-bold animated fadeInDown">Our Projects</h2>
			<div class="row d-flex justify-content-center mb-4">';
				if(count($Projects) > 0){				
					echo '
					<!--Grid row-->
					<div class="row">';
						foreach($Projects as $project){
							echo '
							<!--Grid column-->
							<div class="col-sm-6  p-2 animated fadeInUp">
								<!--Card-->
								<div class="card"  data-av-animation="rotateIn">
									<!--Card image-->
									<div class="view overlay">
										<img src="/'.$project['icon'].'" class="card-img-top" alt="">
										<a href="#"><div class="mask rgba-white-slight"></div></a>
									</div>		
									<!--Card content-->
									<div class="card-body">
										<!--Title-->
										<h4 class="card-title">'.$project['project_name'].'</h4>
										<!--Text-->
										<p class="card-text text-justify">'.$project['short_description'].'</p>
									</div>
									<div class="card-footer">
										<a href="'.$_SERVER['REQUEST_URI'].'/'.$project['slug'].'" class="btn btn-indigo button-color">Read More</a>
									</div>
								</div>
								<!--/.Card-->
							</div>
							<!--Grid column-->';
						}
						echo '
					</div>';
				}else{
					echo '<h2 class="mb-5 font-weight-bold">No Projects Available Now</h2>';
				}
				echo'
			</div>';
		}else{

			$getProjectInfoQuery = 'select * from `projects` where `site_id` = '.$siteId.' and `slug` = "'.$pluginArguments[0].'"';
			if($mode != 'preview'){
				$getProjectInfoQuery.=' and `publish` = 1';
			}
			$Project = query_result($getProjectInfoQuery);
			if(count($Project) > 0){
				$getProjectFilesQuery = 'select * from `project_files` where `project_id` = '.$Project[0]['project_id'];
				$images = query_result($getProjectFilesQuery);
				echo '
				<h2 class="mb-5 font-weight-bold animated fadeInDown">'.$Project[0]['project_name'].'</h2>
				<!--Grid row-->
				<div class="row">
					<!--Grid column-->
					<div class="col-md-5 mb-4">
						<div class="anim"  data-av-animation="slideInRight">
							<h2>'.$Project[0]['project_name'].'</h2>
							<hr>
							<p class="text-justify">'.$Project[0]['description'].'</p>						
							<blockquote class="blockquote text-center">
								<p class="mb-0">'.$Project[0]['customer_name'].'.</p>
								<footer class="blockquote-footer">From <cite title="Start Date">'.$Project[0]['start_date'].'</cite> To <cite title="end Date">'.$Project[0]['end_date'].'</cite></footer>
							</blockquote>
						</div>
					</div>
					<!--Grid column-->
					<!--Grid column-->
					<div class="col-md-7 mb-4 ">
						<div class="view overlay z-depth-1-half anim" data-av-animation="slideInLeft">
							<img src="/'.$Project[0]['icon'].'" class="card-img-top" alt="">
							<div class="mask rgba-white-light"></div>
						</div>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->
				<!-- files -->
				<div class="row">
					<div class="col-12">
						<div class="container" style="margin-top:40px;">
						<h2>'.$Project[0]['project_name'].' Images</h2>
						<div class="demo-gallery">
							<ul id="lightgallery" class="list-unstyled row">';
								foreach($images as $image){
									echo '
									<li class="col-xs-6 col-sm-4 col-md-2 col-lg-2" data-responsive="/'.$image['file_url'].'" data-src="/'.$image['file_url'].'" data-sub-html="'.$image['short_description'].'">
										<a href=""><img class="img-responsive" src="/'.$image['file_url'].'"></a>
									</li>';
								}
								echo '
							</ul>
						</div>
					</div>
				</div>';
				// Initialize photo gallery
				$pageReadyScript.= '
				$("#lightgallery").lightGallery();';
			}
		}
		echo '
	</section>';
?>
	
