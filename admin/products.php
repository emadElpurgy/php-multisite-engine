<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getProductsQuery = 'select * from `products` where `site_id` = '.$siteId;
if(isset($_GET['category_id']) && $_GET['category_id'] > 0){
    $getProductsQuery.=' and `category_id` = '.$_GET['category_id'];
}
$Products = query_result($getProductsQuery);
?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Products
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Product Name</th>
                        <th>Images</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Icon</th>
                        <th>Product Name</th>
                        <th>Images</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Products) > 0){
                            foreach($Products as $product){
                                echo'
                                <tr>
                                    <td align="center"><img src="../'.$product['icon'].'" height="50px"></td>
                                    <td>'.$product['product_name'].'</td>
                                    <td align="center"><a href="product_files.php?product_id='.$product['product_id'].'"><img src="img/file.png" width="16px" height="16px" title="Product Images"></a></td>
                                    <td align="center"><a href="product.php?product_id='.$product['product_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td align="center"><a href="product_pro.php?product_id='.$product['product_id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td align="center">';
                                        if($product['publish'] == "0"){
                                            echo '<a href="product_pro.php?product_id='.$product['product_id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publish"></a>';
                                        }else{
                                            echo '<a href="product_pro.php?product_id='.$product['product_id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                        echo'
                                    </td>
                                    <td align="center">';
                                        if($product['home'] == "0"){
                                            echo '<a href="product_pro.php?product_id='.$product['product_id'].'&action=feature"><img src="img/star.png" width="16px" height="16px" title="Add To Home Page"></a>';
                                        }else{
                                            echo '<a href="product_pro.php?product_id='.$product['product_id'].'&action=unfeature"><img src="img/star2.png" width="16px" height="16px" title="Remove From Home Page"></a>';
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