<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Stock Rejection Form Item Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Stock Rejection Form Item Details</a></li>
                </ul>
            </div>

            <div class="col-xs-6 text-right">
                <div class="form-group">
                   <input type="button" onclick="location.href = '<?php echo base_url() ?>addrejectionformitemsdata/<?=$rejection_form_id?>'" class="btn  btn-primary" value="Back" />
                </div>
            </div>

        </div>

        <input type="hidden" class="form-control"  id="rejection_form_id" name="rejection_form_id"  value="<?=$rejection_form_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_item_id" name="vendor_po_item_id"  value="<?=$vendor_po_item_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_id" name="vendor_po_id"  value="<?=$vendor_po_id?>">   

        <input type="hidden" class="form-control"  id="net_weight_fg" name="net_weight_fg"  value="<?=$net_weight_fg?>">   

        <div class="row">
            <div class="col-xs-10">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_stock_rejection_form_ttem_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Rejection Reason</th>
                                        <th>Qty (In Pcs)</th>
                                        <th>Qty (In Kgs)</th>
                                        <th>Remark</th>
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


<?php $this->load->helper("form"); ?>
<div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="additem">Add Item Details</h3>
            </button>
         </div>
         <form role="form" id="editrejectedformitemdataform" action="<?php echo base_url() ?>editrejectedformitemdataform" method="post" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>

               <input type="hidden" class="form-control"  id="rejection_form_id_popup" name="rejection_form_id_popup">

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Rejected Reason <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="type" class="form-control"  id="rejected_reason" name="rejected_reason" required>
                     <p class="error rejected_reason_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Qty (In Pcs) <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="qty_in_pcs" name="qty_in_pcs">
                     <p class="error qty_in_pcs_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Qty (In Kgs) <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="qty_in_kgs" name="qty_in_kgs" readonly>
                     <p class="error qty_in_kgs_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Remark</label>
                  <div class="col-sm-8">
                     <textarea type="text" class="form-control"  id="remark"  name="remark"></textarea>
                     <p class="error remark_error"></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-xl closesaverejectedform" data-dismiss="modal">Close</button>
               <button type="submit" id="editrejectedformitemdata" name="editrejectedformitemdata" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>