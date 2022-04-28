<?php 
$connectionDetails = require_once ("config.php");
require_once ("db.php");
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
//check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    //get token, card and user info from the form
    $token  = $_POST['stripeToken'];
    $name = $_POST['fullName'];
    $address1 = $_POST['address'];
    $address2 = $_POST['address2'];
    $email = $_POST['email'];
    $nameOnCard = $_POST['cc-name'];
    $card_num = $_POST['cc-number'];
    $card_cvc = $_POST['cc-cvv'];
    $card_exp_month = $_POST['cc-expiration-month'];
    $card_exp_year = $_POST['cc-expiration-year'];
    //include Stripe PHP library
    require_once('stripe-php/init.php');
    
    //set api key
    $stripe = array(
      "secret_key"      => "sk_test_51JAYk6BHruTtVVwTRA6GYcMaIJdgzfZMs45R0URKqtpEgtMuNve5TQHVgWoeHe4sRH0LuU0Y4940DhfTYGwQphPp00r3X85X1s",
      "publishable_key" => "pk_test_51JAYk6BHruTtVVwTaeEQ74NUxTqPVDliiitkmuu6je2snMjO8Wwereu4FvhDk2ygpNkpgLwRTsD5dByNKHZbyqqX007e1e97eE"
    );
    
    \Stripe\Stripe::setApiKey($stripe['secret_key']);
    
    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));
    
    // create order from cart 
    query_result('begin');
    $getMaxOrderNumberQuery = 'select (ifnull(max(`order_number`),0)+1)as "number" from `orders` where `site_id` = '.$siteId;
    $orderNumber = query_result($getMaxOrderNumberQuery);
    $getOrderTotalQuery = 'select sum(`total_price`)as "total" from `cart` where `user_id` = '.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];    
    $orderTotal = query_result($getOrderTotalQuery);
    $getOrderItemsQuery = 'select * from `cart` where `user_id` = '.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];
    $Items = query_result($getOrderItemsQuery);
    $createOrderQuery = 'insert into `orders`(`order_number`,`order_date`,`total_price`,`user_id`,`name`,`email`,`address1`,`address2`,`cc_name`,`cc_number`,`cc_month`,`cc_year`,`created`,`site_id`)values("'.$orderNumber[0]['number'].'",curdate(),"'.$orderTotal[0]['total'].'","'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'","'.$name.'","'.$email.'","'.$address1.'","'.$address2.'","'.$nameOnCard.'","'.$card_num.'","'.$card_exp_month.'","'.$card_exp_year.'","'.date("Y-m-d H:i:s").'","'.$siteId.'")';
    $orderId = query_result($createOrderQuery);
    foreach($Items as $item){
        $insertItemQuery = 'insert into `order_details` (`order_id`,`product_id`,`quantity`,`price`,`total`)values("'.$orderId.'","'.$item['product_id'].'","'.$item['quantity'].'","'.$item['price'].'","'.$item['total_price'].'")';
        $insertResult = query_result($insertItemQuery);
    }
    //item information
    $itemName = "Order Number : ".$orderNumber[0]['number'];
    $itemNumber = $orderNumber[0]['number'];
    $itemPrice = $orderTotal[0]['total'];
    $currency = "usd";
    $orderID = $orderId;
    
    //charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderID
        )
    ));
    
    //retrieve charge details
    $chargeJson = $charge->jsonSerialize();
    //check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
        //order details 
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $date = date("Y-m-d H:i:s");
        

        $updateOrderQuery = 'update `orders` set `paid_amount` = "'.$amount.'",`paid_amount_currency` = "'.$currency.'" ,`txn_id` = "'.$balance_transaction.'" ,`payment_status` = "'.$status.'" ,`modified` = "'.$date.'" where `order_id` = '.$orderID;
        $updateResult = query_result($updateOrderQuery);
        //reset cart
        $sql = "delete from `cart` where `user_id` = ".$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];
        $insert = query_result($sql);            
        if(isset($_POST['save-info'])){
            $updateUserQuery = 'update `users` set `name` = "'.$name.'" , `email` = "'.$email.'" , `address_1` = "'.$address1.'" , `address_2` = "'.$address2.'" , `name_on_card` = "'.$nameOnCard.'" , `card_number` = "'.$card_num.'" , `card_ex_month` = "'.$card_exp_month.'" , `card_ex_year` = "'.$card_exp_year.'" where `id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'"';
            $result = query_result($updateUserQuery);
        }
        query_result('commit');
        //if order inserted successfully
        if($orderId && $status == 'succeeded'){
            $statusMsg = "The transaction was successful";
            $orderNumber ="Order ID: {$itemNumber}";
            $st = 'successful';
        }else{
            $statusMsg = "Transaction has been failed";
            $orderNumber ="";
            $st = 'failed';
        }
    }else{
        $statusMsg = "Transaction has been failed";
        $orderNumber ="";
        $st = 'failed';
    }
}else{
    $statusMsg = "Form submission error.......";
    $orderNumber ="";
    $st = 'failed';
}
//show success or error message
//echo $statusMsg;
?>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1><?php echo $st; ?></h1> 
        <p><?php $statusMsg; ?>;<br/> <?php echo $orderNumber; ?></p>
        <p><a href="/">Redirect To Home Page</a></p>
      </div>      
    </body>
</html>