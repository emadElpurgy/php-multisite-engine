<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteServiceQuery = 'delete from `users` where `id` = '.$_GET['id'];
    $deleteServiceResult = query_result($deleteServiceQuery);
}
header("Location: users.php");
?>
