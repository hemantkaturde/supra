<?php $id = $sampling_id; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Instrument
            <!-- <small>Add,Edit,Delete</small> -->
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Store Form</a></li>
                    <li class="active"><a href="javascript:void(0);"> Add Instrument</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="part_no" value="<?=$getSamplingInstrumnetData[0]['fin_id'] ?>" name="part_no">
                    <input type="hidden" class="form-control" id="ticket_no" value="<?=$ticket_no?>" name="ticket_no">
                    <a class="btn btn-primary" href="<?php echo base_url() ?>storeform">
                       <i class="fa fa-arrow-left"></i> Back</a>

                    <!-- <a class="btn btn-primary" href="<?php echo base_url() ?>addnewSamplingmethod/<?php echo $id ?>">
                        <i class="fa fa-plus"></i> Add Instrument</a> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 text-left">
              <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                <h4><b>Part Number :</b> <?=$getSamplingInstrumnetData[0]['part_number'] ?></h4>
              </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="addInstrumentStoreform">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Instrument Name</th>
                                        <th>Grade</th>
                                        <th>Unit</th>
                                        <th>Class</th>
                                        <th>Measuring Size</th>
                                        <th>Type</th>
                                        <th>Remark</th>
                                        <th>Quantity</th>
                                        <th>Live Quanity</th>
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
            <h3 class="modal-title" id="additem">Add Item Quantity</h3>
            </button>
         </div>
         <form role="form" id="editstoreformqtyassigndataform" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>

               
               <input type="hidden" class="form-control"  id="partId_popup" name="partId_popup">
               <input type="hidden" class="form-control"  id="ticket_no_popup" name="ticket_no_popup">
                <input type="hidden" class="form-control" id="instrument_name_popup" name="instrument_name_popup">
                <input type="hidden" class="form-control" id="measuring_size_popup" name="measuring_size_popup">
                <input type="hidden" class="form-control" id="qty_popup" name="qty_popup">

               

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Quantity Assign <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="qty_assign" name="qty_assign" required>
                     <p class="error qty_assign_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label"> Remark </label>
                  <div class="col-sm-8">
                      <textarea class="form-control" id="qty_remark" name="qty_remark" rows="2"></textarea>
                     <p class="error qty_remark_error"></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-xl closesaverejectedform" data-dismiss="modal">Close</button>
               <button type="button" id="editstoreformqtyassigndata" name="editstoreformqtyassigndata" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="removeNewModal" role="dialog" aria-labelledby="removeitem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="removeitem">Remove Item Quantity</h3>
            </button>
         </div>
         <form role="form" id="editstoreformqtyremovedataform" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>

               
              <input type="hidden" class="form-control"  id="assigned_id" name="assigned_id">
                <input type="hidden" class="form-control"  id="partsId_popup" name="partsId_popup">
                <input type="hidden" class="form-control"  id="partId_popup" name="partId_popup">
               <input type="hidden" class="form-control"  id="ticket_no_popup" name="ticket_no_popup">
                <input type="hidden" class="form-control" id="instrument_name_popup" name="instrument_name_popup">
                <input type="hidden" class="form-control" id="measuring_size_popup" name="measuring_size_popup">
                <input type="hidden" class="form-control" id="qty_popup" name="qty_popup">

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Quantity Received <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="qty_removed" name="qty_removed" required>
                     <p class="error qty_removed_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label"> Remark </label>
                  <div class="col-sm-8">
                      <textarea class="form-control" id="qty_rec_remark" name="qty_rec_remark" rows="2"></textarea>
                     <p class="error qty_rec_remark_error"></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-xl closesaverejectedform" data-dismiss="modal">Close</button>
               <button type="button" id="editstoreformqtyremovedata" name="editstoreformqtyremovedata" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>