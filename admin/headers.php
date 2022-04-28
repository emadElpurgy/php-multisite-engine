<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getSliesQuery = 'select * from `site_header_slides` where `site_id` = '.$siteId;
$Slides = query_result($getSliesQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Site Header Slides
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Slide Image</th>
                        <th>Slide Head</th>
                        <th>Edit</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publis</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Slide Image</th>
                        <th>Slide Head</th>
                        <th>Slide Text</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publis</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Slides) > 0){
                            $count = 1;
                            foreach($Slides as $slide){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="30%" align="center"><img src="../'.$slide['slide_img_url'].'" height="100px"></td>
                                    <td class="display-item" width="20%">'.$slide['slide_head'].'</td>
                                    <td class="display-item" width="10%" align="center"><a href="head.php?id='.$slide['id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="../header_preview.php?id='.$slide['id'].'" target="new"><img src="img/view.png" width="16px" height="16px" title="Preview"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="head_pro.php?id='.$slide['id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($slide['publish'] == "0"){
                                            echo '<a href="head_pro.php?id='.$slide['id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publis"></a>';
                                        }else{
                                            echo '<a href="head_pro.php?id='.$slide['id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
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