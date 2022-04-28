<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteProjectQuery = 'delete from `product_files` where `id` = '.$_GET['id'];
    $deleteProjectResult = query_result($deleteProjectQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `product_files` set `publish` = "1" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `product_files` set `publish` = "0" where `id` = '.$_GET['id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['file']['name'] != ''){
        $fileArray = $_FILES['file'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/products/'.$fileArray['name'];
        $logo = 'img/products/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    if($_POST['id'] > 0){
        $updateProductQuery = 'update `product_files` set `short_description` = "'.addslashes($_POST['short_description']).'"';
        if($_FILES['file']['name'] != ''){
            $updateProductQuery.=' , `file_url` = "'.$logo.'"';
        }
        $updateProductQuery.=' where `id` = '.$_POST['id'];
        $updateResult = query_result($updateProductQuery);
    }else{
        if($_FILES['file']['name'] != ''){
            $icon=$logo;
        }else{
            $icon='';
        }
        $insertQuery = 'insert into `product_files`(`product_id`,`file_url`,`short_description`)values("'.$_POST['product_id'].'","'.$icon.'","'.addslashes($_POST['short_description']).'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: product_files.php?product_id=".$_GET['product_id']);
?>