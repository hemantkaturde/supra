<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Packing Instructions
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Instructions Master</a></li>
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
                            <h3 class="box-title">Add New Packing Instructions</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewpackinginstruction" action="<?php echo base_url() ?>addnewpackinginstructionform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="packing_id_number">Packing Id Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="packing_id_number" name="packing_id_number" required>
                                            <p class="error packing_id_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_name" name="buyer_name" required>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="buyer_po">Buyer PO <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_po" name="buyer_po" required>
                                                <p class="error buyer_po_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" required>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_invoice_number">Buyer Invoice Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_number" name="buyer_invoice_number" required>
                                            <p class="error buyer_invoice_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_invoice_date">Buyer Invoice Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_date" id="buyer_invoice_date"  name="buyer_invoice_date">
                                            <p class="error buyer_invoice_date_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_invoice_qty">Buyer Invoice Qty <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_qty" id="buyer_invoice_qty"  name="buyer_invoice_qty">
                                            <p class="error buyer_invoice_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="box_qty">Box Qty</label>
                                            <input type="text" class="form-control" id="box_qty" name="box_qty">
                                            <p class="error box_qty_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remarks</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark" required> <?=$fetchALLpresupplieritemList[0]['pre_remark'];?></textarea>                                            <p class="error fax_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewUSP" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>uspmaster'" class="btn btn-default" value="Back" />
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