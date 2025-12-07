<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Rework Record Reason Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Rework Record Reason Details</a></li>
                    <input readonly  type="hidden" class="form-control" id="incoming_details_item_id" value="<?=$incoming_details_item_id?>" name="incoming_details_item_id" readonly>
                </ul>
            </div>

             <div class="col-xs-6 text-right">
                <div class="form-group">
                   <!-- <input type="button" onclick="location.href = '<?php echo base_url() ?>reworkrecordlotnumberrecord/'<?=$main_rework_data?>" class="btn  btn-primary" value="Back" /> -->

                                      <input type="button" onclick="location.href = '<?php echo base_url() ?>reworkrecordlotnumberrecord/<?=$main_rework_data?>'" class="btn  btn-primary" value="Back" />

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover rework_record_reason_details" id="rework_record_reason_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Reason</th>
                                        <th>Rework Qty (in pcs)</th>
                                        <th>After Rework OK Qty (in pcs)</th>
                                        <th>After Rework Rej Qty (in pcs)</th>
                                        <th>Rework Done By</th>   
                                        <th>Rework Checked By</th>   
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



<?php $this->load->helper("form"); ?>
<div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="additem">Rework Details</h3>
            </button>
         </div>
         <form role="form" id="editrejectionreworkitemdataform" action="<?php echo base_url() ?>editrejectionreworkitemdataform" method="post" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>

               <input type="hidden" class="form-control"  id="incoming_item_data_id" name="incoming_item_data_id">
               <input type="hidden" class="form-control"  id="rework_id" name="rework_id">
               <input type="hidden" class="form-control"  id="rework_reson_id_main" name="rework_reson_id_main">

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Reason <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="type" class="form-control"  id="rejected_reason" name="rejected_reason" required>
                     <p class="error rejected_reason_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Rework Qty (in pcs) <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="rework_qty_in_pcs" name="rework_qty_in_pcs">
                     <p class="error rework_qty_in_pcs_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">After Rework OK Qty (in pcs)</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="after_rework_ok_in_pcs" name="after_rework_ok_in_pcs">
                     <p class="error after_rework_ok_in_pcs_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">After Rework Rej Qty (in pcs)</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control"  id="after_rework_rej_qty_in_pcs"  name="after_rework_rej_qty_in_pcs"></input>
                     <p class="error after_rework_rej_qty_in_pcs_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Rework Done By</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control"  id="rework_done_by"  name="rework_done_by"></input>
                     <p class="error rework_done_by_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Rework Checked By</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control"  id="rework_checked_by"  name="rework_checked_by"></input>
                     <p class="error rework_checked_by_error"></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-xl closerejectionreworkitemdata" data-dismiss="modal">Close</button>
               <button type="submit" id="editrejectionreworkitemdata" name="editrejectionreworkitemdata" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>