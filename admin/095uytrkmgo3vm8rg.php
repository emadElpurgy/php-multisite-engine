<?php
    $connectionDetails = require_once ("../config.php");
    require_once ("../db.php");
    $checkUserQuery = 'select * from `users` where `email` = "'.$_POST['loginEmail'].'" and `password` = "'.$_POST['loginPassword'].'"';
    $checkUserResult = query_result($checkUserQuery);
    if(count($checkUserResult) == 0){
        header("Location: login.html");
    }else{
        $_SESSION['kjdfsd@98u9mfi9_98j32d-dkofj948r'] = '1';
        $_SESSION['dccKLDIyu@SdJI-sdfsdf9_si9dfuuj'] = $checkUserResult[0]['name'];
        header("Location: index.php");
    }
?>