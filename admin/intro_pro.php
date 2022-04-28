<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteServiceQuery = 'delete from `site_intro_slides` where `id` = '.$_GET['id'];
    $deleteServiceResult = query_result($deleteServiceQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `site_intro_slides` set `publish` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `site_intro_slides` set `publish` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['image']['name']!=''){
        $fileArray = $_FILES['image'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/intro/'.$fileArray['name'];
        $logo = 'img/intro/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['id'] > 0){
        $updateServiceQuery = 'update `site_intro_slides` set `intro_head` = "'.addslashes($_POST['intro_head']).'",`intro_text` = "'.addslashes($_POST['intro_text']).'", `intro_link` = "'.addslashes($_POST['intro_link']).'"';
        if($_FILES['image']['name']!=''){
            $updateServiceQuery.=' , `intro_img_url` = "'.$logo.'"';
        }
        $updateServiceQuery.=' where `id` = '.$_POST['id'];
        $updateResult = query_result($updateServiceQuery);
    }else{
        if($_FILES['image']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `site_intro_slides`(`intro_img_url`,`intro_head`,`intro_text`,`intro_link`,`site_id`)values("'.$icon.'","'.addslashes($_POST['intro_head']).'","'.addslashes($_POST['intro_text']).'","'.addslashes($_POST['intro_link']).'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: intros.php");
?>
