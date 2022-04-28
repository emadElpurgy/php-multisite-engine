<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getProjectQuery = 'select * from `projects` where `project_id` = '.$_GET['project_id'];
$Project = query_result($getProjectQuery);
if(isset($_GET['id']) && $_GET['id'] > 0){
    $getInfoQuery = 'select * from `project_files` where `id` = '.$_GET['id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('id'=>'','project_id'=>'','file_url'=>'','short_description'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New project file for project <?php echo $Project[0]['project_name']?></h3></div>
                <div class="card-body">

                    <form action="project_file_pro.php?action=insert&project_id=<?php echo $_GET['project_id']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('file_url',$infoArray); ?>" width="100px">
                            <input class="form-control" name="file" id="file" type="file" placeholder="File"/>
                            <label for="file">File</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="short_description" id="short_description" type="text" placeholder="file Short Description Text" value="<?php EchoInfo('short_description',$infoArray); ?>" required/>
                            <label for="short_description">Short Description</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
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