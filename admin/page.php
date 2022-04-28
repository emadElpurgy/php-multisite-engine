<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getAllPagesQuery = '
select
    `pages`.`id`,
    `pages`.`page_name`
from 
    `pages`
where 
    `pages`.`site_id` = '.$siteId;
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $getAllPagesQuery.='
        and 
        `pages`.`id` <> '.$_GET['id'];
    }
$Pages = query_result($getAllPagesQuery);
$getPluginsQuery = 'select * from `plugins` where `plugin_id` > 0';
$Plugins = query_result($getPluginsQuery);
if(isset($_GET['id']) && $_GET['id'] > 0){
    $getInfoQuery = 'select * from `pages` where `id` = '.$_GET['id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('id'=>'','page_name'=>'','page_of'=>'','page_body'=>'','plugin_id'=>'','slug'=>'','site_id'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<script src="ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Page</h3></div>
                <div class="card-body">

                    <form action="page_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="page_name" id="page_name" type="text" placeholder="Page Name" value="<?php EchoInfo('page_name',$infoArray); ?>" onchange="changeSlug(this.value,'slug');" required/>
                            <label for="page_name">Page Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" name="page_of" id="page_of" placeholder="Parent Page">
                                <option value="0">Main Page</option>
                                <?php
                                    foreach($Pages as $page){
                                        echo '<option value="'.$page['id'].'"';
                                        if($page['id'] == $infoArray['page_of']){
                                            echo ' selected ';
                                        }
                                        echo '>'.$page['page_name'].'</option>';
                                    }
                                ?>
                            </select>
                            <label for="page_of">Main Page</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" name="plugin_id" id="plugin_id" placeholder="Page Type">
                                <option value="0">Normal Page</option>
                                <?php
                                    foreach($Plugins as $plugin){
                                        echo '<option value="'.$plugin['plugin_id'].'"';
                                        if($plugin['plugin_id'] == $infoArray['plugin_id']){
                                            echo ' selected ';
                                        }
                                        echo '>'.$plugin['plugin_name'].'</option>';
                                    }                                ?>
                            </select>
                            <label for="plugin_id">Page Plugin</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="page_body" id="page_body" placeholder="Page Contents" required><?php EchoInfo('page_body',$infoArray); ?></textarea>
                            <label for="page_body">Page Body</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slug" id="slug" type="text" placeholder="Product Name In Url" value="<?php EchoInfo('slug',$infoArray); ?>" required/>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="id" value="<?php EchoInfo('id',$infoArray); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'page_body' );

    // ClassicEditor
    //     .create( document.querySelector( '#page_body',
    //     {
    //         extraPlugins : ['btgrid']
    //     } ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );
</script>
<?php
require_once('footer.php');
?>