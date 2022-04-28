<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
function updateAttribute($attributeId,$attributeValue,$siteId){
    $checkValueExistsQuery = 'select * from `site_attributes` where `site_id` = '.$siteId.' and `attribute_id` = '.$attributeId;
    $checkValueExistsResult = query_result($checkValueExistsQuery);
    if(count($checkValueExistsResult) > 0){
        $updateQuery = 'update `site_attributes` set `attribute_value` = "'.$attributeValue.'" where `id` = '.$checkValueExistsResult[0]['id'];    
        $updateResult = query_result($updateQuery);
    }else{
        $insertQuery = 'insert into `site_attributes`(`site_id`,`attribute_id`,`attribute_value`)values("'.$siteId.'","'.$attributeId.'","'.$attributeValue.'")';
        $insertResult = query_result($insertQuery);
    }
}
updateAttribute("1",$_POST['website_name'],$siteId);
if(count($_FILES['file']) > 0){
    $fileArray = $_FILES['file'];
    $fileNameParts = explode(".",$fileArray['name']);
    $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
    $fullPath = '../img/logo'.$siteId.'.'.$fileExtention;
    $logo = 'img/logo'.$siteId.'.'.$fileExtention;
    move_uploaded_file($fileArray['tmp_name'],$fullPath);
    updateAttribute("2",$logo,$siteId);
}
updateAttribute("3",$_POST['full_name'],$siteId);
updateAttribute("4",$_POST['phone'],$siteId);
updateAttribute("5",$_POST['fax'],$siteId);
updateAttribute("6",$_POST['mobile'],$siteId);
updateAttribute("7",$_POST['email'],$siteId);
updateAttribute("8",$_POST['address'],$siteId);
updateAttribute("9",$_POST['lat'],$siteId);
updateAttribute("10",$_POST['long'],$siteId);
updateAttribute("11",$_POST['start'],$siteId);
updateAttribute("12",$_POST['end'],$siteId);
updateAttribute("13",$_POST['facebook'],$siteId);
updateAttribute("14",$_POST['twitter'],$siteId);
updateAttribute("15",$_POST['instagram'],$siteId);
updateAttribute("16",$_POST['linkedIn'],$siteId);
updateAttribute("17",$_POST['google'],$siteId);
updateAttribute("18",$_POST['youtube'],$siteId);
updateAttribute("19",$_POST['slogon'],$siteId);

updateAttribute("20",$_POST['navcolor'],$siteId);
updateAttribute("21",$_POST['socialcolor'],$siteId);
updateAttribute("22",$_POST['footercolor'],$siteId);
updateAttribute("23",$_POST['buttoncolor'],$siteId);
updateAttribute("24",$_POST['dir'],$siteId);
header("Location: info.php");
?>
