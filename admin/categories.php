<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getCategoriesQuery = 'select * from `categories` where `site_id` = '.$siteId;
if(isset($_GET['category_id']) && $_GET['category_id'] > 0){
    $getCategoriesQuery.=' and main_category = '.$_GET['category_id'];
}
$Categories = query_result($getCategoriesQuery);
?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Product Categories
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Icon</th>
                        <th>Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Categories) > 0){
                            foreach($Categories as $category){
                                echo'
                                <tr>
                                    <td align="center"><img src="../'.$category['icon'].'" height="50px"></td>
                                    <td>';
                                        $checkSubCategoriesQuery = 'select * from `categories` where `main_category` = '.$category['category_id'].' limit 1';
                                        $checkSubCategoriesResult = query_result($checkSubCategoriesQuery);
                                        if(count($checkSubCategoriesResult) > 0){
                                            echo '<a href="categories.php?category_id='.$category['category_id'].'">'.$category['category_name'].'</a>';
                                        }else{
                                            $checkProductsQuery = 'select * from `products` where `category_id` = '.$category['category_id'];
                                            $checkProductsResult = query_result($checkProductsQuery);
                                            if(count($checkProductsResult) > 0){
                                                echo '<a href="products.php?category_id='.$category['category_id'].'">'.$category['category_name'].'</a>';
                                            }else{
                                                echo $category['category_name'];
                                            }
                                        }
                                        echo'
                                    </td>
                                    <td align="center"><a href="category.php?category_id='.$category['category_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td align="center"><a href="category_pro.php?category_id='.$category['category_id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td align="center">';
                                        if($category['publish'] == "0"){
                                            echo '<a href="category_pro.php?category_id='.$category['category_id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publish"></a>';
                                        }else{
                                            echo '<a href="category_pro.php?category_id='.$category['category_id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                        echo'
                                    </td>
                                    <td align="center">';
                                        if($category['home'] == "0"){
                                            echo '<a href="category_pro.php?category_id='.$category['category_id'].'&action=feature"><img src="img/star.png" width="16px" height="16px" title="Add To Home Page"></a>';
                                        }else{
                                            echo '<a href="category_pro.php?category_id='.$category['category_id'].'&action=unfeature"><img src="img/star2.png" width="16px" height="16px" title="Remove From Home Page"></a>';
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