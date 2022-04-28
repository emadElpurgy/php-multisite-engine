<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteProjectQuery = 'delete from `project_files` where `id` = '.$_GET['id'];
    $deleteProjectResult = query_result($deleteProjectQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `project_files` set `publish` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `project_files` set `publish` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['file']['name'] != ''){
        $fileArray = $_FILES['file'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/projects/'.$fileArray['name'];
        $logo = 'img/projects/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['id'] > 0){
        $updateProjectQuery = 'update `project_files` set `short_description` = "'.addslashes($_POST['short_description']).'"';
        if($_FILES['file']['name'] != ''){
            $updateProjectQuery.=' , `file_url` = "'.$logo.'"';
        }
        $updateProjectQuery.=' where `id` = '.$_POST['id'];
        $updateResult = query_result($updateProjectQuery);
    }else{
        if($_FILES['file']['name'] != ''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `project_files`(`project_id`,`file_url`,`short_description`)values("'.$_POST['project_id'].'","'.$icon.'","'.addslashes($_POST['short_description']).'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: project_files.php?project_id=".$_GET['project_id']);
?>
