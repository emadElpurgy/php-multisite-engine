<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getMessagesQuery = 'select * from `messages` where `site_id` = '.$siteId.' order by `message_date` desc';
$Messages = query_result($getMessagesQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Messages
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Open</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Open</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Messages) > 0){
                            $count = 1;
                            foreach($Messages as $message){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="10%" align="center">'.$message['name'].'</td>
                                    <td class="display-item" width="20%">'.$message['subject'].'</td>
                                    <td class="display-item" width="20%">'.$message['email'].'</td>
                                    <td class="display-item" width="20%">'.$message['message_date'].'</td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($message['new'] == 0){
                                            echo 'New';
                                        }
                                        echo'
                                    </td>
                                    <td class="display-item" width="10%" align="center"><a href="message.php?message_id='.$message['message_id'].'"><img src="img/view.png" width="16px" height="16px" title="Open Message"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="message_pro.php?message_id='.$message['message_id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>                    
                                </tr>';                
                                $count++;
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