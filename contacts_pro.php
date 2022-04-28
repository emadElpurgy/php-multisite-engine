<?php
    $connectionDetails = require_once ("config.php");
    require_once ("db.php");
    $getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
    $getSiteResult = query_result($getSiteQuery);
    $siteId = $getSiteResult[0]['site_id'];
    $insertQuery = 'insert into `messages`(`name`,`email`,`subject`,`message`,`message_date`,`site_id`)values("'.addslashes($_POST['name']).'","'.$_POST['email'].'","'.$_POST['subject'].'","'.$_POST['message'].'",now(),"'.$siteId.'")';
    $insertResult = query_result($insertQuery);
?>