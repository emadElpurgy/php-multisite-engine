<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getAllCategoriesQuery = 'select * from `categories` where `category_id` not in(select `category_id` from `products`)';
$Categories = query_result($getAllCategoriesQuery);

function createCategoriesList($categoryId,$optionsHtml,$level,$selected){
    $getAllCategoriesQuery = 'select * from `categories` where `category_id` not in(select `category_id` from `products`) and `main_category` = '.$categoryId;
    $Categories = query_result($getAllCategoriesQuery);
    for($x = 0; $x < $level; $x++){
        $formater.= '&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    if(count($Categories) > 0){
        foreach($Categories as $category){
            $optionsHtml.='<option value="'.$category['category_id'].'" ';
            if($selected == $category['category_id']){
                $optionsHtml.=' selected ';
            }
            $optionsHtml.='>'.$formater.$category['category_name'].'</option>';
            $checkSubCategoriesQuery = 'select * from `categories` where `category_id` not in(select `category_id` from `products`) and `main_category` = '.$category['category_id'].' limit 1';
            $SubCategories = query_result($checkSubCategoriesQuery);
            if(count($SubCategories) > 0){
                $optionsHtml = createCategoriesList($category['category_id'],$optionsHtml,($level+1),$selected);       
            }
        }
    }
    return $optionsHtml;
}

if(isset($_GET['category_id']) && $_GET['category_id'] > 0){
    $getInfoQuery = 'select * from `categories` where `category_id` = '.$_GET['category_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('category_id'=>'','category_name'=>'','short_description'=>'','description'=>'','slug'=>'','site_id'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Product Category</h3></div>
                <div class="card-body">
                    <form action="category_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="category_name" id="category_name" type="text" placeholder="Product Category Name" value="<?php EchoInfo('category_name',$infoArray); ?>"  onchange="changeSlug(this.value,'slug');" required/>
                            <label for="category_name">Category Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('icon',$infoArray); ?>" width="50px">
                            <input class="form-control" name="icon" id="icon" type="file" placeholder="Category Icon" value="<?php EchoInfo('icon',$infoArray); ?>"/>
                            <label for="icon">Icon</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" name="main_category" id="main_category" placeholder="Parent Category">
                                <option value="0">Main Category</option>
                                <?php
                                    // foreach($Categories as $category){
                                    //     echo '<option value="'.$category['category_id'].'"';
                                    //     if($category['category_id'] == $infoArray['main_category']){
                                    //         echo ' selected ';
                                    //     }
                                    //     echo '>'.$category['category_name'].'</option>';
                                    // }
                                    echo createCategoriesList(0,'',0,$infoArray['main_category']);
                                ?>
                            </select>
                            <label for="main_category">Main Category</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="short_description" id="short_description" type="text" placeholder="Service Short Description Text" value="<?php EchoInfo('short_description',$infoArray); ?>" required/>
                            <label for="short_description">Short Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" id="description" placeholder="Service Description Text" required><?php EchoInfo('description',$infoArray); ?></textarea>
                            <label for="description">Full Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slug" id="slug" type="text" placeholder="Product Name In Url" value="<?php EchoInfo('slug',$infoArray); ?>" required/>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="category_id" value="<?php EchoInfo('category_id',$infoArray); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
require_once('footer.php');
?>