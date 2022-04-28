<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
function createCategoryUrl($categoryId){
    $getUrlQuery = 'select `url`  from `categories` where `category_id` = '.$categoryId;
    $categoryUrl = query_result($getUrlQuery);
    $url = $categoryUrl[0]['url'];    
    return $url;
}

if($_GET['action']=="delete"){
    $deleteProductQuery = 'delete from `products` where `product_id` = '.$_GET['product_id'];
    $deleteCategoryResult = query_result($deleteProductQuery);
}elseif($_GET['action']=="publish"){
    $updateQuery = 'update `products` set `publish` = "1" where `product_id` = '.$_GET['product_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unpublish"){
    $updateQuery = 'update `products` set `publish` = "0" where `product_id` = '.$_GET['product_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="feature"){
    $updateQuery = 'update `products` set `home` = "1" where `product_id` = '.$_GET['product_id']; 
    $updateResult = query_result($updateQuery);
}elseif($_GET['action']=="unfeature"){
    $updateQuery = 'update `products` set `home` = "0" where `product_id` = '.$_GET['product_id']; 
    $updateResult = query_result($updateQuery);
}elseif(isset($_POST)){
    if($_FILES['icon']['name']!=''){
        $fileArray = $_FILES['icon'];
        $fileNameParts = explode(".",$fileArray['name']);
        $fileExtention = $fileNameParts[(count($fileNameParts)-1)];
        $fullPath = '../img/products/'.$fileArray['name'];
        $logo = 'img/products/'.$fileArray['name'];
        move_uploaded_file($fileArray['tmp_name'],$fullPath);
    }
    $url = createCategoryUrl($_POST['category_id']);
    $url.='/'.$_POST['slug'];
    if($_POST['product_id'] > 0){
        $updateProductQuery = 'update `products` set `product_name` = "'.addslashes($_POST['product_name']).'",`short_description` = "'.addslashes($_POST['short_description']).'", `description` = "'.addslashes($_POST['description']).'" , `category_id` = "'.$_POST['category_id'].'" , `price` = "'.$_POST['price'].'" ,`slug` = "'.$_POST['slug'].'" , `url` = "'.$url.'"';
        if($_FILES['icon']['name']!=''){
            $updateProductQuery.=' , `icon` = "'.$logo.'"';
        }
        $updateProductQuery.=' where `product_id` = '.$_POST['product_id'];
        $updateResult = query_result($updateProductQuery);
    }else{
        if($_FILES['icon']['name']!=''){
            $icon=$logo;
        }else{
            $icon='';
        }        
        $insertQuery = 'insert into `products`(`product_name`,`icon`,`category_id`,`short_description`,`description`,`price`,`slug`,`url`,`site_id`)values("'.addslashes($_POST['product_name']).'","'.$icon.'","'.$_POST['category_id'].'","'.addslashes($_POST['short_description']).'","'.addslashes($_POST['description']).'","'.$_POST['price'].'","'.$_POST['slug'].'","'.$url.'","'.$siteId.'")';
        $insertResult = query_result($insertQuery);
    }
}
header("Location: products.php");
?>
