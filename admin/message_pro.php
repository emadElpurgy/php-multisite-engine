<?php
$connectionDetails = require_once ("../config.php");
require_once ("../db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if($_GET['action']=="delete"){
    $deleteMessageQuery = 'delete from `messages` where `message_id` = '.$_GET['message_id'];
    $deleteMessageResult = query_result($deleteMessageQuery);
}
header("Location: messages.php");
?>
