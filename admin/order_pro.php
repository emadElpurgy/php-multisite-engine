<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteOrderQuery = 'delete from `orders` where `order_id` = '.$_GET['order_id'];
    $deleteOrderResult = query_result($deleteOrderQuery);
}elseif($_GET['action']=="setShipped"){
    $updateQuery = 'update `orders` set `status` = "1" where `order_id` = '.$_GET['order_id']; 
    $updateResult = query_result($updateQuery);
    require_once 'order_shipped_email.php';
}elseif($_GET['action']=="setCanceled"){
    $updateQuery = 'update `orders` set `status` = "3" where `order_id` = '.$_GET['order_id']; 
    $updateResult = query_result($updateQuery);
}
header("Location: orders.php");
?>
