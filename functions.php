<?php
function getSiteId($siteUrl){
    $getSiteQuery = 'select * from sites where site_name = "'.$siteUrl.'"';
	$getSiteResult = query_result($getSiteQuery);
	$siteId = $getSiteResult[0]['site_id'];
    return $siteId;
}

function getSiteInfo($siteId){
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
    $_SESSION['siteInfoArray'] = $siteInfoArray;
}

function info($attrbuteName){
    if(isset($_SESSION['siteInfoArray'][$attrbuteName])){
        echo $_SESSION['siteInfoArray'][$attrbuteName];
    }
}	



function getSocialLinks($siteId){
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
    return $socialLinks;
}


function getIntroSlides($siteId){
    $getSiteIntroQuery = 'select * from `site_intro_slides` where `site_id` = '.$siteId.' and `publish` = 1';
	$introSlides = query_result($getSiteIntroQuery);
    return $introSlides;
}

function getHeaderSlides($siteId){
	$getSiteHeaderSlidesQuery = 'select * from `site_header_slides` where `site_id` = '.$siteId.' and `publish` = 1';
	$headSlides = query_result($getSiteHeaderSlidesQuery);
    return $headSlides;
}


$pluginPages = array();
$pagesFullUrl = array();
function drawMenu($siteId,$parent,$urlArg,$parentUrl){
    global $pluginPages,$pagesFullUrl;
    $getSitePagesQuery = '
    select
        `pages`.`id`,
        `pages`.`slug`,
        `pages`.`url`,
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
            if(in_array($page['slug'],$urlArg)){
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
                                    drawMenu($siteId,$page['id'],$urlArg,$parentUrl.$page['slug'].'/');
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
                        $linkUrl = '/'.$page['url'];	
                    }
                }elseif($page['plugin_id'] == "4"){
                    $linkUrl = '/';
                }else{
                    $linkUrl = '/'.$page['url'];
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
