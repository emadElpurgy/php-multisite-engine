<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(isset($_GET['id']) && $_GET['id'] > 0){
    $getInfoQuery = 'select * from `site_header_slides` where `id` = '.$_GET['id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('id'=>'','site_id'=>'','slide_img_url'=>'','slide_head'=>'','slide_text'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Header Slide</h3></div>
                <div class="card-body">
                    <form action="head_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('slide_img_url',$infoArray); ?>" width="100px">
                            <input class="form-control" name="image" id="image" type="file" placeholder="Header Slide Image"/>
                            <label for="image">Slide Image</label>
                        </div>                    
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slide_head" id="slide_head" type="text" placeholder="Header Slide Header Text" value="<?php EchoInfo('slide_head',$infoArray); ?>"/>
                            <label for="slide_head">Slide Head Text</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slide_text" id="slide_text" type="text" placeholder="Header Slide Text" value="<?php EchoInfo('slide_text',$infoArray); ?>"/>
                            <label for="slide_text">Slide Text</label>
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