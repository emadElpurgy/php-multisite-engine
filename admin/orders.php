<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getOrdersQuery = 'select * from `orders` where `site_id` = '.$siteId.' order by `status` ,`order_date` desc';
$Orders = query_result($getOrdersQuery);
?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Orders
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Order Number</th>
                        <th>Email</th>
                        <th>Order Date</th>
                        <th>Total</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Orders) > 0){
                            foreach($Orders as $order){
                                echo'
                                <tr>
                                    <td class="display-item"  align="center"><a href="order.php?order_id='.$order['order_id'].'">'.$order['order_number'].'</a></td>
                                    <td class="display-item" >'.$order['email'].'</td>
                                    <td class="display-item"  align="center">'.$order['order_date'].'</td>
                                    <td class="display-item"  align="center">$'.$order['total_price'].'</td>
                                    <td class="display-item"  align="center">';
                                        if($order['status'] == "0"){
                                            echo 'Under Shipping';
                                        }elseif($order['status'] == "1"){
                                            echo 'Shipped';
                                        }elseif($order['status'] == "2"){
                                            echo 'Arrived';
                                        }elseif($order['status'] == "3"){
                                            echo 'Canceled';
                                        }
                                        echo'
                                    </td>
                                    <td class="display-item"  align="center">';
                                        if($order['status'] == "0"){
                                            echo '<a href="order_pro.php?order_id='.$order['order_id'].'&action=setShipped"><i class="fas fa-truck me-1" title="Mark As Shipped"></i></a>';
                                        }
                                        echo' ';
                                        if($order['status'] != "3" && $order['status'] != "2"){
                                            echo '<a href="order_pro.php?order_id='.$order['order_id'].'&action=setCanceled"><i class="fas fa-undo me-1" title="Mark As Canceled"></i></a>';
                                        }
                                        echo'
                                    </td>                                    
                                </tr>';                
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require_once('footer.php');
?>