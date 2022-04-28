<?php
$connectionDetails = require_once ("config.php");
require_once ("db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(!isset($_GET['emailcode'])){
    $checkEmailQuery = 'select * from `users` where `email` = "'.addslashes(trim($_POST['email'])).'" and `site_id` = "'.$siteId.'"';
    $checkEmailResult = query_result($checkEmailQuery);
    if(count($checkEmailResult) == 0){
        $insertUserQuery = 'insert into `users` (`name`,`email`,`password`,`profile_image`,`site_id`,`verification_code`)values("'.addslashes(trim($_POST['name'])).'","'.addslashes(trim($_POST['email'])).'","'.addslashes(trim($_POST['password'])).'","","'.$siteId.'",MD5(UUID()))';
        $insertUserResult = query_result($insertUserQuery);
        if($insertUserResult > 0){
            $getCodeQuery = 'select * from `users` where `id` = '.$insertUserResult;
            $userInfo = query_result($getCodeQuery);
            if(count($userInfo) > 0){
                //send email
            }
        }
        $_SESSION['message'] = 'email verification code was send to your email address.';
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }else{
        $_SESSION['message'] = 'Email address already in use.';
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }
}else{
    $getCodeQuery = 'select * from `users` where `verification_code` = "'.$_GET['emailcode'].'"';
    $userInfo = query_result($getCodeQuery);
    if(count($userInfo) > 0){
        $updateQuery = 'update `users` set `email_verified` = "1" where `id` = "'.$userInfo[0]['id'].'"';    
        $updateResult = query_result($updateQuery);
        $_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'] = $userInfo[0]['id'];
    }
    header('Location:/');
    exit;
}


?>