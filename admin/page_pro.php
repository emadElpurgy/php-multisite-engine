<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
function createUrl($pageId){
    $getUrlQuery = 'select `url`  from `pages` where `id` = '.$pageId;
    $categoryUrl = query_result($getUrlQuery);
    $url = $categoryUrl[0]['url'];    
    return $url;
}
if($_GET['action']=="delete"){
    $deletePageQuery = 'delete from `pages` where `id` = '.$_GET['id'];
    $deletePageResult = query_result($deletePageQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `pages` set `publish` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `pages` set `publish` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="feature"){
    $updateQuery = 'update `pages` set `home` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unfeature"){
    $updateQuery = 'update `pages` set `home` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_POST['page_of'] > 0){
        $url = createUrl($_POST['page_of']);
        $url.='/'.$_POST['slug'];
    }else{
        $url=$_POST['slug'];
    }
    if($_POST['id'] > 0){
        $updatePageQuery = 'update `pages` set `page_name` = "'.addslashes($_POST['page_name']).'",`page_body` = "'.addslashes($_POST['page_body']).'", `page_of` = "'.$_POST['page_of'].'" , `plugin_id` = '.$_POST['plugin_id'].' , `slug` = "'.$_POST['slug'].'" , `url` = "'.$url.'" where `id` = '.$_POST['id'];
        $updateResult = query_result($updatePageQuery);
    }else{
        $insertQuery = 'insert into `pages`(`page_name`,`page_body`,`page_of`,`plugin_id`,`slug`,`url`,`site_id`)values("'.addslashes($_POST['page_name']).'","'.addslashes($_POST['page_body']).'","'.$_POST['page_of'].'","'.$_POST['plugin_id'].'","'.$_POST['slug'].'","'.$url.'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}

header("Location: pages.php");
?>
