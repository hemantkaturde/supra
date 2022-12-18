<!DOCTYPE html>
<html>
<?php  
 $pageUrl =$this->uri->segment(1);
?>
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- Datatables style -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <style>
    .error {
        color: red;
        font-weight: normal;
    }
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <b>Admin</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <b>Admin</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-history"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"> Last Entry :
                                    <i class="fa fa-clock-o"></i>
                                    <?= empty($last_login) ? "First Login" : $last_login; ?>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image"
                                    alt="User Image" />
                                <span class="hidden-xs">
                                    <?php echo $name; ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle"
                                        alt="User Image" />
                                    <p>
                                        <?php echo $name; ?>
                                        <small>
                                            <?php echo $role_text; ?>
                                        </small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url(); ?>userEdit" class="btn btn-default btn-flat">
                                            <i class="fa fa-key"></i> Account settings</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">
                                            <i class="fa fa-sign-out"></i>Log out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">
                    </li>
                    <li class="treeview">
                        <a href="<?php echo base_url(); ?>dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span class="menu_label">Dashboard</span>
                            </i>
                        </a>
                    </li>
                    <?php
            // Rol definetion in application/config/constants.php
            if($role == ROLE_ADMIN || $role == ROLE_MANAGER)
            {
            ?>
                    <!-- <li class="treeview">
                        <a href="<?php echo base_url(); ?>tasks">
                            <i class="fa fa-tasks"></i>
                            <span>Tasks</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?php echo base_url(); ?>addNewTask">
                            <i class="fa fa-plus-circle"></i>
                            <span>Add Task</span>
                        </a>
                    </li> -->
                    <?php
            }
            if($role == ROLE_ADMIN)
            {
            ?>

                    <li class="treeview <?php if($pageUrl=="companymaster"){echo 'active';}?>" >
                      <a href="<?php echo base_url(); ?>companymaster">
                        <i class="fa fa-building-o"></i> <span class="menu_label">Company Info</span>
                      </a>
                    </li> 

                    <li class="treeview <?php if($pageUrl=="suppliermaster" || $pageUrl=="addnewSupplier" || $pageUrl=='updateSupplier' || $pageUrl=='rowmaterialmaster' || $pageUrl=='addnewmaterialdata' || $pageUrl=='updateRawmaterial' || $pageUrl=="vendormaster" || $pageUrl=='addnewVendor' || $pageUrl=='updateVendor' || $pageUrl=="uspmaster"){echo 'active';}?>">
                      <a href="#">
                        <i class="fa fa-bars"></i> <span class="menu_label">Masters</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height <?php if($pageUrl=="suppliermaster" || $pageUrl=="addnewSupplier" || $pageUrl=='updateSupplier'){echo 'active';}?>"><a href="<?php echo base_url();?>suppliermaster"><i class="fa fa-cubes"></i> Supplier Master</a></li>
                        <li class="line_height <?php if($pageUrl=="rowmaterialmaster" || $pageUrl=='addnewmaterialdata' || $pageUrl=='updateRawmaterial'){echo 'active';}?>"><a href="<?php echo base_url(); ?>rowmaterialmaster"><i class="fa fa-cubes"></i> Raw Material Master</a></li>
                        <li class="line_height <?php if($pageUrl=="vendormaster" || $pageUrl=='addnewVendor' || $pageUrl=='updateVendor'){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendormaster"><i class="fa fa-cubes"></i> Vendor Master</a></li>
                        <li class="line_height <?php if($pageUrl=="uspmaster"){echo 'active';}?>"><a href="<?php echo base_url();?>uspmaster"><i class="fa fa-cubes"></i> USP Master</a></li>
                        <li class="line_height"><a href="#"><i class="fa fa-cubes"></i> Finished Goods</a></li>
                        <li class="line_height"><a href="#"><i class="fa fa-cubes"></i> Platting Master</a></li>
                        <li class="line_height"><a href="#"><i class="fa fa-cubes"></i> Rejection Reason Master</a></li>
                        <li class="line_height"><a href="#"><i class="fa fa-cubes"></i> Buyer Master</a></li>
                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-file-text-o"></i> <span class="menu_label">Challans</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history"><i class="fa fa-cubes"></i> Job Work</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-upload"><i class="fa fa-cubes"></i> Rework / Rejection Return</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Common Challan</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Scrap Return</a></li>

                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-laptop"></i> <span class="menu_label">Miscellaneous</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history"><i class="fa fa-cubes"></i> Purchase Order</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-upload"><i class="fa fa-cubes"></i> Bill of Material</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Bill of Material 2</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Vendor Bill of Material</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Current Order Status</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Debit Note</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> POD</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> Payment Details</a></li>
                        <li class="line_height"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-cubes"></i> PO Confirmation</a></li>
                      </ul>
                    </li>

              
                    <li class="treeview <?php if($pageUrl=="userListing" || $pageUrl=="addNew" || $pageUrl=="editOld"){echo 'active';}?>">
                        <a href="#">
                            <i class="fa fa-users "></i>
                               <span class="menu_label"> Users</span> 
                               <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                        </a>
                        <ul class="treeview-menu" >
                           <li class="line_height <?php if($pageUrl=="userListing" || $pageUrl=="addNew" || $pageUrl=="editOld"){echo 'active';}?>"><a href="<?php echo base_url(); ?>userListing"><i class="fa fa-user"></i> User</a></li>
                           <!-- <li class="line_height"><a href="<?php echo base_url(); ?>addNew"><i class="fa fa-archive"></i> Add User</a></li> -->
                        </ul>
                    </li>


                    <li class="treeview <?php if($pageUrl=="log-history" || $pageUrl=="log-history-upload" || $pageUrl=="log-history-backup"){echo 'active';}?>">
                        <a href="#">
                            <i class="fa fa-archive"></i>
                            <span class="menu_label">Log Records</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                        </a>

                        <ul class="treeview-menu" >
                            <li class="line_height <?php if($pageUrl=="log-history"){echo 'active';}?>"><a href="<?php echo base_url(); ?>log-history"><i class="fa fa-archive"></i> Log Records</a></li>
                            <li class="line_height <?php if($pageUrl=="log-history-upload"){echo 'active';}?>"><a href="<?php echo base_url(); ?>log-history-upload"><i class="fa fa-upload"></i> Upload Backup</a></li>
                            <li class="line_height <?php if($pageUrl=="log-history-backup"){echo 'active';}?>"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-archive"></i> Log Records Backup</a></li>
                        </ul>
                    </li>
                    <!-- <li class="treeview">
                        <a href="<?php echo base_url(); ?>log-history-upload">
                            <i class="fa fa-upload"></i>
                            <span>
                                Upload Backup</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?php echo base_url(); ?>log-history-backup">
                            <i class="fa fa-archive"></i>
                            <span>Log Records Backup
                            </span>
                        </a>
                    </li> -->
                    <?php
            }
            if($role == ROLE_EMPLOYEE)
            {
            ?>
                       <li class="treeview">
                        <a href="<?php echo base_url(); ?>etasks">
                            <i class="fa fa-tasks"></i>
                            <span>Tasks</span>
                        </a>
                        <?php
            }
            ?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <div class="loader_ajax" style="display:none;">
	    <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
	</div>

    <style>
        .loader_ajax {background-color: #242424;bottom: 0;height: 100%;left: 0;opacity: 0.9;position: fixed;top: 0;width: 100%;z-index: 999;}
        .loader_ajax_inner {background: transparent url("<?php echo ICONPATH;?>/bg.png") no-repeat scroll center center;height: 44px;left: 50%;margin: -22px 0 0 -22px;position: absolute;top: 50%;width: 44px;}
        .loader_ajax img {margin: 9px 0 0 8px;width: 28px;}
    </style>