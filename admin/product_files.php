<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getProductQuery = 'select * from `products` where `product_id` = '.$_GET['product_id'];
$Product = query_result($getProductQuery);
$getProductFilesQuery = 'select * from `product_files` where `product_id` = '.$_GET['product_id'];
$ProductFiles = query_result($getProductFilesQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Product <?php echo $Product[0]['product_name']?> files
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>File Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>File</th>
                        <th>File Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publis</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($ProductFiles) > 0){
                            $count = 1;
                            foreach($ProductFiles as $file){
                                $fileNameParts = explode("/",$file['file_url']);
                                echo'
                                <tr>
                                    <td align="center"><img src="../'.$file['file_url'].'" height="100px"></td>
                                    <td>'.$fileNameParts[(count($fileNameParts) - 1)].'</td>
                                    <td align="center"><a href="Product_file.php?id='.$file['id'].'&product_id='.$_GET['product_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td align="center"><a href="product_file_pro.php?id='.$file['id'].'&action=delete&product_id='.$_GET['product_id'].'"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td align="center">';
                                        if($file['publish'] == "0"){
                                            echo '<a href="product_file_pro.php?product_id='.$_GET['product_id'].'&action=publish&id='.$file['id'].'"><img src="img/publish.png" width="16px" height="16px" title="Publis"></a>';
                                        }else{
                                            echo '<a href="product_file_pro.php?product_id='.$_GET['product_id'].'&action=unpublish&id='.$file['id'].'"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                        echo'
                                    </td>
                                </tr>';                
                                $count++;
                            }
                        }
                    ?>
                </tbody>
            </table>
            <a href="product_file.php?product_id=<?php echo $_GET['product_id']; ?>"><img src="img/new.png" width="30px" height="30px" title="New file"></a>
        </div>
    </div>
</div>
<?php
require_once('footer.php');
?>