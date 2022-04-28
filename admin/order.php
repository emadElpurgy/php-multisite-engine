<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(isset($_GET['order_id']) && $_GET['order_id'] > 0){
    $getInfoQuery = 'select * from `orders` where `order_id` = '.$_GET['order_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
    $getOrderItemsQuery = '
    select 
        `products`.`product_name`,
        `order_details`.`quantity`,
        `order_details`.`price`,
        `order_details`.`total`
    from 
        `orders`
        inner join `order_details` on(`order_details`.`order_id` = `orders`.`order_id`)
        inner join `products` on(`products`.`product_id` = `order_details`.`product_id`)
    where 
        `orders`.`order_id` = '.$_GET['order_id'];
    $OrderItems = query_result($getOrderItemsQuery);
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<style>
.orderTable tr td{
    border:1px solid #000000;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Order Number <?php EchoInfo('order_number',$infoArray); ?></h3></div>
                <div class="card-body">
                    <table width="100%"  cellspacing="0px" cellpadding="0px" class="orderTable">
                        <tr>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Customer Name</td>
                            <td width="25%"><?php EchoInfo('name',$infoArray); ?></td>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Customer Email</td>
                            <td width="25%" align="center" style="background-color:#EAEAEA;"><?php EchoInfo('email',$infoArray); ?></td>
                        </tr>
                        <tr>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Order Date</td>
                            <td width="25%"><?php EchoInfo('order_date',$infoArray); ?></td>
                            <td width="50%" colspan="2"></td>
                        </tr>
                        <tr>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Address Line 1</td>
                            <td  width="75%" colspan="3"><?php EchoInfo('address1',$infoArray); ?></td>
                        </tr>
                        <tr>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Address Line 2</td>
                            <td colspan="3" width="75%"><?php EchoInfo('address2',$infoArray); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center" width="100%" align="center" style="background-color:#EAEAEA;">
                                Order Items
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center" width="100%">
                                <table width="100%" cellspacing="0px" cellpadding="0px">
                                    <tr>
                                        <td width="50%" style="background-color:#EAEAEA;" align="center">Item Name</td>
                                        <td width="20%" style="background-color:#EAEAEA;" align="center">Item Price</td>
                                        <td width="10%" style="background-color:#EAEAEA;" align="center">Quantity</td>
                                        <td width="20%" style="background-color:#EAEAEA;" align="center">Total Price</td>
                                    </tr>
                                    <?php
                                        $total = 0;
                                        foreach($OrderItems as $item){
                                            echo '
                                            <tr>
                                                <td width="50%">'.$item['product_name'].'</td>
                                                <td width="20%" align="center">'.$item['price'].'</td>
                                                <td width="10%" align="center">'.$item['quantity'].'</td>
                                                <td width="20%" align="center">'.$item['total'].'</td>
                                            </tr>';                                            
                                            $total = ($total + $item['total']);
                                        }
                                    ?>
                                    <tr>
                                        <td width="80%" colspan="3" align="right">Total</td>
                                        <td width="20%" style="background-color:#EAEAEA;" align="center"><?php echo $total; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Paid Amount</td>
                            <td width="25%" align="center"><?php EchoInfo('paid_amount',$infoArray); ?></td>
                            <td width="25%" align="center" style="background-color:#EAEAEA;">Card Number</td>
                            <td width="25%" align="center"><?php EchoInfo('cc_number',$infoArray); ?></td>
                        </tr>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
require_once('footer.php');
?>