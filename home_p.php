<?php 
	$getAllServicesQuery = 'select * from `services` where `site_id` = '.$siteId.' and `publish` = 1 and `home` = 1';
	$Services = query_result($getAllServicesQuery);
	$getAllProjectsQuery = 'select * from `projects` where `site_id` = '.$siteId.' and `publish` = 1 and `home` = 1';
	$Projects = query_result($getAllProjectsQuery);
	$getAllPagesQuery = 'select * from `pages` where `site_id` = '.$siteId.' and `publish` = 1 and `home` = 1';
	$Pages = query_result($getAllPagesQuery);
	$getContactPluginPageQuery = 'select * from `pages` where `id` > 0 and `site_id` = '.$siteId.' and `plugin_id` = 3';
	$ContactPluginPage = query_result($getContactPluginPageQuery);
	$getAllCategoriesQuery = 'select * from `categories` where `publish` = 1 and `home` = 1 and `site_id` = '.$siteId;
	$Categories = query_result($getAllCategoriesQuery);
	$getAllProductsQuery = 'select * from `products` where `publish` = 1 and `home` = 1 and `site_id` = '.$siteId;
	$Products = query_result($getAllProductsQuery);
	echo '
	<!--pages-->';
	if(count($Pages) > 0){
		foreach($Pages as $page){
			echo '
			<section id="'.str_replace(" ","-",strtolower($page['page_name'])).'">
				<!-- Heading -->
				<h2 class="mb-5 font-weight-bold">'.$page['page_name'].'</h2>
				<!--Grid row-->
				<div class="row d-flex justify-content-center mb-4">
					<!--Grid column-->
					<div class="col-md-12">
						<p class="grey-text text-justify">'.$page['page_body'].'</p>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->				
			</section>';
		}
	}
	echo '
	<!--Services -->';
	if(count($Services) > 0){
		echo '
		<section id="services" class="text-center">
			<h2 class="mb-5 font-weight-bold">Services</h2>
			<div class="row">';
				foreach($Services as $service){
					echo '
					<!--Grid column-->
					<div class="col-md-4 mb-1">
						<div class="anim" data-av-animation="slideInLeft">
							<a href="/services/'.str_replace(" ","-",strtolower($service['service_name'])).'"><img src="/'.$service['icon'].'" width="100%"></a>
							<h4 class="my-4">'.$service['service_name'].'</h4>
						</div>
					</div>';
				}
				echo '
			</div>
			<div align="right">
				<a href="'.$pluginPages['p_1'].'" class="link-primary link-color">All Services</a>
			</div>

			<!--Grid row-->
		</section>';
	}
	echo '
	<!-- projects -->';
	if(count($Projects) > 0){
		echo '
		<section id="projects" class="text-center">
		    <!-- Heading -->
		    <h2 class="mb-5 font-weight-bold">Projects</h2>
		    <!--Grid row-->
		    <div class="row">';
				foreach($Projects as $project){
					echo '
					<!--Grid column-->
					<div class="col-lg-4 col-md-12 mb-4">
						<div class="anim" data-av-animation="rotateIn">
							<div class="view overlay z-depth-1-half">
								<img src="/'.$project['icon'].'" class="card-img-top" alt="">
								<div class="mask rgba-white-slight"></div>
							</div>
							<a href="/projects/'.str_replace(" ","-",strtolower($project['project_name'])).'" ><h4 class="my-4 font-weight-bold link-color">'.$project['project_name'].'</h4></a>
							<p class="grey-text">'.$project['short_description'].'</p>
						</div>
					</div>';
				}
				echo '
		    </div>
		    <!--Grid row-->
			<div align="right">
				<a href="'.$pluginPages['p_2'].'" class="link-primary link-color">All Projects</a>
			</div>
		</section>';
	}
	
	if(count($Categories) > 0 || count($Products) > 0){
		if(count($Categories) != 3){
			$cols = (12 / ceil(sqrt(count($Categories))));		
		}else{
			$cols = 4;
		}
		echo '
		<section id="product-catalog" class="text-center">
		    <!-- Heading -->
			<h2 class="mb-5 font-weight-bold">Product Catalog</h2>
			

		    <!--Grid row-->
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h2 class="heading-section mb-5">Top Categories</h2>
					</div>
					<div class="col-md-12">
						<div class="featured-carousel2 owl-carousel">';
							foreach($Categories as $category){
								echo'
								<div class="item anim" data-av-animation="slideInUp">
									<div class="work">
										<div class="img d-flex align-items-end justify-content-center" style="height:200px;background-image: url(/'.$category['icon'].');">
											<div class="text w-100">											
												<h3><a href="'.$pluginPages['p_5'].'/'.$category['url'].'">'.$category['category_name'].'</a></h3>
											</div>
										</div>
									</div>
								</div>';
							}
							echo '
						</div>
					</div>
				</div>
			</div>
							



		    <!--Grid row-->
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h2 class="heading-section mb-5">Top Products</h2>
					</div>
					<div class="col-md-12">
						<div class="featured-carousel owl-carousel">';
							foreach($Products as $product){
								echo'
								<div class="item anim" data-av-animation="slideInUp">
									<div class="work">
										<div class="img d-flex align-items-end justify-content-center" style="background-image: url(/'.$product['icon'].');">
											<div class="text w-100">
												<span class="cat">'.$product['product_name'].'</span>
												<h3><a href="'.$pluginPages['p_5'].'/'.$product['url'].'">'.$product['short_description'].'</a></h3>
											</div>
										</div>
									</div>
								</div>';
							}
							echo '
						</div>
					</div>
				</div>
			</div>




			<div align="right">
				<a href="'.$pluginPages['p_5'].'" class="link-primary link-color">Browse Our Catalog</a>
			</div>
		</section>';		
	}

	if(count($ContactPluginPage) > 0){
		echo '
		<section id="contacts">';
		require_once('contacts_p.php');
		echo '
		</section>';
	}

?>

	
