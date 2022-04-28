<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
if(isset($_GET['message_id']) && $_GET['message_id'] > 0){
    $getInfoQuery = 'select * from `messages` where `message_id` = '.$_GET['message_id'];
    $getInfoResult = query_result($getInfoQuery);
    if(count($getInfoResult) > 0){
        $infoArray = $getInfoResult[0];
    }
}else{
    $infoArray = array('message_id'=>'','name'=>'','email'=>'','subject'=>'','message'=>'','message_date'=>'');
}
function EchoInfo($attrbuteId,$attrbutesArray){    
    echo $attrbutesArray[$attrbuteId];
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4"><?php EchoInfo('subject',$infoArray); ?></h3></div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input class="form-control" name="From" id="From" type="text" placeholder="" value="<?php EchoInfo('email',$infoArray); ?>" required/>
                        <label for="From">From </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="Sender" id="Sender" type="text" placeholder="" value="<?php EchoInfo('name',$infoArray); ?>" required/>
                        <label for="Sender">Sender </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="Date" id="Date" type="text" placeholder="" value="<?php EchoInfo('message_date',$infoArray); ?>" required/>
                        <label for="Date">Date </label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea id="message" name="message" class="form-control"><?php EchoInfo('message',$infoArray); ?></textarea>
                        <label for="message">message</label>
                    </div>
    <tr>
        <td class="form-input" colspan="2">
            <?php info('message',$infoArray); ?>
        </td>
    </tr>
</table>
                </div>
            </div>
        </div>
    </div>
</div>                    

<?php
    $updateQuery = 'update `messages` set `new` = 1 where `message_id` = '.$_GET['message_id'];
    $updateResult = query_result($updateQuery);
require_once('footer.php');
?>