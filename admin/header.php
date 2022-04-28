<?php
    $connectionDetails = require_once ("../config.php");
    require_once ("../db.php");
    if(!isset($_SESSION['kjdfsd@98u9mfi9_98j32d-dkofj948r']) || $_SESSION['kjdfsd@98u9mfi9_98j32d-dkofj948r'] == ""){
        header("Location: login.html");
    }
    $getSiteQuery = 'select * from sites where site_name = "'.$_SERVER['HTTP_HOST'].'"';
    $getSiteResult = query_result($getSiteQuery);
    $siteId = $getSiteResult[0]['site_id'];
	$getInfoQuery = '
	select 
		`attributes`.`attribute_name`,
		`site_attributes`.`attribute_value`
	from 
		`site_attributes` 
		inner join `attributes` on(`attributes`.`attribute_id` = `site_attributes`.`attribute_id`)
	where 
		`site_attributes`.`site_id` = '.$siteId;
	$getInfoResult = query_result($getInfoQuery);
	$siteInfoArray = array();
	if(count($getInfoResult) > 0){
		foreach($getInfoResult as $value){	
			$siteInfoArray[strtolower(str_replace(" ","_",$value['attribute_name']))] = $value['attribute_value'];
		}
	}
	function info($attrbuteName){
		global $siteInfoArray;
		if(isset($siteInfoArray[$attrbuteName])){
			echo $siteInfoArray[$attrbuteName];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="/index.php"><?php info('website_name'); ?></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Site Settings</div>
                            <a class="nav-link" href="info.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Site Information
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Site Intro
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="intros.php">Intro Slides</a>
                                    <a class="nav-link" href="intro.php">New Intro Slide</a>
                                    <a class="nav-link" href="../intro_preview.php" target="new">Preview Intro</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseHeader" aria-expanded="false" aria-controls="collapseHeader">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Site Header
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseHeader" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="headers.php">Header Slides</a>
                                    <a class="nav-link" href="head.php">New Header Slide</a>
                                    <a class="nav-link" href="../header_preview.php" target="new">Preview Header</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServices" aria-expanded="false" aria-controls="collapseServices">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Services
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseServices" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="services.php">Services</a>
                                    <a class="nav-link" href="service.php">New Service</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProjects" aria-expanded="false" aria-controls="collapseProjects">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Projects
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProjects" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Projects.php">Projects</a>
                                    <a class="nav-link" href="project.php">New Project</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="pages.php">Pages</a>
                                    <a class="nav-link" href="page.php">New Page</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Products
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="categories.php">Categories</a>
                                    <a class="nav-link" href="category.php">New Category</a>
                                    <a class="nav-link" href="products.php">Products</a>
                                    <a class="nav-link" href="product.php">New Product</a>
                                    <a class="nav-link" href="orders.php">Orders</a>
                                </nav>
                            </div>



                            <a class="nav-link" href="messages.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Messages
                            </a>
                            <a class="nav-link" href="users.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Users
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['dccKLDIyu@SdJI-sdfsdf9_si9dfuuj']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">