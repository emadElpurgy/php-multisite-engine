<?php
$connectionDetails = require_once ("config.php");
require_once ("db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];

if(isset($_SESSION['login_id'])){
    //header('Location:/');
    //exit;
}
require "glogin.php";
if(isset($_GET['code'])):
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);	
	if(!isset($token["error"])){        
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        // Storing data into database
        $id = $google_account_info->id;
        $full_name = trim($google_account_info->name);
        $email = $google_account_info->email;
        $profile_pic = $google_account_info->picture;
        // checking user already exists or not
		$getUserQuery = 'select `id`,`google_id` from `users` where `google_id` = "'.$id.'" and `site_id` = "'.$siteId.'"';		
        $User = query_result($getUserQuery);		
        //file_put_contents("f",$getUserQuery);
        if(count($User) > 0){
            $updateLoginDateQuery = 'update users set `last_login` = "'.date('Y-m-d H:i').'" where id = '.$User[0]['id'];
            $updateLoginDateResult = query_result($updateLoginDateQuery);
            $_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'] = $User[0]['id'];
            $_SESSION['login_id'] = $id; 
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit;
        }else{
            // if user not exists we will insert the user
			$insertUser = 'insert into `users`(`name`,`email`,`password`,`site_id`,`google_id`,`profile_image`)values("'.$full_name.'","'.$email.'","","'.$siteId.'","'.$id.'","'.$profile_pic.'") ';
            $insert = query_result($insertUser);
            $updateLoginDateQuery = 'update users set `last_login` = "'.date('Y-m-d H:i').'" where id = '.$insert;
            $updateLoginDateResult = query_result($updateLoginDateQuery);
            $_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'] = $insert;
            if($insert){
                $_SESSION['login_id'] = $id; 
                header('Location:'.$_SERVER['HTTP_REFERER']);
                exit;
            }else{
                $_SESSION['message'] = "Sign up failed!(Something went wrong).";
            }
        }
    }else{
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }
else: 
    //login using user name and password
    $checkQuery = 'select * from `users` where `email` = "'.$_POST['email'].'" and `password` = "'.$_POST['password'].'"';
    $result = query_result($checkQuery);
    if(count($result) > 0){
        if($result[0]['email_verified'] == "1"){
            $updateLoginDateQuery = 'update users set `last_login` = "'.date('Y-m-d H:i').'" where id = '.$result[0]['id'];
            $updateLoginDateResult = query_result($updateLoginDateQuery);
            $_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'] = $result[0]['id'];
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit;
        }else{
            $_SESSION['message'] = 'Email Not Verified';
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit;
        }
    }else{
        $_SESSION['message'] = 'Wrong Email Or Password';
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }
endif; 
?>