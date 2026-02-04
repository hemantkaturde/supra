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
                                <img src="<?php echo base_url(); ?>assets/images/supra_logo_1.jpg" class="user-image"
                                    alt="User Image" />
                                <span class="hidden-xs">
                                    <?php echo $name; ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo base_url(); ?>assets/images/supra_logo_1.jpg" class="img-circle"
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

                    <?php  if( $this->session->userdata('roleText')=='Team'){ ?>

                    
                      <li class="treeview <?php if($pageUrl=="hourly_inspection_report" || $pageUrl=="updatehourlyworkingreportdata"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>hourly_inspection_report">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Hourly Inspection Report</span>
                        </a>
                      </li> 


                    <?php }else{ ?>

                      <li class="treeview">
                          <a href="<?php echo base_url(); ?>dashboard">
                              <i class="fa fa-dashboard"></i>
                              <span class="menu_label">Dashboard</span>
                              </i>
                          </a>
                      </li>
                  
                      <li class="treeview <?php if($pageUrl=="companymaster"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>companymaster">
                          <i class="fa fa-building-o"></i> <span class="menu_label">Company Info</span>
                        </a>
                      </li> 

                      <li class="treeview <?php if( $pageUrl=="instrument" || $pageUrl=="suppliermaster" || $pageUrl=="addnewSupplier" || $pageUrl=='updateSupplier' || $pageUrl=='rowmaterialmaster' || $pageUrl=='addnewmaterialdata' || $pageUrl=='updateRawmaterial' || $pageUrl=="vendormaster" || $pageUrl=='addnewVendor' || $pageUrl=='updateVendor' || $pageUrl=="uspmaster" || $pageUrl=="addnewUSP" || $pageUrl=="updateUSP" || $pageUrl=="finishedgoodsmaster" || $pageUrl=="addnewFinishedgoods" || $pageUrl=="updateFinishedgoods" || $pageUrl=="plattingmaster" || $pageUrl=="addnewPlatting" || $pageUrl=="updatePlattingmaster" || $pageUrl=="rejectionmaster" || $pageUrl=="addnewRejection" || $pageUrl=="updateRejectionmaster" || $pageUrl=="buyermaster" || $pageUrl=="addnewBuyer" || $pageUrl=="updateBuyer" || $pageUrl=="chamaster" || $pageUrl=='addnewCha' || $pageUrl=='updatecha' || $pageUrl=="samplingmaster" || $pageUrl=="addnewSamplingmaster" || $pageUrl=="updatesampling" || $pageUrl=="addsamplingmethod" || $pageUrl=="teammaster" || $pageUrl=='addteam' || $pageUrl=="addnewSamplingmethod" || $pageUrl=="updatesamplingmethodtrans" || $pageUrl=='addteammembers' || $pageUrl=='addteammemberaction' || $pageUrl=='updateteammember' || $pageUrl=='updateteammaster' || $pageUrl=='scraptype' || $pageUrl=="addnewscraptype" || $pageUrl=="packingmaster" || $pageUrl=="addnewpackingmaster" || $pageUrl=="addinstrumentdetailsdata"){echo 'active';}?>">
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
                          <li class="line_height <?php if($pageUrl=="teammaster" || $pageUrl=='addteam' || $pageUrl=='updateteam' || $pageUrl=='addteammembers' || $pageUrl=='addteammemberaction' || $pageUrl=='updateteammember' || $pageUrl=='updateteammaster'){echo 'active';}?>"><a href="<?php echo base_url(); ?>teammaster"><i class="fa fa-cubes"></i> Team Master</a></li>
                          <li class="line_height <?php if($pageUrl=="samplingmaster" || $pageUrl=='addnewSamplingmaster' || $pageUrl=="updatesampling" || $pageUrl=="addsamplingmethod" || $pageUrl=="addnewSamplingmethod"  || $pageUrl=="updatesamplingmethodtrans"){echo 'active';}?>"><a href="<?php echo base_url(); ?>samplingmaster"><i class="fa fa-cubes"></i>  Sampling Master</a></li>
                          <li class="line_height <?php if($pageUrl=="scraptype" || $pageUrl=="addnewscraptype"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scraptype"><i class="fa fa-cubes"></i> Scrap Type</a></li>
                          <li class="line_height <?php if($pageUrl=="packingmaster" || $pageUrl=="addnewpackingmaster"){echo 'active';}?>"><a href="<?php echo base_url(); ?>packingmaster"><i class="fa fa-cubes"></i> Packing Master</a></li>
                          <li class="line_height <?php if($pageUrl=="instrument" || $pageUrl=="addinstrumentdetailsdata"){echo 'active';}?>"><a href="<?php echo base_url(); ?>instrument"><i class="fa fa-cubes"></i> Instrument Master</a></li>

                       
                        </ul>
                      </li>

                      <li class="treeview <?php if($pageUrl=="supplierpo" || $pageUrl=="addnewSupplierpo" || $pageUrl=="viewSupplierpo" 
                          || $pageUrl=="editSupplierpo" || $pageUrl=="vendorpo" || $pageUrl=="addnewVendorpo" || $pageUrl=="viewVendorpo"  
                          || $pageUrl=="addnewVendorpo" || $pageUrl=="editVendorpo" || $pageUrl=="supplierpoconfirmation" || $pageUrl=="addSupplierpoconfirmation" 
                          || $pageUrl =="viewSupplierpoconfirmation" || $pageUrl =="editSupplierpoconfirmation" 
                          || $pageUrl=="vendorpoconfirmation" || $pageUrl=="addVendorpoconfirmation" || $pageUrl=="editvendorpoconfirmation"
                          || $pageUrl=="billofmaterial" || $pageUrl=="addnewBillofmaterial" || $pageUrl=="editbillofmaterial"
                          || $pageUrl=="vendorbillofmaterial" || $pageUrl=="addvendorBillofmaterial" || $pageUrl=="viewVendorbillofmaterial" || $pageUrl=="editvendorbillofmaterial"
                          || $pageUrl=="jobWork" || $pageUrl=="addjobwork" || $pageUrl=="editjobwork"
                          || $pageUrl=="scrapreturn" || $pageUrl=="addnewScrapreturn" || $pageUrl=="editscrapreturn"
                          || $pageUrl=="scrapcalculationreport"
                          || $pageUrl=="omschallan" || $pageUrl=='addNewOMSChallan' ||  $pageUrl=='editomschallan'
                          || $pageUrl=="enquiryform" || $pageUrl=='addnewenquiryform' ||  $pageUrl=='editenquiryform' ||  $pageUrl=='editeqnuiryformdatabyid'
                          || $pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=="editdebitnoteform" || $pageUrl=='editdebitnoteform'
                          || $pageUrl=="paymentdetails" || $pageUrl=="addnewpaymentdetails" || $pageUrl=='addpaymentdetailsdata' || $pageUrl=='editpaymentdetails'
                          || $pageUrl=="paymentdetailsreport"
                          || $pageUrl=="poddetails" || $pageUrl=='addNewPODdetails' ||  $pageUrl=='editpoddetails'
                          || $pageUrl=="currentorderstatus"
                          || $pageUrl=="itcreport"
                          || $pageUrl=="creditnote" || $pageUrl=="addcreditnote" || $pageUrl=="editcreditnote"
                          || $pageUrl=="supplierporeport"
                          || $pageUrl=="viewvendorpoconfirmation"
                          || $pageUrl=="viewbillofmaterial"
                          || $pageUrl=="viewjobwork"
                          || $pageUrl=="viewscrapreturn"
                          || $pageUrl=="viewomschallan"
                          || $pageUrl=="vieweqnuiryformdatabyid"
                          || $pageUrl=="viewdebitnoteform"
                          || $pageUrl=="viewcreditnoteform"
                          || $pageUrl=="viewpaymentdetails"
                          || $pageUrl=="viewpoddetails"
                          || $pageUrl=="buyerpo" 
                          || $pageUrl=="addnewBuyerpo"  
                          || $pageUrl=="viewBuyerpo" 
                          || $pageUrl=="editBuyerpo"
                          || $pageUrl=="scrap_invoice"
                          || $pageUrl=="addnewscrapinvoice"
                          || $pageUrl=="editscrapinvoice"
                          || $pageUrl=="packing_challan"
                          || $pageUrl=="addnewpackingchallan"
                          || $pageUrl== "editpackingchallan"
                          || $pageUrl=="angadia_report"
                          ){echo 'active';}?>">
                        <a href="#">
                          <i class="fa fa-shopping-cart"></i> <span class="menu_label">Purchase</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>

                        <ul class="treeview-menu" >
                          <li class="line_height <?php if($pageUrl=="buyerpo" || $pageUrl=="addnewBuyerpo"  || $pageUrl=="viewBuyerpo" || $pageUrl=="editBuyerpo" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>buyerpo"><i class="fa fa-cubes"></i> Buyer PO</a></li>
                          <li class="line_height <?php if($pageUrl=="supplierpo" || $pageUrl=="addnewSupplierpo" || $pageUrl=="viewSupplierpo" || $pageUrl=="editSupplierpo"){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierpo"><i class="fa fa-cubes"></i> Supplier PO</a></li>
                          <li class="line_height <?php if($pageUrl=="vendorpo" || $pageUrl=="addnewVendorpo" || $pageUrl=="viewVendorpo"  || $pageUrl=="addnewVendorpo" || $pageUrl=="editVendorpo"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorpo"><i class="fa fa-cubes"></i> Vendor PO</a></li> 
                          <li class="line_height <?php if($pageUrl=="supplierpoconfirmation" || $pageUrl=="addSupplierpoconfirmation" || $pageUrl =="viewSupplierpoconfirmation" || $pageUrl =="editSupplierpoconfirmation" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierpoconfirmation"><i class="fa fa-cubes"></i> Supplier PO Confirmation</a></li>
                          <li class="line_height <?php if($pageUrl=="vendorpoconfirmation" || $pageUrl=="addVendorpoconfirmation" || $pageUrl=="editvendorpoconfirmation" || $pageUrl=="viewvendorpoconfirmation"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorpoconfirmation"><i class="fa fa-cubes"></i> Vendor PO Confirmation</a></li>
                          <li class="line_height <?php if($pageUrl=="billofmaterial" || $pageUrl=="addnewBillofmaterial" || $pageUrl=="editbillofmaterial" || $pageUrl=="viewbillofmaterial"){echo 'active';}?>"><a href="<?php echo base_url(); ?>billofmaterial"><i class="fa fa-cubes"></i> Bill of Material</a></li>
                          <li class="line_height <?php if($pageUrl=="vendorbillofmaterial" || $pageUrl=="addvendorBillofmaterial" || $pageUrl=="viewVendorbillofmaterial" || $pageUrl=="editvendorbillofmaterial"){echo 'active';}?>"><a href="<?php echo base_url(); ?>vendorbillofmaterial"><i class="fa fa-cubes"></i> Vendor Bill of Material</a></li>
                          <li class="line_height <?php if($pageUrl=="jobWork" || $pageUrl=="addjobwork" || $pageUrl=="editjobwork" || $pageUrl=="viewjobwork"){echo 'active';}?>"><a href="<?php echo base_url(); ?>jobWork"><i class="fa fa-cubes"></i> Job Work</a></li>
                          <li class="line_height <?php if($pageUrl=="scrapreturn" || $pageUrl=="addnewScrapreturn" || $pageUrl=="editscrapreturn" || $pageUrl=="viewscrapreturn"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scrapreturn"><i class="fa fa-cubes"></i> Scrap Return</a></li>
                          <li class="line_height <?php if($pageUrl=="scrapcalculationreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scrapcalculationreport"><i class="fa fa-cubes"></i> Scrap Calculation Report</a></li>
                          <li class="line_height <?php if($pageUrl=="omschallan" || $pageUrl=='addNewOMSChallan' ||  $pageUrl=='editomschallan' || $pageUrl=="viewomschallan"){echo 'active';}?>"><a href="<?php echo base_url(); ?>omschallan"><i class="fa fa-cubes"></i> OMS Challan</a></li>
                          <li class="line_height <?php if($pageUrl=="enquiryform" || $pageUrl=='addnewenquiryform' ||  $pageUrl=='editenquiryform' ||  $pageUrl=='editeqnuiryformdatabyid' || $pageUrl=="vieweqnuiryformdatabyid"){echo 'active';}?>"><a href="<?php echo base_url(); ?>enquiryform"><i class="fa fa-cubes"></i> Enquiry Form</a></li>
                          <li class="line_height <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=="editdebitnoteform" || $pageUrl=='editdebitnoteform' || $pageUrl=="viewdebitnoteform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>debitnote"><i class="fa fa-cubes"></i> Debit Note</a></li>
                          <li class="line_height <?php if($pageUrl=="paymentdetails" || $pageUrl=="addnewpaymentdetails" || $pageUrl=='addpaymentdetailsdata' || $pageUrl=='editpaymentdetails' || $pageUrl=="viewpaymentdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>paymentdetails"><i class="fa fa-cubes"></i> Payment Details</a></li>
                          <li class="line_height <?php if($pageUrl=="paymentdetailsreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>paymentdetailsreport"><i class="fa fa-cubes"></i> Payment Details Report</a></li>
                          <li class="line_height <?php if($pageUrl=="poddetails" || $pageUrl=='addNewPODdetails' ||  $pageUrl=='editpoddetails' || $pageUrl=="viewpoddetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>poddetails"><i class="fa fa-cubes"></i> POD Details</a></li>
                          <li class="line_height <?php if($pageUrl=="currentorderstatus"){echo 'active';}?>"><a href="<?php echo base_url(); ?>currentorderstatus"><i class="fa fa-cubes"></i> Current Order Status</a></li>
                          <li class="line_height <?php if($pageUrl=="itcreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>itcreport"><i class="fa fa-cubes"></i> ITC Report</a></li>
                          <li class="line_height <?php if($pageUrl=="creditnote" || $pageUrl=="addcreditnote" || $pageUrl=="editcreditnote" || $pageUrl=="viewcreditnoteform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>creditnote"><i class="fa fa-cubes"></i> Credit Note</a></li>
                          <li class="line_height <?php if($pageUrl=="supplierporeport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>supplierporeport"><i class="fa fa-cubes"></i> Supplier PO Confirmation Report</a></li>
                          <li class="line_height <?php if($pageUrl=="scrap_invoice" || $pageUrl=="addnewscrapinvoice"  || $pageUrl=="editscrapinvoice"){echo 'active';}?>"><a href="<?php echo base_url(); ?>scrap_invoice"><i class="fa fa-cubes"></i> Scrap Invoice</a></li>
                          <li class="line_height <?php if($pageUrl=="packing_challan" || $pageUrl=="addnewpackingchallan" || $pageUrl== "editpackingchallan"){echo 'active';}?>"><a href="<?php echo base_url(); ?>packing_challan"><i class="fa fa-cubes"></i> Packing Challan</a></li>
                          <li class="line_height <?php if($pageUrl=="angadia_report"){echo 'active';}?>"><a href="<?php echo base_url(); ?>angadia_report"><i class="fa fa-cubes"></i> Sai Krupa Express Report</a></li>
                        </ul>
                      </li>

                      <li class="treeview  <?php if($pageUrl=="incomingdetails" || $pageUrl=="addnewencomingdetails" 
                          ||  $pageUrl=="editincomingdetails" || $pageUrl=="uspincoming" || $pageUrl=="addnewuspincoming" || $pageUrl=="edituspincomig"
                          || $pageUrl=="stockform" 
                          || $pageUrl=='addNewstockform' || $pageUrl=='editstcokformdetails' || $pageUrl=="stockrejectionform" 
                          || $pageUrl=='addnewrejectionform' || $pageUrl=='editrejetionform' || $pageUrl=='addrejectionformitemsdata' 
                          || $pageUrl=='viewrejectionformitemdetails' || $pageUrl=="searchstockreport" || $pageUrl=="searchstock" 
                          || $pageUrl=="preexport" || $pageUrl=="addnewfreexport" || $pageUrl=="editpreexport" 
                          || $pageUrl=='exportdetailsitemdetails' || $pageUrl=='addpreexportitemdetails'
                          || $pageUrl=='editaddpreexportitemdetails' || $pageUrl=='addexportitemdetailswithattributes' 
                          || $pageUrl=='addexportitemdetailswithattributesvalues' || $pageUrl=='editexportitemdetailswithattributesvalues' 
                          || $pageUrl=="reworkrejectionreturn" || $pageUrl=="addneworkrejection" || $pageUrl=="editreworkrejection" 
                          || $pageUrl=="viewreworkrejection" || $pageUrl=="viewchallanform"
                          || $pageUrl=="challanform" || $pageUrl=="addchallanform" || $pageUrl=="editchallanform"
                          || $pageUrl=="viewincomingdetails"
                          || $pageUrl=="viewuspincomig"
                          || $pageUrl=="viewstcokformdetails"
                          || $pageUrl=="addscraprejection"
                          || $pageUrl=="searchstock"
                          || $pageUrl=="reworkrecordform"
                          || $pageUrl=="edit_rework_record"
                          || $pageUrl=="reworkrecordlotnumberrecord"
                          || $pageUrl=="balancestockform"
                          ){echo 'active';}?>">
                        <a href="#">
                          <i class="fa fa-stack-exchange"></i> <span class="menu_label">Stock</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" >
                          <li class="line_height <?php if($pageUrl=="incomingdetails" || $pageUrl=="addnewencomingdetails" ||  $pageUrl=="editincomingdetails" ||  $pageUrl=="viewincomingdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>incomingdetails"><i class="fa fa-cubes"></i> Incoming Details</a></li>
                          <li class="line_height <?php if($pageUrl=="uspincoming" || $pageUrl=="addnewuspincoming" || $pageUrl=="edituspincomig" || $pageUrl=="viewuspincomig"){echo 'active';}?>"><a href="<?php echo base_url(); ?>uspincoming"><i class="fa fa-cubes"></i> USP Incoming</a></li>
                          <li class="line_height <?php if($pageUrl=="stockform" || $pageUrl=='addNewstockform' || $pageUrl=='editstcokformdetails' || $pageUrl=="viewstcokformdetails" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>stockform"><i class="fa fa-cubes"></i> Stock Form</a></li>
                          <li class="line_height <?php if($pageUrl=="stockrejectionform" || $pageUrl=='addnewrejectionform' || $pageUrl=='editrejetionform' || $pageUrl=='addrejectionformitemsdata' || $pageUrl=='viewrejectionformitemdetails' || $pageUrl=="addscraprejection"){echo 'active';}?>"><a href="<?php echo base_url(); ?>stockrejectionform"><i class="fa fa-cubes"></i> Stock Rejection Form</a></li>
                          <li class="line_height <?php if($pageUrl=="searchstockreport" || $pageUrl=="searchstock"){echo 'active';}?>"><a href="<?php echo base_url(); ?>searchstockreport"><i class="fa fa-cubes"></i> Search Stock Report</a></li>
                          <li class="line_height <?php if($pageUrl=="preexport" || $pageUrl=="addnewfreexport" || $pageUrl=="editpreexport" || $pageUrl=='exportdetailsitemdetails' || $pageUrl=='addpreexportitemdetails' || $pageUrl=='editaddpreexportitemdetails' || $pageUrl=='addexportitemdetailswithattributes' || $pageUrl=='addexportitemdetailswithattributesvalues' || $pageUrl=='editexportitemdetailswithattributesvalues'){echo 'active';}?>"><a href="<?php echo base_url(); ?>preexport"><i class="fa fa-cubes"></i> Pre Export</a></li>
                          <li class="line_height <?php if($pageUrl=="viewreworkrejection" || $pageUrl=="reworkrejectionreturn" || $pageUrl=="addneworkrejection" || $pageUrl=="editreworkrejection"){echo 'active';}?>"><a href="<?php echo base_url(); ?>reworkrejectionreturn"><i class="fa fa-cubes"></i> Rework / Rejection Return (RR)</a></li>
                          <li class="line_height <?php if($pageUrl=="challanform" || $pageUrl=="viewchallanform" || $pageUrl=="addchallanform" || $pageUrl=="editchallanform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>challanform"><i class="fa fa-cubes"></i> Challan Form</a></li>                        
                          <li class="line_height <?php if($pageUrl=="reworkrecordform" || $pageUrl=="edit_rework_record"  || $pageUrl=="reworkrecordlotnumberrecord"){echo 'active';}?>"><a href="<?php echo base_url(); ?>reworkrecordform"><i class="fa fa-cubes"></i> Rework Record Form</a></li>  
                          <li class="line_height <?php if($pageUrl=="balancestockform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>balancestockform"><i class="fa fa-cubes"></i> Balance Stock</a></li>                        
                      
                        </ul>
                      </li>

                      <li class="treeview <?php if($pageUrl=="packinginstaruction" || $pageUrl=="addnewpackinginstruction" || $pageUrl=="addpackinginstractiondetails" || $pageUrl=="editpackinginstraction" || $pageUrl=="exportdetails" || $pageUrl=="addnewExportDetails" || $pageUrl=="editexportdetails" || $pageUrl=="addExportdetailsitems" || $pageUrl=="viewexportdetails" || $pageUrl=="buyerpodetailsreport" || $pageUrl=="chadebitnote" || $pageUrl=="addchadebitnote" || $pageUrl=="editchadebitnote" || $pageUrl=="salestrackingreport" || $pageUrl=="addsalestrackingreport" || $pageUrl=="editsalestrackingreport" || $pageUrl=="salestrackingexcelreport" || $pageUrl=="viewpackinginstraction" || $pageUrl=="viewchadebitnote" || $pageUrl=="viewsalestrackingreport" || $pageUrl=="clonerecordspackinginstraction"){echo 'active';}?>">
                        <a href="#">
                          <i class="fa fa-money"></i> <span class="menu_label">Sales</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" >
                            <li class="line_height <?php if($pageUrl=="buyerpo" || $pageUrl=="addnewBuyerpo"  || $pageUrl=="viewBuyerpo" || $pageUrl=="editBuyerpo" ){echo 'active';}?>"><a href="<?php echo base_url(); ?>buyerpo"><i class="fa fa-cubes"></i> Buyer PO</a></li>
                            <li class="line_height <?php if($pageUrl=="packinginstaruction" || $pageUrl=="addnewpackinginstruction" || $pageUrl=="addpackinginstractiondetails" || $pageUrl=="editpackinginstraction" ||  $pageUrl=="viewpackinginstraction" || $pageUrl=="clonerecordspackinginstraction"){echo 'active';}?>"><a href="<?php echo base_url(); ?>packinginstaruction"><i class="fa fa-cubes"></i> Packing Instructions / Form</a></li>
                            <li class="line_height <?php if($pageUrl=="exportdetails" || $pageUrl=="addnewExportDetails" || $pageUrl=="editexportdetails" || $pageUrl=="addExportdetailsitems" || $pageUrl=="viewexportdetails"){echo 'active';}?>"><a href="<?php echo base_url(); ?>exportdetails"><i class="fa fa-cubes"></i> Export Details</a></li>
                            <li class="line_height <?php if($pageUrl=="buyerpodetailsreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>buyerpodetailsreport"><i class="fa fa-cubes"></i> Buyer PO Details</a></li>
                            <li class="line_height <?php if($pageUrl=="chadebitnote" || $pageUrl=="addchadebitnote" || $pageUrl=="editchadebitnote" || $pageUrl=="viewchadebitnote"){echo 'active';}?>"><a href="<?php echo base_url(); ?>chadebitnote"><i class="fa fa-cubes"></i> CHA Debit Note</a></li>
                            <li class="line_height <?php if($pageUrl=="salestrackingreport" || $pageUrl=="addsalestrackingreport" || $pageUrl=="editsalestrackingreport" || $pageUrl=="viewsalestrackingreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>salestrackingreport"><i class="fa fa-cubes"></i> Sales Tracking Report</a></li>
                            <li class="line_height <?php if($pageUrl=="salestrackingexcelreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>salestrackingexcelreport"><i class="fa fa-cubes"></i> Sales Tracking Excel Report</a></li>
                            <li class="line_height <?php if($pageUrl=="debitnote" || $pageUrl=="addnewdebitnote" || $pageUrl=="editdebitnoteform" || $pageUrl=='editdebitnoteform' || $pageUrl=="viewdebitnoteform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>debitnote"><i class="fa fa-cubes"></i> Debit Note</a></li>
                            <li class="line_height <?php if($pageUrl=="creditnote" || $pageUrl=="addcreditnote" || $pageUrl=="editcreditnote" || $pageUrl=="viewcreditnoteform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>creditnote"><i class="fa fa-cubes"></i> Credit Note</a></li>
                        </ul>
                      </li>

                      <li class="treeview <?php if($pageUrl=="qualityrecord" 
                          || $pageUrl=='addNewqualityrecord' 
                          || $pageUrl=='editqulityrecordform' 
                          || $pageUrl=="complaintform" || $pageUrl=="addcomplaintform" || $pageUrl=="editcomplainform" 
                          || $pageUrl=="suppliervendorcompliant" || $pageUrl=="addnewsuppliervendorcomplaint" 
                          || $pageUrl=="editsuppliervendorcompalint" || $pageUrl=="customercompliant" 
                          || $pageUrl=="addnewcustomercomplaint" 
                          || $pageUrl=="editcustomercomplaint"
                          || $pageUrl=="viewqulityrecordform" || $pageUrl=="viewcustomercomplaint" || $pageUrl=="viewsuppliervendorcompalint"
                          || $pageUrl=="qcchallan" || $pageUrl=="addqcchallan" || $pageUrl=='editqcchallan' || $pageUrl=='viewqcchallan'
                          ){echo 'active';}?>">
                        <a href="#">
                          <i class="fa fa-file-text-o"></i> <span class="menu_label">QC</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" >
                          <li class="line_height <?php if($pageUrl=="qualityrecord" || $pageUrl=='addNewqualityrecord' || $pageUrl=='editqulityrecordform'  || $pageUrl=="viewqulityrecordform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>qualityrecord"><i class="fa fa-cubes"></i> Quality Record</a></li>
                          <!-- <li class="line_height <?php if($pageUrl=="complaintform" || $pageUrl=="addcomplaintform" || $pageUrl=="editcomplainform"){echo 'active';}?>"><a href="<?php echo base_url(); ?>complaintform"><i class="fa fa-cubes"></i> Complaint form</a></li> -->
                          <li class="line_height <?php if($pageUrl=="customercompliant" || $pageUrl=="addnewcustomercomplaint" || $pageUrl=="editcustomercomplaint" || $pageUrl=="viewcustomercomplaint"){echo 'active';}?>"><a href="<?php echo base_url(); ?>customercompliant"><i class="fa fa-cubes"></i> Customer Compliant</a></li>
                          <li class="line_height <?php if($pageUrl=="suppliervendorcompliant" || $pageUrl=="addnewsuppliervendorcomplaint" || $pageUrl=="editsuppliervendorcompalint" || $pageUrl=="viewsuppliervendorcompalint"){echo 'active';}?>"><a href="<?php echo base_url(); ?>suppliervendorcompliant"><i class="fa fa-cubes"></i> Supplier Vendor Compliant</a></li>
                          <li class="line_height <?php if($pageUrl=="qcchallan" || $pageUrl=="addqcchallan" || $pageUrl=='editqcchallan' || $pageUrl=='viewqcchallan'){echo 'active';}?>"><a href="<?php echo base_url(); ?>qcchallan"><i class="fa fa-cubes"></i> QC Challan</a></li>
                        </ul>
                      </li>

                      <li class="treeview <?php if($pageUrl=="store_form" || $pageUrl=="store_form" || $pageUrl=="addstore_form"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>storeform">
                          <i class="fa fa-hdd-o"></i> <span class="menu_label">Store Form</span>
                        </a>
                      </li> 

                      <li class="treeview <?php if($pageUrl=="cbam"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>cbam">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">CBAM</span>
                        </a>
                      </li> 

                      <li class="treeview <?php if($pageUrl=="vendor_rejection_form"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>vendor_rejection_form">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Vendor Rejection Report</span>
                        </a>
                      </li> 



                      <li class="treeview <?php if($pageUrl=="export_history_report"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>export_history_report">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Export History Report</span>
                        </a>
                      </li> 
                      

                      <li class="treeview <?php if($pageUrl=="hourly_inspection_report"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>hourly_inspection_report">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Hourly Inspection Report</span>
                        </a>
                      </li> 

                      <li class="treeview <?php if($pageUrl=="export_inspection_report"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>export_inspection_report">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Export Hourly Inspection</span>
                        </a>
                      </li> 

                      <li class="treeview <?php if($pageUrl=="productionstatusreport"){echo 'active';}?>">
                        <a href="#">
                          <i class="fa fa-user"></i> <span class="menu_label">Production Status</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" >
                        <li class="line_height <?php if($pageUrl=="productionstatusreport"){echo 'active';}?>"><a href="<?php echo base_url(); ?>productionstatusreport"><i class="fa fa-cubes"></i> Production Status Report</a></li>
                        </ul>
                      </li>


                      <li class="treeview <?php if($pageUrl=="tdir" || $pageUrl=="tdir_attachment" || $pageUrl=="addTDIRattachment"){echo 'active';}?>" >
                        <a href="<?php echo base_url(); ?>tdir">
                          <i class="fa fa-file-excel-o"></i> <span class="menu_label">Inspection Report</span>
                        </a>
                      </li> 


                      <?php  if( $this->session->userdata('roleText')=='Superadmin'){ ?>
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
                                  <!-- <li class="line_height <?php if($pageUrl=="log-history-upload"){echo 'active';}?>"><a href="<?php echo base_url(); ?>log-history-upload"><i class="fa fa-upload"></i> Upload Backup</a></li> -->
                                  <!-- <li class="line_height <?php if($pageUrl=="log-history-backup"){echo 'active';}?>"><a href="<?php echo base_url(); ?>log-history-backup"><i class="fa fa-archive"></i> Log Records Backup</a></li> -->
                              </ul>
                          </li>
                      <?php }  ?>


                   <?php  } ?>
         
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