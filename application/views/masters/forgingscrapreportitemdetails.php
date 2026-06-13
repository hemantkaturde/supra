<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Forging Scarp Working Item Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-4 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Forging Scarp Working Item Details</a></li>
                </ul>

              
            </div>
            <div class="col-xs-8 text-right">
                <div class="form-group">
                  <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <p> <b style="color: blue">Vendor Name : </b><?=$getPreviousforgindata[0]['vendor_name_from_vendor'];?>
                        <b style="color: blue"> | Vendor PO : </b><?=$getPreviousforgindata[0]['vendor_po_number_master'];?>
                        <b style="color: blue"> | Supplier Name : </b><?=$getPreviousforgindata[0]['supplier_master_name'];?>
                        <b style="color: blue"> | Supplier PO : </b><?=$getPreviousforgindata[0]['supplier_po_master'];?></p>
                </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">

                           <input type="hidden" id="forgin_id" name="forgin_id" value="<?= $forgin_id ?>">
                           <input type="hidden" id="vendor_po_id_master" name="vendor_po_id_master" value="<?=$vendor_po_id_master ?>">
                                                               

                            <table width="100%" class="table table-striped table-bordered table-hover" id="forging_scarp_working_item_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Part Name</th>
                                        <th>Part Number</th>
                                        <th>Description</th>
                                        <th>Type of Raw Material</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>