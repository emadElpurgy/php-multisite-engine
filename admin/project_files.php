<?php
require_once('header.php');
$getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
$getSiteResult = query_result($getSiteQuery);
$siteId = $getSiteResult[0]['site_id'];
$getProjectQuery = 'select * from `projects` where `project_id` = '.$_GET['project_id'];
$Project = query_result($getProjectQuery);
$getProjectFilesQuery = 'select * from `project_files` where `project_id` = '.$_GET['project_id'];
$ProjectFiles = query_result($getProjectFilesQuery);
?>
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Project <?php echo $Project[0]['project_name']?> files
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>File Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publis</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>File</th>
                        <th>File Name</th>
                        <th>Edit</th>
                        <th>Files</th>
                        <th>Delete</th>
                        <th>Publis</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        if(count($ProjectFiles) > 0){
                            $count = 1;
                            foreach($ProjectFiles as $file){
                                if(($count % 2) > 0){
                                    $class="display-row2";
                                }else{
                                    $class="display-row1";
                                }
                                $fileNameParts = explode("/",$file['file_url']);
                                echo'
                                <tr class="'.$class.'">
                                    <td class="display-item" width="40%" align="center"><img src="../'.$file['file_url'].'" height="100px"></td>
                                    <td class="display-item" width="30%">'.$fileNameParts[(count($fileNameParts) - 1)].'</td>
                                    <td class="display-item" width="7%" align="center"><a href="project_file.php?id='.$file['id'].'&project_id='.$_GET['project_id'].'"><img src="img/edit.gif" width="16px" height="16px" title="Edit"></a></td>
                                    <td class="display-item" width="10%" align="center"><a href="project_file_pro.php?id='.$file['id'].'&action=delete&project_id='.$_GET['project_id'].'"><img src="img/delete.gif" width="16px" height="16px" title="Delete"></a></td>
                                    <td class="display-item" width="7%" align="center">';
                                        if($file['publish'] == "0"){
                                            echo '<a href="project_file_pro.php?project_id='.$_GET['project_id'].'&action=publish&id='.$file['id'].'"><img src="img/publish.png" width="16px" height="16px" title="Publis"></a>';
                                        }else{
                                            echo '<a href="project_file_pro.php?project_id='.$_GET['project_id'].'&action=unpublish&id='.$file['id'].'"><img src="img/unpublish.png" width="16px" height="16px" title="Suspend"></a>';
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
            <a href="project_file.php?project_id=<?php echo $_GET['project_id']; ?>"><img src="img/new.png" width="30px" height="30px" title="New file"></a>
        </div>
    </div>
</div>
<?php
require_once('footer.php');
?>