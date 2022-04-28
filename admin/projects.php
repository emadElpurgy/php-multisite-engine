<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getProjectsQuery = 'select * from `projects` where `site_id` = '.$siteId;
$Projects = query_result($getProjectsQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Projects
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Project Name</th>
                        <th>Edit</th>
                        <th>Files</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publis</th>
                        <th>Feature</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Icon</th>
                        <th>Project Name</th>
                        <th>Edit</th>
                        <th>Files</th>
                        <th>Preview</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Feature</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($Projects) > 0){
                            $count = 1;
                            foreach($Projects as $project){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="10%" align="center"><img src="../'.$project['icon'].'" height="50px"></td>
                                    <td class="display-item" width="32%">'.$project['project_name'].'</td>
                                    <td class="display-item" width="7%" align="center"><a href="project.php?project_id='.$project['project_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td class="display-item" width="7%" align="center"><a href="project_files.php?project_id='.$project['project_id'].'"><img src="img/file.png" width="16px" height="16px" title="Project Files"></a></td>
                                    <td class="display-item" width="7%" align="center"><a href="../preview.php?project_name='.str_replace(" ","-",strtolower($project['project_name'])).'" target="new"><img src="img/view.png" width="16px" height="16px" title="Preview Project"></a></td>
                                    <td class="display-item" width="7%" align="center"><a href="project_pro.php?project_id='.$project['project_id'].'&action=delete"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td class="display-item" width="7%" align="center">';
                                        if($project['publish'] == "0"){
                                            echo '<a href="project_pro.php?project_id='.$project['project_id'].'&action=publish"><img src="img/publish.png" width="16px" height="16px" title="Publis"></a>';
                                        }else{
                                            echo '<a href="project_pro.php?project_id='.$project['project_id'].'&action=unpublish"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
                                        }
                                    echo'
                                    </td>
                                    <td class="display-item" width="7%" align="center">';
                                        if($project['home'] == "0"){
                                            echo '<a href="project_pro.php?project_id='.$project['project_id'].'&action=feature"><img src="img/star.png" width="16px" height="16px" title="Add To Home Page"></a>';
                                        }else{
                                            echo '<a href="project_pro.php?project_id='.$project['project_id'].'&action=unfeature"><img src="img/star2.png" width="16px" height="16px" title="Remove From Home Page"></a>';
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