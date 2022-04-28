<?php
    $connectionDetails = require_once ("config.php");
    require_once ("db.php");
    $getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
    $getSiteResult = query_result($getSiteQuery);
    $siteId = $getSiteResult[0]['site_id'];    
    if($_GET['action'] == 'addToWishlist'){
        $getProductQuery = 'select * from `products` where `url`= "'.$_GET['productId'].'" and `site_id` = '.$siteId;
        $Product = query_result($getProductQuery);
        $insertQuery = 'insert into `user_products`(`user_id`,`product_id`)values("'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'","'.$Product[0]['product_id'].'")';
        $insertResult = query_result($insertQuery);
    }elseif($_GET['action'] == 'removeFromWishlist'){
        $getProductQuery = 'select * from `products` where `url`= "'.$_GET['productId'].'" and `site_id` = '.$siteId;
        $Product = query_result($getProductQuery);
        $deleteQuery = 'delete from `user_products` where `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'" and `product_id` = "'.$Product[0]['product_id'].'"';
        $deleteResult = query_result($deleteQuery);
    }elseif($_GET['action'] == "addToCart"){    
        $getProductQuery = 'select * from `products` where `url`= "'.$_GET['productId'].'" and `site_id` = '.$siteId;
        $Product = query_result($getProductQuery);
        $insertQuery = 'insert into `cart`(`user_id`,`product_id`,`price`,`quantity`,`total_price`)values("'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'","'.$Product[0]['product_id'].'","'.$Product[0]['price'].'","1","'.$Product[0]['price'].'")';
        $insertResult = query_result($insertQuery);
    }elseif($_GET['action'] == "removeFromCart"){
        $getProductQuery = 'select * from `products` where `url`= "'.$_GET['productId'].'" and `site_id` = '.$siteId;
        $Product = query_result($getProductQuery);
        $deleteQuery = 'delete from `cart` where `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'" and `product_id` = "'.$Product[0]['product_id'].'"';
        $deleteResult = query_result($deleteQuery);
    }elseif($_GET['action'] == "setCartQuantity"){
        $updateQuery = 'update `cart` set `quantity` = "'.$_GET['quantity'].'" , `price` = "'.$_GET['price'].'" , `total_price` = "'.$_GET['total_price'].'"  where `cart_id` = "'.$_GET['cartId'].'"';
        $updateResult = query_result($updateQuery);
    }elseif($_GET['action'] == "clearCart"){
        $deleteQuery = 'delete from `cart` where `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'"';
        $deleteResult = query_result($deleteQuery);
        header('Location:/');
        exit;
    }elseif($_GET['action'] == "deleteFromCart"){
        $deleteQuery = 'delete from `cart` where `cart_id` = '.$_GET['id'];
        $deleteResult = query_result($deleteQuery);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }elseif($_GET['action'] == "setRating"){        
        $deleteQuery = 'delete from `product_rating` where `product_id` = '.$_GET['product_id'].' and `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'"';
        $deleteResult = query_result($deleteQuery);
        $insertQuery = 'insert into `product_rating` (`product_id`,`user_id`,`rating`)values("'.$_GET['product_id'].'","'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'","'.$_GET['ratingNumber'].'")';
        $insertResult = query_result($insertQuery);
    }

?>