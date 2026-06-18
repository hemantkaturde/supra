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
                                        <th>Part Number</th>
                                        <th>Description</th>
                                        <th>Type of Raw Material</th>
                                        <th>RM Actual Qty</th>
                                        <th>Expected Qty</th>
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


<?php $this->load->helper("form"); ?>
<div class="modal fade" id="addnewforginscrappopupdetails" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="additem">Forgin Scrap Report Details</h3>
            </button>
         </div>
         <form role="form" id="saveforginscrapreportdetailsform" action="<?php echo base_url() ?>saveforginscrapreportdetailsform" method="post" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>

               <input type="hidden" class="form-control"  id="item_id_popup" name="item_id_popup">
               <input type="hidden" class="form-control"  id="forgin_id_popup" name="forgin_id_popup" value="<?=$forgin_id;?>">
               <input type="hidden" class="form-control"  id="vendor_id_popup" name="vendor_id_popup" value="<?=$vendor_po_id_master;?>">


               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">RM Actual Qty</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="rm_actual_qty_popup" name="rm_actual_qty_popup">
                     <p class="error rm_actual_qty_popup_error"></p>
                  </div>
               </div>


               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Expected Qty</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="expected_qty_popup" name="expected_qty_popup">
                     <p class="error expected_qty_popup_error"></p>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label"><h4><b style="color:blue">Hiya To Divya</b></h4></label>
                </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Sent RM (In kgs)<span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="sent_rm_in_kgs_section_1" name="sent_rm_in_kgs_section_1" required>
                     <p class="error sent_rm_in_kgs_section_1_error"></p>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Exp Qty (in pcs) <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="exp_qty_in_pcs_section_1" name="exp_qty_in_pcs_section_1">
                     <p class="error exp_qty_in_pcs_section_1_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Diff (in kgs)</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="diff_in_kgs_section_1" name="diff_in_kgs_section_1">
                     <p class="error diff_in_kgs_section_1_error"></p>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label"><h4><b style="color:blue">Divya To Vendor</b></h4></label>
                </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Vendor Name</label>
                  <div class="col-sm-8">
                        <select class="form-control serachfilternotrequired" name="vendor_id" id="vendor_id">
                           <option st-id="" value="">Select Vendor Name</option>
                              <?php foreach ($vendorList as $key => $value) {?>
                              <option value="<?php echo $value['ven_id'];?>"><?php echo $value['vendor_name']; ?></option>
                              <?php } ?>
                        </select>
                     <p class="error vendor_id_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Sent RM (In kgs) </label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="sent_rm_in_kgs_section_2"  name="sent_rm_in_kgs_section_2"></input>
                     <p class="error sent_rm_in_kgs_section_2_error"></p>
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Exp Qty (in pcs)</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="exp_qty_in_pcs_section_2"  name="exp_qty_in_pcs_section_2"></input>
                     <p class="error exp_qty_in_pcs_section_2_error"></p>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Diff (in kgs)</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="diff_in_kgs_section_2"  name="diff_in_kgs_section_2"></input>
                     <p class="error diff_in_kgs_section_2_error"></p>
                  </div>
               </div>


                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Total Scrap (in kgs)</label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control"  id="total_scrap_section_2"  name="total_scrap_section_2"></input>
                     <p class="error total_scrap_section_2_error"></p>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Remark</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control"  id="remark_section_2"  name="remark_section_2"></input>
                     <p class="error remark_section_2_error"></p>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-xl closerejectionreworkitemdata" data-dismiss="modal">Close</button>
               <button type="submit" id="saveforginscrapreportdetailsdata" name="saveforginscrapreportdetailsdata" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#vendor_id').select2({
        placeholder: 'Select Vendor Name',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    });
});
</script>