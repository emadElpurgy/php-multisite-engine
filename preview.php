<?php 
	require_once("header.php");
	function getPageUrl($pageId,$url){
		$getPageUrlQuery = 'select * from `pages` where `id` = '.$pageId; 
		$page = query_result($getPageUrlQuery);
		if(count($page) > 0){
			$url = str_replace(" ","-",strtolower($page[0]['page_name'])).'/'.$url;
			if($page[0]['page_of'] > 0){
				$url = getPageUrl($page[0]['page_of'],$url);
			}			
		}
		return $url;
	}

	if(isset($_GET['service_name']) && $_GET['service_name'] != ""){
		$pPage = substr($pluginPages['p_1'], 1);
		$urlArg = explode('/', $pPage.'/'.$_GET['service_name'].'/');		
	}
	if(isset($_GET['project_name']) && $_GET['project_name'] != ""){
		$pPage = substr($pluginPages['p_2'], 1);
		$urlArg = explode('/', $pPage.'/'.$_GET['project_name'].'/');				
	}

	if(isset($_GET['page_id']) && $_GET['page_id'] > 0){
		$url = getPageUrl($_GET['page_id'],'');
		$urlArg = explode('/', substr($url,0,-1));				
	}
	$mode = 'preview';
	$mainPageId = 0;
	foreach($urlArg as $arg){
		$getPageQuery = 'select * from `pages` where `id` > 0 and replace(lower(convert(`page_name` using UTF8))," ","-") = "'.strtolower($arg).'" and `pages`.`page_of` = '.$mainPageId;	
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
