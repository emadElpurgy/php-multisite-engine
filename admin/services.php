<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getServicesQuery = 'select * from `services` where `site_id` = '.$siteId;
$Services = query_result($getServicesQuery);
?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Services
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Service Name</th>
                        <th>Edit</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Icon</th>
                        <th>Service Name</th>
                        <th>Edit</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publis</th>
                        <th>Feature</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Services) > 0){
                            $count = 1;
                            foreach($Services as $service){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="10%" align="center"><img src="../'.$service['icon'].'" height="50px"></td>
                                    <td class="display-item" width="60%">'.$service['service_name'].'</td>
                                    <td class="display-item" width="10%" align="center"><a href="service.php?service_id='.$service['service_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="../preview.php?service_name='.str_replace(" ","-",strtolower($service['service_name'])).'" target="new"><img src="img/view.png" width="16px" height="16px" title="Preview Service"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="service_pro.php?service_id='.$service['service_id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($service['publish'] == "0"){
                                            echo '<a href="service_pro.php?service_id='.$service['service_id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publish"></a>';
                                        }else{
                                            echo '<a href="service_pro.php?service_id='.$service['service_id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                        echo'
                                    </td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($service['home'] == "0"){
                                            echo '<a href="service_pro.php?service_id='.$service['service_id'].'&action=feature"><img src="img/star.png" width="16px" height="16px" title="Add To Home Page"></a>';
                                        }else{
                                            echo '<a href="service_pro.php?service_id='.$service['service_id'].'&action=unfeature"><img src="img/star2.png" width="16px" height="16px" title="Remove From Home Page"></a>';
                                        }
                                        echo'
                                    </td>                                    
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