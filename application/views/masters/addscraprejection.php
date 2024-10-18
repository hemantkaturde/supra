<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Scrap Rejection Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Scrap Rejection Item Details</a></li>
                </ul>
            </div>

            <div class="col-xs-6 text-right">
                <div class="form-group">
                     <p><b>Vendor Name</b> : <?=$getalldataofeditrejectionform['vendor_name']; ?></p>
                     <p><b>Vendor PO</b> : <?=$getalldataofeditrejectionform['po_number']; ?></p>
                     <p><b>Part Number</b> : <?=$getitemdetailsusingvendorpoitems['part_number']; ?></p>

                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Scrap Rejection</button>          
                    <input type="button" onclick="location.href = '<?php echo base_url() ?>addrejectionformitemsdata/<?=$rejection_form_id?>'" class="btn  btn-primary" value="Back" />
                </div>
            </div>

        </div>

        <input type="hidden" class="form-control"  id="rejection_form_id" name="rejection_form_id"  value="<?=$rejection_form_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_item_id" name="vendor_po_item_id"  value="<?=$vendor_po_item_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_id" name="vendor_po_id"  value="<?=$vendor_po_id?>">   
        <!-- <input type="hidden" class="form-control"  id="net_weight_fg" name="net_weight_fg"  value="<?=$net_weight_fg?>">    -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_stock_rejectiondetails">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Scrap Date</th>
                                        <th>Scrap Type</th>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="additem">Add Scrap Rejection </h3>
            </button>
         </div>
         <form role="form" id="savescraprejectiondetailsform" action="<?php echo base_url() ?>savescraprejectiondetailsform" method="post" role="form">
            <div class="modal-body">
               <div class="loader_ajax" style="display:none;">
                  <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
               </div>
               
                <input type="hidden" class="form-control"  id="rejection_form_id" name="rejection_form_id"  value="<?=$rejection_form_id?>">   
                <input type="hidden" class="form-control"  id="vendor_po_item_id" name="vendor_po_item_id"  value="<?=$vendor_po_item_id?>">   
                <input type="hidden" class="form-control"  id="vendor_po_id" name="vendor_po_id"  value="<?=$vendor_po_id?>">   


               <input type="hidden" class="form-control"  id="scrap_rejection_details_id_popup" name="scrap_rejection_details_id_popup">

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Scrap Date  <span class="required">*</span></label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control datepicker"  id="scrap_date" name="scrap_date" required>
                     <p class="error scrap_date_error"></p>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Scrap Type<span class="required">*</span></label>
                  <div class="col-sm-8">
                        <select class="form-control serachfilternotrequired searchfilter" name="scrap_type" id="scrap_type">
                            <option st-id="" value="">Select Status</option>
                            <option value="Brass">Brass</option>
                            <option value="Copper">Copper</option>
                            <option value="Aluminium">Aluminium</option>
                            <option value="SS 304">SS 304</option>
                            <option value="SS 316">SS 316</option>
                            <option value="SS 303">SS 303</option>
                            <option value="SS 316 L">SS 316 L</option>
                            <option value="SS 304 L">SS 304 L</option>
                            <option value="SS 316 Ti">SS 316 Ti</option>
                            <option value="Duplex">Duplex</option>
                            <option value="Inconnel">Inconnel</option>
                            <option value="PFTE- Teflon Sheet">PFTE- Teflon Sheet</option>
                            <option value="EN1A Leaded">EN1A Leaded</option>
                            <option value="EN1A Non – Leaded">EN1A Non – Leaded</option>
                            <option value="MS">MS</option>
                        </select>
                     <p class="error scrap_type_error"></p>
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
               <button type="button" class="btn btn-secondary btn-xl closescraprejection" data-dismiss="modal">Close</button>
               <button type="submit" id="savescraprejectiondetails" name="savescraprejectiondetails" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
            </div>
         </form>
      </div>
   </div>
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