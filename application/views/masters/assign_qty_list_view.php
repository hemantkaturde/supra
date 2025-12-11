<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-eye"></i> Assigned Quantity List
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"> Assigned Qty</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <input type="hidden" id="ticket_no" value="<?= $ticket_no ?>">
                    <input type="hidden" id="instrument_name" value="<?= $instrument_name ?>">
                    <input type="hidden" id="measuring_size" value="<?= $measuring_size ?>">
                    <input type="hidden" id="part_id" value="<?= $part_id ?>">
                    <input type="hidden" id="part_number" value="<?= $part_number ?>">
                    <!-- <input type="button" onclick="window.close();" class="btn btn-primary" value="Back" /> -->
                   <a class="btn btn-primary" href="<?php echo base_url('addInstrumentStoreform/'.$part_id.'/'.$ticket_no); ?>">
                       <i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>

        <h4>Ticket No: <b><?= $ticket_no ?></b>
        | Part Number : <b><?=$part_number ?></b>
        | Instrument: <b><?= $instrument_name ?></b>
        | Measuring Size: <b><?= $measuring_size ?></b></h4>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="assign_qty_list_view">
                            <thead>
                                <tr style="background-color:#3c8dbc;color:#fff">
                                    <th>Instruments Name</th>
                                    <th>Measuring Size</th>
                                    <th>Qty Assigned</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody> <!-- DATA WILL COME FROM DATATABLE AJAX -->
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?php $this->load->helper("form"); ?>
<div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="additem">Add Item Quantity</h3>
            </button>
         </div>
         <form role="form" id="editstoreformqtylistassigndataform" role="form">
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