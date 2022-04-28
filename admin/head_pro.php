<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteServiceQuery = 'delete from `site_header_slides` where `id` = '.$_GET['id'];
    $deleteServiceResult = query_result($deleteServiceQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `site_header_slides` set `publish` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `site_header_slides` set `publish` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['image']['name']!=''){
        $fileArray = $_FILES['image'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/header/'.$fileArray['name'];
        $logo = 'img/header/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['id'] > 0){
        $updateServiceQuery = 'update `site_header_slides` set `slide_head` = "'.addslashes($_POST['slide_head']).'",`slide_text` = "'.addslashes($_POST['slide_text']).'"';
        if($_FILES['image']['name']!=''){
            $updateServiceQuery.=' , `slide_img_url` = "'.$logo.'"';
        }
        $updateServiceQuery.=' where `id` = '.$_POST['id'];
        $updateResult = query_result($updateServiceQuery);
    }else{
        if($_FILES['image']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `site_header_slides`(`slide_img_url`,`slide_head`,`slide_text`,`site_id`)values("'.$icon.'","'.addslashes($_POST['slide_head']).'","'.addslashes($_POST['slide_text']).'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: headers.php");
?>
