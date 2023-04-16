<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Export Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Export Details Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add New Export Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnExportDetailsform" action="<?php echo base_url() ?>addnExportDetailsform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">

                                    <?php
                                        if($getpreviousexportdetailsinstarction[0]['export_details_id']){
                                            $arr = str_split($getpreviousexportdetailsinstarction[0]['export_details_id']);
                                            $i = end($arr);
                                            $inrno= "SQEX2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            $export_details_id = $inrno;
                                        }else{
                                            $export_details_id = 'SQEX23240001';
                                        }
                                    ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="export_id_number">Export Id Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="export_id_number" name="export_id_number"  value="<?php echo $export_details_id; ?>" required readonly>
                                            <p class="error export_id_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_name">Select Buyer Name <span class="required">*</span></label>
                                                <select class="form-control buyer_po_number_for_itam_mapping" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                                <option value="<?php echo $value['buyer_id']; ?>"><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                </select> 
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                       <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer Po Number<span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remarks</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark"> </textarea><p class="error fax_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="saveexportdetails" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>exportdetails'" class="btn btn-default" value="Back" />
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>