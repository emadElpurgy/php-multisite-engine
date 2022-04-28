<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getPagesQuery = '
select
    `pages`.`id`,
    `pages`.`page_name`,
    `pages`.`home`,
    `pages2`.`page_name` as "main_page",
    `pages`.`publish`
from 
    `pages`
    left join `pages` `pages2` on(`pages2`.`id` = `pages`.`page_of`)
where 
    `pages`.`site_id` = '.$siteId;
$Pages = query_result($getPagesQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Site Pages
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Page Name</th>
                        <th>Page Of</th>
                        <th>Edit</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Page Name</th>
                        <th>Page Of</th>
                        <th>Edit</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Pages) > 0){
                            $count = 1;
                            foreach($Pages as $page){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="50%">'.$page['page_name'].'</td>
                                    <td class="display-item" width="20%">'.$page['main_page'].'</td>
                                    <td class="display-item" width="10%" align="center"><a href="page.php?id='.$page['id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="../preview.php?page_id='.$page['id'].'" target="new"><img src="img/view.png" width="16px" height="16px" title="Preview Page"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="page_pro.php?id='.$page['id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($page['publish'] == "0"){
                                            echo '<a href="page_pro.php?id='.$page['id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publis"></a>';
                                        }else{
                                            echo '<a href="page_pro.php?id='.$page['id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                    echo'
                                    </td>
                                    <td class="display-item" width="10%" align="center">';
                                        if($page['home'] == "0"){
                                            echo '<a href="page_pro.php?id='.$page['id'].'&action=feature"><img src="img/star.png" width="16px" height="16px" title="Add To Home Page"></a>';
                                        }else{
                                            echo '<a href="page_pro.php?id='.$page['id'].'&action=unfeature"><img src="img/star2.png" width="16px" height="16px" title="Remove From Home"></a>';
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