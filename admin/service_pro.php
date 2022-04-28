<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteServiceQuery = 'delete from `services` where `service_id` = '.$_GET['service_id'];
    $deleteServiceResult = query_result($deleteServiceQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `services` set `publish` = "1" where `service_id` = '.$_GET['service_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `services` set `publish` = "0" where `service_id` = '.$_GET['service_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="feature"){
    $updateQuery = 'update `services` set `home` = "1" where `service_id` = '.$_GET['service_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unfeature"){
    $updateQuery = 'update `services` set `home` = "0" where `service_id` = '.$_GET['service_id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['icon']['name']!=''){
        $fileArray = $_FILES['icon'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/services/'.$fileArray['name'];
        $logo = 'img/services/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['service_id'] > 0){
        $updateServiceQuery = 'update `services` set `service_name` = "'.addslashes($_POST['service_name']).'",`short_description` = "'.addslashes($_POST['short_description']).'", `description` = "'.addslashes($_POST['description']).'" , `slug` = "'.$_POST['slug'].'"';
        if($_FILES['icon']['name']!=''){
            $updateServiceQuery.=' , `icon` = "'.$logo.'"';
        }
        $updateServiceQuery.=' where `service_id` = '.$_POST['service_id'];
        $updateResult = query_result($updateServiceQuery);
    }else{
        if($_FILES['icon']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `services`(`service_name`,`icon`,`short_description`,`description`,`slug`,`site_id`)values("'.addslashes($_POST['service_name']).'","'.$icon.'","'.addslashes($_POST['short_description']).'","'.addslashes($_POST['description']).'","'.$_POST['slug'].'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: services.php");
?>
