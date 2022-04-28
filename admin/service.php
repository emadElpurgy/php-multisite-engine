<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(isset($_GET['service_id']) && $_GET['service_id'] > 0){
    $getInfoQuery = 'select * from `services` where `service_id` = '.$_GET['service_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('service_id'=>'','service_name'=>'','short_description'=>'','description'=>'','slug'=>'','site_id'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Service</h3></div>
                <div class="card-body">
                    <form action="service_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="service_name" id="service_name" type="text" placeholder="Service Name" value="<?php EchoInfo('service_name',$infoArray); ?>"  onchange="changeSlug(this.value,'slug');" required/>
                            <label for="service_name">Service Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('icon',$infoArray); ?>" width="50px">
                            <input class="form-control" name="icon" id="icon" type="file" placeholder="Service Icon" value="<?php EchoInfo('icon',$infoArray); ?>"/>
                            <label for="icon">Icon</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="short_description" id="short_description" type="text" placeholder="Service Short Description Text" value="<?php EchoInfo('short_description',$infoArray); ?>" required/>
                            <label for="short_description">Short Description</label>
                        </div>
                        <div class="form-floating mb-3" syle="min-height:300px">
                            <textarea class="form-control" name="description" id="description" placeholder="Service Description Text" rows="10" style="min-height:300px" required><?php EchoInfo('description',$infoArray); ?></textarea>
                            <label for="description" >Full Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slug" id="slug" type="text" placeholder="Product Name In Url" value="<?php EchoInfo('slug',$infoArray); ?>" required/>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="service_id" value="<?php EchoInfo('service_id',$infoArray); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
require_once('footer.php');
?>