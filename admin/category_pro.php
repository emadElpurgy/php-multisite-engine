<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
function createCategoryUrl($categoryId,$url){
    $getUrlQuery = 'select `slug` as "url",`main_category` from `categories` where `category_id` = '.$categoryId;
    $categoryUrl = query_result($getUrlQuery);
    if(count($categoryUrl) > 0){
        $url = $categoryUrl[0]['url'].'/'.$url;
        if($categoryUrl[0]['main_category'] > 0){
            $url = createCategoryUrl($categoryUrl[0]['main_category'],$url);
        }
    }
    return $url;
}

if($_GET['action']=="delete"){
    $deleteCategoryQuery = 'delete from `categories` where `category_id` = '.$_GET['category_id'];
    $deleteCategoryResult = query_result($deleteCategoryQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `categories` set `publish` = "1" where `category_id` = '.$_GET['category_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `categories` set `publish` = "0" where `category_id` = '.$_GET['category_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="feature"){
    $updateQuery = 'update `categories` set `home` = "1" where `category_id` = '.$_GET['category_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unfeature"){
    $updateQuery = 'update `categories` set `home` = "0" where `category_id` = '.$_GET['category_id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['icon']['name']!=''){
        $fileArray = $_FILES['icon'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/categories/'.$fileArray['name'];
        $logo = 'img/categories/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    $url = createCategoryUrl($_POST['main_category'],"");
    $url.=$_POST['slug'];
    if($_POST['category_id'] > 0){
        $updateCategoryQuery = 'update `categories` set `category_name` = "'.addslashes($_POST['category_name']).'",`short_description` = "'.addslashes($_POST['short_description']).'", `description` = "'.addslashes($_POST['description']).'" , `main_category` = "'.$_POST['main_category'].'",`slug` = "'.$_POST['slug'].'" ,`url` = "'.$url.'"';
        if($_FILES['icon']['name']!=''){
            $updateCategoryQuery.=' , `icon` = "'.$logo.'"';
        }
        $updateCategoryQuery.=' where `category_id` = '.$_POST['category_id'];
        $updateResult = query_result($updateCategoryQuery);
    }else{
        if($_FILES['icon']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `categories`(`category_name`,`icon`,`main_category`,`short_description`,`description`,`slug`,`url`,`site_id`)values("'.addslashes($_POST['category_name']).'","'.$icon.'","'.$_POST['main_category'].'","'.addslashes($_POST['short_description']).'","'.addslashes($_POST['description']).'","'.$_POST['slug'].'","'.$url.'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: categories.php");
?>
