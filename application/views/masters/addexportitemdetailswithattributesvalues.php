<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Pre Export Item Attributes
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add New Pre Export Item Attributes</a></li>
                </ul>
            </small>
        </h1>

        <h4>
            <p><b>Pre Export Invoice Number :</b> <?=$getexportetails[0]['pre_export_invoice_no'] ?></p>
            <p><b>Pre Export Buyer Name :</b> <?=$getexportetails[0]['buyer_name'] ?></p>
            <p><b>Pre Export Buyer PO Number :</b> <?=$getexportetails[0]['sales_order_number'] ?></p>
            <p><b>Part Number :</b> <?=$getexportetails[0]['part_number'] ?></p>
        </h4>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Pre-Export Item Details Attributes</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addexportitemdetailswithattributesvaluesform" action="<?php echo base_url() ?>addexportitemdetailswithattributesvaluesform" method="post" role="form">
                            
                        <input type="hidden" class="main_export_id" id="main_export_id" value=<?=$main_export_id?> name="main_export_id">
                        <input type="hidden" class="buyer_po_id" id="buyer_po_id" value=<?=$buyer_po_id?> name="buyer_po_id">
                        <input type="hidden" class="preexportitemdetailsid" id="preexportitemdetailsid" value="<?=$preexportitemdetailsid?>" name="preexportitemdetailsid">

                        <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                               <label for="gross_per_box_weight">Gross Per Box Weight <span class="required">*</span></label>
                                               <input type="number" class="form-control" id="gross_per_box_weight" name="gross_per_box_weight">
                                            <p class="error gross_per_box_weight_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="no_of_cartoons">No Of Cartons <span class="required">*</span></label>
                                               <input type="number" class="form-control" id="no_of_cartoons" name="no_of_cartoons">
                                            <p class="error no_of_cartoons_error"></p>
                                        </div>
                                    </div>
                                </div>   


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="no_of_packtes">No Of Packets <span class="required">*</span></label>
                                               <input type="number" class="form-control" id="no_of_packtes" name="no_of_packtes" value="0">
                                            <p class="error no_of_packtes_error"></p>
                                        </div>
                                    </div>
                                </div>   
                                
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="per_boc_pcs">Per Box Pcs <span class="required">*</span></label>
                                               <input type="number" class="form-control" id="per_boc_pcs" name="per_boc_pcs">
                                            <p class="error per_boc_pcs_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="total_qty">Total Qty <span class="required">*</span></label>
                                               <input type="number" class="form-control" id="total_qty" name="total_qty" readonly>
                                            <p class="error total_qty_error"></p>
                                        </div>
                                    </div>
                                </div>    


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="total_net_weight">Total Net Weight</label>
                                               <input type="number" class="form-control" id="total_net_weight" name="total_net_weight">
                                            <p class="error total_net_weight_error"></p>
                                        </div>
                                    </div>
                                </div>    


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="total_gross_weight">Total Gross Weight</label>
                                               <input type="number" class="form-control" id="total_gross_weight" name="total_gross_weight" readonly>
                                            <p class="error total_gross_weight_error"></p>
                                        </div>
                                    </div>
                                </div>    

                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remark </label>
                                            <textarea type="text" class="form-control"  id="remark"  name="remark"></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addexportitemdetailswithattributesvalues" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>addexportitemdetailswithattributes/<?=$preexportitemdetailsid?>'" class="btn btn-default" value="Back" />
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
   $(function() {
			$(".datepicker").datepicker({ 
				// minDate: 0,
				todayHighlight: true,
                 dateFormat: 'yy-mm-dd',
				startDate: new Date()
			});
		});
</script>