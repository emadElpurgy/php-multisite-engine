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

if(isset($_GET['id']) && $_GET['id'] > 0){
    $getInfoQuery = 'select * from `site_intro_slides` where `id` = '.$_GET['id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('id'=>'','site_id'=>'','intro_img_url'=>'','intro_head'=>'','intro_text'=>'','intro_link'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Intro Slide</h3></div>
                <div class="card-body">
                    <form action="intro_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('intro_img_url',$infoArray); ?>" width="100px">
                            <input class="form-control" name="image" id="image" type="file" placeholder="Intro Slide Image"/>
                            <label for="image">Slide Image</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="intro_head" id="intro_head" type="text" placeholder="Intro Slide Header Text" value="<?php EchoInfo('intro_head',$infoArray); ?>"/>
                            <label for="intro_head">Slide Head Text</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="intro_text" id="intro_text" type="text" placeholder="Intro Slide Text" value="<?php EchoInfo('intro_text',$infoArray); ?>"/>
                            <label for="intro_text">Slide Text</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" name="intro_link" id="intro_link" placeholder="Intro Slide Page Link" value="<?php EchoInfo('intro_link',$infoArray); ?>"/>
                                <?php
                                    foreach($Pages as $page){
                                        echo '<option value="'.$page['id'].'"';
                                        if($page['id'] == $infoArray['intro_link']){
                                            echo ' selected ';
                                        }
                                        echo '>'.$page['page_name'].'</option>';
                                    }
                                ?>
                            </select>
                            <label for="intro_link">Slide Link</label>
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
<?php
require_once('footer.php');
?>