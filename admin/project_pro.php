<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteProjectQuery = 'delete from `projects` where `project_id` = '.$_GET['project_id'];
    $deleteProjectResult = query_result($deleteProjectQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `projects` set `publish` = "1" where `project_id` = '.$_GET['project_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `projects` set `publish` = "0" where `project_id` = '.$_GET['project_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="feature"){
    $updateQuery = 'update `projects` set `home` = "1" where `project_id` = '.$_GET['project_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unfeature"){
    $updateQuery = 'update `projects` set `home` = "0" where `project_id` = '.$_GET['project_id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['icon']['name']!=''){
        $fileArray = $_FILES['icon'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/projects/'.$fileArray['name'];
        $logo = 'img/projects/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['project_id'] > 0){
        $updateProjectQuery = 'update `projects` set `project_name` = "'.addslashes($_POST['project_name']).'",`short_description` = "'.addslashes($_POST['short_description']).'", `description` = "'.addslashes($_POST['description']).'" , `customer_name` = "'.addslashes($_POST['customer_name']).'" , `contract_date` = "'.$_POST['contract_date'].'" , `start_date` = "'.$_POST['start_date'].'" , `end_date` = "'.$_POST['end_date'].'" , `slug` = "'.$_POST['slug'].'"';
        if($_FILES['icon']['name']!=''){
            $updateProjectQuery.=' , `icon` = "'.$logo.'"';
        }
        $updateProjectQuery.=' where `project_id` = '.$_POST['project_id'];
        $updateResult = query_result($updateProjectQuery);
    }else{
        if($_FILES['icon']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `projects`(`project_name`,`icon`,`short_description`,`description`,`site_id`,`customer_name`,`contract_date`,`start_date`,`end_date`,`slug`,`site_id`)values("'.addslashes($_POST['project_name']).'","'.$icon.'","'.addslashes($_POST['short_description']).'","'.addslashes($_POST['description']).'","'.$siteId.'","'.addslashes($_POST['customer_name']).'","'.$_POST['contract_date'].'","'.$_POST['start_date'].'","'.$_POST['end_date'].'","'.$_POST['slug'].'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: projects.php");
?>
