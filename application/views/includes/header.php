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

                    <li class="treeview <?php if($pageUrl=="suppliermaster" || $pageUrl=="addnewSupplier" || $pageUrl=='updateSupplier' || $pageUrl=='rowmaterialmaster' || $pageUrl=='addnewmaterialdata' || $pageUrl=='updateRawmaterial' || $pageUrl=="vendormaster" || $pageUrl=='addnewVendor' || $pageUrl=='updateVendor' || $pageUrl=="uspmaster" || $pageUrl=="addnewUSP" || $pageUrl=="updateUSP" || $pageUrl=="finishedgoodsmaster" || $pageUrl=="addnewFinishedgoods" || $pageUrl=="updateFinishedgoods" || $pageUrl=="plattingmaster" || $pageUrl=="addnewPlatting" || $pageUrl=="updatePlattingmaster" || $pageUrl=="rejectionmaster" || $pageUrl=="addnewRejection" || $pageUrl=="updateRejectionmaster" || $pageUrl=="buyermaster" || $pageUrl=="addnewBuyer" || $pageUrl=="updateBuyer" || $pageUrl=="chamaster" || $pageUrl=='addnewCha' || $pageUrl=='updatecha'){echo 'active';}?>">
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
                        <li class="line_height <?php if($pageUrl=="uspmaster" || $pageUrl=="addnewUSP" || $pageUrl=="updateUSP"){echo 'active';}?>"><a href="<?php echo base_url();?>uspmaster"><i class="fa fa-cubes"></i> USP Master</a></li>
                        <li class="line_height <?php if($pageUrl=="finishedgoodsmaster" || $pageUrl=="addnewFinishedgoods" || $pageUrl=="updateFinishedgoods"){echo 'active';}?>"><a href="<?php echo base_url();?>finishedgoodsmaster"><i class="fa fa-cubes"></i> Finished Goods Master</a></li>
                        <li class="line_height <?php if($pageUrl=="plattingmaster" || $pageUrl=="addnewPlatting" || $pageUrl=="updatePlattingmaster" ){echo 'active';}?>"><a href="<?php echo base_url();?>plattingmaster"><i class="fa fa-cubes"></i> Platting Master</a></li>
                        <li class="line_height <?php if($pageUrl=="rejectionmaster" || $pageUrl=="addnewRejection" || $pageUrl=="updateRejectionmaster"){echo 'active';}?>"><a href="<?php echo base_url();?>rejectionmaster"><i class="fa fa-cubes"></i> Rejection Reason Master</a></li>
                        <li class="line_height <?php if($pageUrl=="buyermaster" || $pageUrl=="addnewBuyer" || $pageUrl=="updateBuyer"){echo 'active';}?>"><a href="<?php echo base_url();?>buyermaster"><i class="fa fa-cubes"></i> Buyer Master</a></li>
                        <li class="line_height <?php if($pageUrl=="chamaster" || $pageUrl=='addnewCha' || $pageUrl=='updatecha'){echo 'active';}?>"><a href="<?php echo base_url(); ?>chamaster"><i class="fa fa-cubes"></i> CHA Master</a></li>
                      </ul>
                    </li>

                  
                    <li class="treeview <?php if($pageUrl=="buyerpo" || $pageUrl=="addnewBuyerpo" || $pageUrl=="editBuyerpo" || $pageUrl=="supplierpo" || $pageUrl=="addnewSupplierpo" || $pageUrl=="editSupplierpo" || $pageUrl=="viewBuyerpo" || $pageUrl=="buyerpoconfirmation" || $pageUrl=="viewSupplierpo" || $pageUrl=="vendorpo" || $pageUrl=="addnewVendorpo" || $pageUrl=="viewVendorpo" || $pageUrl=="supplierpoconfirmation" || $pageUrl=="addSupplierpoconfirmation" || $pageUrl=="viewSupplierpoconfirmation" || $pageUrl=="vendorpoconfirmation" || $pageUrl=="addVendorpoconfirmation" || $pageUrl=="billofmaterial" || $pageUrl=="addnewBillofmaterial" || $pageUrl=="vendorbillofmaterial" || $pageUrl=="addvendorBillofmaterial" || $pageUrl=="viewVendorbillofmaterial" || $pageUrl=="packinginstaruction" || $pageUrl=="exportdetails" || $pageUrl=="packagingform"  || $pageUrl=="rrchallan" || $pageUrl=="addnewpackinginstruction" || $pageUrl=="incomingdetails" || $pageUrl=="addnewencomingdetails" || $pageUrl=="addpackinginstractiondetails" ||  $pageUrl=="editpackinginstraction" ||  $pageUrl=="editincomingdetails" || $pageUrl=="addnewExportDetails" || $pageUrl=="editexportdetails" ||  $pageUrl=="addExportdetailsitems" || $pageUrl=="editVendorpo" || $pageUrl=="viewexportdetails" || $pageUrl=="currentorderstatus" || $pageUrl=="qualityrecord" || $pageUrl=='addNewqualityrecord' || $pageUrl=="stockform" || $pageUrl=='addNewstockform' || $pageUrl=='editstcokformdetails' || $pageUrl=='searchstock' || $pageUrl =="editSupplierpoconfirmation"  || $pageUrl=="editvendorpoconfirmation" || $pageUrl=="editbillofmaterial" || $pageUrl=="editvendorbillofmaterial" || $pageUrl=="stockrejectionform" || $pageUrl=="addnewrejectionform" ||  $pageUrl=="editrejetionform" || $pageUrl=='addrejectionformitemsdata' || $pageUrl=='viewrejectionformitemdetails' || $pageUrl=='editqulityrecordform' || $pageUrl=="buyerpodetailsreport" || $pageUrl=="itcreport" || $pageUrl=="complaintform" || $pageUrl=="addcomplaintform" || $pageUrl=="editcomplainform" || $pageUrl=="creditnote" || $pageUrl=="addcreditnote" || $pageUrl=="editcreditnote" || $pageUrl=="preexport" || $pageUrl=="addnewfreexport" || $pageUrl=="editpreexport" || $pageUrl=='exportdetailsitemdetails' || $pageUrl=='addpreexportitemdetails' || $pageUrl=='editaddpreexportitemdetails' || $pageUrl=='addexportitemdetailswithattributes' || $pageUrl=='addexportitemdetailswithattributesvalues' || $pageUrl=='editexportitemdetailswithattributesvalues' || $pageUrl=='salestrackingreport' || $pageUrl=="addsalestrackingreport" || $pageUrl=="editsalestrackingreport" || $pageUrl=="chadebitnote" ||  $pageUrl=="addchadebitnote" || $pageUrl=="scrapcalculationreport" || $pageUrl=="productionstatusreport" || $pageUrl=="supplierporeport" || $pageUrl=="editchadebitnote" ||  $pageUrl=="salestrackingexcelreport"){echo 'active';}?>">
                      <a href="#">
                        <i class="fa fa-laptop"></i> <span class="menu_label">Miscellaneous</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height <?php if($pageUrl=="buyerpo" || $pageUrl=="addnewBuyerpo"  || $pageUrl=="viewBuyerpo" || $pageUrl=="editBuyerpo" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>buyerpo"><i class="fa fa-cubes"></i> Buyer PO</a></li>
                        <li class="line_height <?php if($pageUrl=="supplierpo" || $pageUrl=="addnewSupplierpo" || $pageUrl=="viewSupplierpo" || $pageUrl=="editSupplierpo"){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierpo"><i class="fa fa-cubes"></i> Supplier PO</a></li>
                        <li class="line_height <?php if($pageUrl=="vendorpo" || $pageUrl=="addnewVendorpo" || $pageUrl=="viewVendorpo"  || $pageUrl=="addnewVendorpo" || $pageUrl=="editVendorpo"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorpo"><i class="fa fa-cubes"></i> Vendor PO</a></li>
                        <li class="line_height <?php if($pageUrl=="supplierpoconfirmation" || $pageUrl=="addSupplierpoconfirmation" || $pageUrl =="viewSupplierpoconfirmation" || $pageUrl =="editSupplierpoconfirmation" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierpoconfirmation"><i class="fa fa-cubes"></i> Supplier PO Confirmation</a></li>
                        <li class="line_height <?php if($pageUrl=="vendorpoconfirmation" || $pageUrl=="addVendorpoconfirmation" || $pageUrl=="editvendorpoconfirmation"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorpoconfirmation"><i class="fa fa-cubes"></i> Vendor PO Confirmation</a></li>
                        <li class="line_height <?php if($pageUrl=="billofmaterial" || $pageUrl=="addnewBillofmaterial" || $pageUrl=="editbillofmaterial"){echo 'active';}?>"><a href="<?php echo base_url(); ?>billofmaterial"><i class="fa fa-cubes"></i> Bill of Material</a></li>
                        <li class="line_height <?php if($pageUrl=="vendorbillofmaterial" || $pageUrl=="addvendorBillofmaterial" || $pageUrl=="viewVendorbillofmaterial" || $pageUrl=="editvendorbillofmaterial"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorbillofmaterial"><i class="fa fa-cubes"></i> Vendor Bill of Material</a></li>
                        <li class="line_height <?php if($pageUrl=="incomingdetails" || $pageUrl=="addnewencomingdetails" ||  $pageUrl=="editincomingdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>incomingdetails"><i class="fa fa-cubes"></i> Incoming Details</a></li>
                        <li class="line_height <?php if($pageUrl=="stockform" || $pageUrl=='addNewstockform' || $pageUrl=='editstcokformdetails' ){echo 'active';}?>"><a href="<?php echo base_url(); ?>stockform"><i class="fa fa-cubes"></i> Stock Form</a></li>
                        <li class="line_height <?php if($pageUrl=="stockrejectionform" || $pageUrl=='addnewrejectionform' || $pageUrl=='editrejetionform' || $pageUrl=='addrejectionformitemsdata' || $pageUrl=='viewrejectionformitemdetails'){echo 'active';}?>"><a href="<?php echo base_url(); ?>stockrejectionform"><i class="fa fa-cubes"></i> Stock Rejection Form</a></li>
                        <li class="line_height <?php if($pageUrl=="searchstock"){echo 'active';}?>"><a href="<?php echo base_url(); ?>searchstock"><i class="fa fa-cubes"></i> Search Stock</a></li>
                        <li class="line_height <?php if($pageUrl=="qualityrecord" || $pageUrl=='addNewqualityrecord' || $pageUrl=='editqulityrecordform'){echo 'active';}?>"><a href="<?php echo base_url(); ?>qualityrecord"><i class="fa fa-cubes"></i> Quality Record</a></li>
                        <li class="line_height <?php if($pageUrl=="packinginstaruction" || $pageUrl=="addnewpackinginstruction" || $pageUrl=="addpackinginstractiondetails" || $pageUrl=="editpackinginstraction"){echo 'active';}?>"><a href="<?php echo base_url(); ?>packinginstaruction"><i class="fa fa-cubes"></i> Packing Instructions / Form</a></li>
                        <li class="line_height <?php if($pageUrl=="exportdetails" || $pageUrl=="addnewExportDetails" || $pageUrl=="editexportdetails" || $pageUrl=="addExportdetailsitems" || $pageUrl=="viewexportdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>exportdetails"><i class="fa fa-cubes"></i> Export Details</a></li>
                        <li class="line_height <?php if($pageUrl=="currentorderstatus"){echo 'active';}?>"><a href="<?php echo base_url(); ?>currentorderstatus"><i class="fa fa-cubes"></i> Current Order Status</a></li>
                        <li class="line_height <?php if($pageUrl=="buyerpodetailsreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>buyerpodetailsreport"><i class="fa fa-cubes"></i> Buyer PO Details</a></li>
                        <li class="line_height <?php if($pageUrl=="complaintform" || $pageUrl=="addcomplaintform" || $pageUrl=="editcomplainform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>complaintform"><i class="fa fa-cubes"></i> Complaint form</a></li>
                        <li class="line_height <?php if($pageUrl=="itcreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>itcreport"><i class="fa fa-cubes"></i> ITC Report</a></li>
                        <li class="line_height <?php if($pageUrl=="creditnote" || $pageUrl=="addcreditnote" || $pageUrl=="editcreditnote"){echo 'active';}?>"><a href="<?php echo base_url(); ?>creditnote"><i class="fa fa-cubes"></i> Credit Note</a></li>
                        <li class="line_height <?php if($pageUrl=="preexport" || $pageUrl=="addnewfreexport" || $pageUrl=="editpreexport" || $pageUrl=='exportdetailsitemdetails' || $pageUrl=='addpreexportitemdetails' || $pageUrl=='editaddpreexportitemdetails' || $pageUrl=='addexportitemdetailswithattributes' || $pageUrl=='addexportitemdetailswithattributesvalues' || $pageUrl=='editexportitemdetailswithattributesvalues'){echo 'active';}?>"><a href="<?php echo base_url(); ?>preexport"><i class="fa fa-cubes"></i> Pre Export</a></li>
                        <li class="line_height <?php if($pageUrl=="salestrackingreport" || $pageUrl=="addsalestrackingreport" || $pageUrl=="editsalestrackingreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>salestrackingreport"><i class="fa fa-cubes"></i> Sales Tracking Report</a></li>
                        <li class="line_height <?php if($pageUrl=="salestrackingexcelreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>salestrackingexcelreport"><i class="fa fa-cubes"></i> Sales Tracking Excel Report</a></li>
                        <li class="line_height <?php if($pageUrl=="chadebitnote" || $pageUrl=="addchadebitnote" || $pageUrl=="editchadebitnote" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>chadebitnote"><i class="fa fa-cubes"></i> CHA Debit Note</a></li>
                        <li class="line_height <?php if($pageUrl=="scrapcalculationreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scrapcalculationreport"><i class="fa fa-cubes"></i> Scrap Calculation Report</a></li>
                        <li class="line_height <?php if($pageUrl=="productionstatusreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>productionstatusreport"><i class="fa fa-cubes"></i> Peoduction Status Report</a></li>
                        <li class="line_height <?php if($pageUrl=="supplierporeport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierporeport"><i class="fa fa-cubes"></i> Supplier PO Confirmation Report</a></li>

                      </ul>
                    </li>

                    <li class="treeview <?php if($pageUrl=="jobWork" || $pageUrl=="addjobwork" || $pageUrl=="editjobwork" ||  $pageUrl=="scrapreturn" || $pageUrl=="addnewScrapreturn" || $pageUrl=="editscrapreturn" || $pageUrl=="reworkrejectionreturn" || $pageUrl=="addneworkrejection" || $pageUrl=="editreworkrejection" || $pageUrl=="challanform" || $pageUrl=="addchallanform" || $pageUrl=="editchallanform" || $pageUrl=="omschallan" || $pageUrl=='addNewOMSChallan' ||  $pageUrl=='editomschallan' || $pageUrl=='enquiryform' || $pageUrl=="editeqnuiryformdatabyid" || $pageUrl=='addnewenquiryform' ||  $pageUrl=='editenquiryform' || $pageUrl=='editeqnuiryformdata'){echo 'active';}?>">
                      <a href="#">
                        <i class="fa fa-file-text-o"></i> <span class="menu_label">Challans</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height <?php if($pageUrl=="jobWork" || $pageUrl=="addjobwork" || $pageUrl=="editjobwork"){echo 'active';}?>"><a href="<?php echo base_url(); ?>jobWork"><i class="fa fa-cubes"></i> Job Work</a></li>
                        <li class="line_height <?php if($pageUrl=="reworkrejectionreturn" || $pageUrl=="addneworkrejection" || $pageUrl=="editreworkrejection"){echo 'active';}?>"><a href="<?php echo base_url(); ?>reworkrejectionreturn"><i class="fa fa-cubes"></i> Rework / Rejection Return (RR)</a></li>
                        <li class="line_height <?php if($pageUrl=="challanform" || $pageUrl=="addchallanform" || $pageUrl=="editchallanform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>challanform"><i class="fa fa-cubes"></i> Challan Form</a></li>                        
                        <li class="line_height <?php if($pageUrl=="scrapreturn" || $pageUrl=="addnewScrapreturn" || $pageUrl=="editscrapreturn"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scrapreturn"><i class="fa fa-cubes"></i> Scrap Return</a></li>
                        <!-- <li class="line_height <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=="editdebitnoteform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>debitnote"><i class="fa fa-cubes"></i> Debit Note</a></li> -->
                        <!-- <li class="line_height <?php if($pageUrl=="paymentdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>paymentdetails"><i class="fa fa-cubes"></i> Payment Details</a></li> -->
                        <!-- <li class="line_height <?php if($pageUrl=="poddetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>poddetails"><i class="fa fa-cubes"></i> POD Details</a></li> -->
                        <li class="line_height <?php if($pageUrl=="omschallan" || $pageUrl=='addNewOMSChallan' ||  $pageUrl=='editomschallan'){echo 'active';}?>"><a href="<?php echo base_url(); ?>omschallan"><i class="fa fa-cubes"></i> OMS Challan</a></li>
                        <li class="line_height <?php if($pageUrl=="enquiryform" || $pageUrl=='addnewenquiryform' ||  $pageUrl=='editenquiryform' ||  $pageUrl=='editeqnuiryformdatabyid'){echo 'active';}?>"><a href="<?php echo base_url(); ?>enquiryform"><i class="fa fa-cubes"></i> Enquiry Form</a></li>
                      </ul>
                    </li>


                    <!-- <li class="treeview <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote"){echo 'active';}?>" >
                      <a href="<?php echo base_url(); ?>debitnote">
                        <i class="fa fa-building-o"></i> <span class="menu_label">Debit Note</span>
                      </a>
                    </li>  -->


                    <li class="treeview <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=='editdebitnoteform' || $pageUrl=="paymentdetails" || $pageUrl=="addnewpaymentdetails" || $pageUrl=='editpaymentdetails' || $pageUrl=="poddetails" || $pageUrl=='addNewPODdetails' || $pageUrl=='addpaymentdetailsdata' || $pageUrl=='editpoddetails'){echo 'active';}?>">
                      <a href="#">
                        <i class="fa fa-file-text-o"></i> <span class="menu_label">Debit Note</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu" >
                        <li class="line_height <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=="editdebitnoteform" || $pageUrl=='editdebitnoteform'){echo 'active';}?>"><a href="<?php echo base_url(); ?>debitnote"><i class="fa fa-cubes"></i> Debit Note</a></li>
                        <li class="line_height <?php if($pageUrl=="paymentdetails" || $pageUrl=="addnewpaymentdetails" || $pageUrl=='addpaymentdetailsdata' || $pageUrl=='editpaymentdetails'){echo 'active';}?>"><a href="<?php echo base_url(); ?>paymentdetails"><i class="fa fa-cubes"></i> Payment Details</a></li>
                        <li class="line_height <?php if($pageUrl=="poddetails" || $pageUrl=='addNewPODdetails' ||  $pageUrl=='editpoddetails'){echo 'active';}?>"><a href="<?php echo base_url(); ?>poddetails"><i class="fa fa-cubes"></i> POD Details</a></li>
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