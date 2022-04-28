<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(isset($_GET['project_id']) && $_GET['project_id'] > 0){
    $getInfoQuery = 'select * from `projects` where `project_id` = '.$_GET['project_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('project_id'=>'','project_name'=>'','customer_name'=>'','contract_date'=>'','start_date'=>'','end_date'=>'','short_description'=>'','description'=>'','slug'=>'','icon'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">New Project</h3></div>
                <div class="card-body">

                    <form action="project_pro.php?action=save" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="project_name" id="project_name" type="text" placeholder="Project Name" value="<?php EchoInfo('project_name',$infoArray); ?>"  onchange="changeSlug(this.value,'slug');" required/>
                            <label for="project_name">Project Name</label>
                        </div>                    
                        <div class="form-floating mb-3">
                            <input class="form-control" name="customer_name" id="customer_name" type="text" placeholder="Customer Name" value="<?php EchoInfo('customer_name',$infoArray); ?>" required/>
                            <label for="customer_name">Customer Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <img src="../<?php EchoInfo('icon',$infoArray); ?>" width="100px">
                            <input class="form-control" name="icon" id="icon" type="file" placeholder="Project Icon Image"/>
                            <label for="icon">Icon</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="contract_date" id="contract_date" type="date" placeholder="Project Contracting Date" value="<?php EchoInfo('contract_date',$infoArray); ?>" required/>
                            <label for="contract_date">Contract Date</label>
                        </div>                                            
                        <div class="form-floating mb-3">
                            <input class="form-control" name="start_date" id="start_date" type="date" placeholder="Project Start Date" value="<?php EchoInfo('start_date',$infoArray); ?>" required/>
                            <label for="start_date">Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="end_date" id="end_date" type="date" placeholder="Project End Date" value="<?php EchoInfo('end_date',$infoArray); ?>" required/>
                            <label for="end_date">End Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="short_description" id="short_description" type="text" placeholder="Project Short Description Text" value="<?php EchoInfo('short_description',$infoArray); ?>" required/>
                            <label for="short_description">Short Description</label>
                        </div>
                        <div class="form-floating mb-3" style="min-height:300px">
                            <textarea class="form-control" name="description" id="description" placeholder="Project Description Text" rows="10" style="min-height:300px" required><?php EchoInfo('description',$infoArray); ?></textarea>
                            <label for="description">Full Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slug" id="slug" type="text" placeholder="Product Name In Url" value="<?php EchoInfo('slug',$infoArray); ?>" required/>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        <input type="hidden" name="project_id" value="<?php EchoInfo('project_id',$infoArray); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
require_once('footer.php');
?>