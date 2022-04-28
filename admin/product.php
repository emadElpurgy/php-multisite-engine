<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];

function createCategoriesList($categoryId,$optionsHtml,$level,$selected){
    $getAllCategoriesQuery = 'select * from `categories` where `main_category` = '.$categoryId;
    $Categories = query_result($getAllCategoriesQuery);
    $formater = '';
    for($x = 0; $x < $level; $x++){
        $formater.= '&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    if(count($Categories) > 0){
        foreach($Categories as $category){
            $checkSubCategoriesQuery = 'select * from `categories` where `main_category` = '.$category['category_id'].' limit 1';
            $SubCategories = query_result($checkSubCategoriesQuery);
            $optionsHtml.='<option value="'.$category['category_id'].'" ';
            if($selected == $category['category_id']){
                $optionsHtml.=' selected ';
            }
            if(count($SubCategories) > 0){
                $optionsHtml.=' disabled ';
            }
            $optionsHtml.='>'.$formater.$category['category_name'].'</option>';
            if(count($SubCategories) > 0){
                $optionsHtml = createCategoriesList($category['category_id'],$optionsHtml,($level+1),$selected);       
            }
        }
    }
    return $optionsHtml;
}

if(isset($_GET['product_id']) && $_GET['product_id'] > 0){
    $getInfoQuery = 'select * from `products` where `product_id` = '.$_GET['product_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('product_id'=>'','product_name'=>'','short_description'=>'','description'=>'','price'=>'','slug'=>'','site_id'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Product</h3></div>
                <div class="card-body">
                    <form action="product_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="product_name" id="product_name" type="text" placeholder="Product Name" value="<?php EchoInfo('product_name',$infoArray); ?>" onchange="changeSlug(this.value,'slug');" required/>
                            <label for="product_name">Product Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('icon',$infoArray); ?>" width="50px">
                            <input class="form-control" name="icon" id="icon" type="file" placeholder="Product Icon" value=""/>
                            <label for="icon">Icon</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" name="category_id" id="category_id" placeholder="Product Category">
                                <option value="0">Select Category</option>
                                <?php
                                    echo createCategoriesList(0,'',0,$infoArray['category_id']);
                                ?>
                            </select>
                            <label for="category_id">Category</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="short_description" id="short_description" type="text" placeholder="Product Short Description Text" value="<?php EchoInfo('short_description',$infoArray); ?>" required/>
                            <label for="short_description">Short Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" id="description" placeholder="Product Description Text" required><?php EchoInfo('description',$infoArray); ?></textarea>
                            <label for="description">Full Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="price" id="price" type="number" placeholder="Product Price" value="<?php EchoInfo('price',$infoArray); ?>" required/>
                            <label for="price">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slug" id="slug" type="text" placeholder="Product Name In Url" value="<?php EchoInfo('slug',$infoArray); ?>" required/>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="product_id" value="<?php EchoInfo('product_id',$infoArray); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
require_once('footer.php');
?>