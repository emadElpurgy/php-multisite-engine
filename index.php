<?php 
	require_once("header.php");
	$mode = '';
	$mainPageId = 0;
	if($urlArg[0] == ''){
		$getSiteHomePageQuery = 'select * from `pages` where `id` > 0 and `site_id` = '.$siteId.' and `plugin_id` = 4 and `publish` = 1';
		$SiteHomePage = query_result($getSiteHomePageQuery);		
		if(count($SiteHomePage)>0){
			array_push($urlArg,str_replace("-","",strtolower($SiteHomePage[0]['page_name'])));
		}
	}
	foreach($urlArg as $arg){
		$getPageQuery = 'select * from `pages` where `id` > 0 and `site_id` = '.$siteId.' and `slug` = "'.strtolower($arg).'" and `publish` = 1 and `pages`.`page_of` = '.$mainPageId;	
		$getPageResult = query_result($getPageQuery);
		if(count($getPageResult) > 0){
			$mainPageId = $getPageResult[0]['id'];
			if($getPageResult[0]['plugin_id'] > 0){
				break;
			}
		}
	}
	if(count($getPageResult) > 0){
		if($getPageResult[0]['plugin_id'] > 0){
			$getPluginPageQuery = 'select * from `plugins` where `plugin_id` = '.$getPageResult[0]['plugin_id'];
			$PluginPage = query_result($getPluginPageQuery);
			require_once($PluginPage[0]['plugin_url'].".php");
		}else{
			echo '
			<section id="about-me" >
				<!-- Heading -->
				<h2 class="mb-5 font-weight-bold">'.$getPageResult[0]['page_name'].'</h2>
				<div class="row d-flex justify-content mb-4">
					'.$getPageResult[0]['page_body'].'
				</div>
			</section>';
		}
	}else{
		echo '
		<section id="about-me" class="text-center">
			<!-- Heading -->
			<h2 class="mb-5 font-weight-bold">Page Not Found</h2>
		</section>';
	}
	
	require_once("footer.php");
?>
