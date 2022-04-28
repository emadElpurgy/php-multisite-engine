<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getUsersQuery = 'select * from `users` where `site_id` = '.$siteId.' order by `name` desc';
$Users = query_result($getUsersQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Users
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Last Login</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Last Login</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Users) > 0){
                            $count = 1;
                            foreach($Users as $user){
                                echo'
                                <tr>
                                    <td >'.$user['name'].'</td>
                                    <td >'.$user['email'].'</td>
                                    <td >';
                                        if($user['email_verified'] == "1"){
                                            echo 'Yes';
                                        }else{
                                            echo 'No';
                                        }
                                    echo '</td>
                                    <td >'.$user['last_login'].'</td>
                                    <td align="center"><a href="user_pro.php?id='.$user['id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>                    
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