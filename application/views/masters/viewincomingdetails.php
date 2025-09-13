<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Incoming Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Incoming Details Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">View Incoming Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewincomingdetailsform" action="<?php echo base_url() ?>addnewincomingdetailsform" method="post" role="form">
                            <div class="box-body">
                                
                                <input readonly type="hidden" class="form-control" id="incomingdetail_editid" name="incomingdetail_editid" value="<?php echo $edit_id;?>" readonly>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="incoming_no">Incoming ID No <span class="required">*</span></label>
                                            <input readonly type="text" class="form-control" id="incoming_no" name="incoming_no" value="<?=$getPreviousincomingdetailsforedit[0]['incoming_details_id']?>" required readonly>
                                            <p class="error incoming_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control " name="vendor_name" id="vendor_name" readonly>
                                                    <option  st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getPreviousincomingdetailsforedit[0]['vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <?php 
                                    if($getPreviousincomingdetailsforedit[0]['po_number']){
                                        $selected_value = $getPreviousincomingdetailsforedit[0]['po_number'];

                                    }else{
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select readonly class="form-control vendor_po_number_itam_mapping" name="vendor_po_number" id="vendor_po_number" readonly>
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <option st-id="" value="<?=$getPreviousincomingdetailsforedit[0]['venpo']?>" selected ><?=$selected_value;?></option>

                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="reported_by">Report By</label>
                                                   <input readonly type="text" class="form-control" id="reported_by" value="<?=$getPreviousincomingdetailsforedit[0]['reported_by'] ?>" name="reported_by">
                                                <p class="error reported_by_error"></p>
                                            </div>
                                    </div>


                                    
                                    <?php if($getAllitemdetails[0]['pre_report_date']=='0000-00-00'){
                                                    $report_date = '';
                                        }else{
                                                    // $report_date = $getAllitemdetails[0]['pre_report_date'];
                                                    if( $getAllitemdetails[0]['pre_report_date']){
                                                        $report_date = $getAllitemdetails[0]['pre_report_date'];
                                                    }else{
                                                        $report_date =  date('Y-m-d');

                                                    }
                                        }
                                        ?>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Previous Report Date</label>
                                                  <input readonly type="text" class="form-control"  value="<?=$report_date ?>" id="previous_reported_date" name="previous_reported_date" readonly>
                                                <p class="error previous_reported_date_error"></p>
                                            </div>
                                    </div>


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Report Date</label>
                                                  <input readonly type="text" class="form-control datepicker"  value="<?=date('Y-m-d')?>" id="reported_date" name="reported_date">
                                                <p class="error reported_date_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea readonly type="text" class="form-control"  id="remark"  name="remark"><?=$getPreviousincomingdetailsforedit[0]['incomig_remark'] ?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div>
                                    <p><b>Note:</b> If you edit or delete any item entry you need to update the enteries
                                        made after the edit/deleted entries for incoming balance qty in pcs </p>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">

                                    <div style="display:flex">
                                           <!-- <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/> -->
                                        
                                            <select class="form-control" name="part_number_serach_edit" id="part_number_serach_edit" style="width: 300px;margin-left: 30px;">
                                                <option value="NA">Filer Item List By Part Name</option>
                                                <?php foreach ($getAllitemdetailsforfilteredit as $key => $getAllitemdetails_val) {?>        
                                                    <option value="<?php echo $getAllitemdetails_val['fin_id']; ?>"><?php echo $getAllitemdetails_val['part_number']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>       
                                        <br/><br/>
                                        
                                            <!-- <table class="table table-bordered" style="max-width: 68%;display: block;overflow-x: auto; white-space: nowrap;" id="view_incomingdetailss_item_on_edit">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>FG Part No</th>
                                                        <th>Description</th>
                                                        <th>Lot Number</th>
                                                        <th>P.O.Qty (in Pcs)</th>
                                                        <th>Invoice Qty (in Pcs)</th>
                                                        <th>Balance Qty in Pcs</th>
                                                        <th>Invoice Qty (in Kgs)</th>
                                                        <th>Invoice No.</th>
                                                        <th>Invoice Date.</th>
                                                        <th>Net weight (in Kgs)</th>
                                                        <th>Challan No.</th>
                                                        <th>Challan Date.</th>
                                                        <th>Received Date</th>
                                                        <th>FG Material Gross Weight</th>
                                                        <th>Units</th>
                                                        <th>No. of Boxes / Goni / Bundle</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                        $invoice_qty=0;
                                                           foreach ($getAllitemdetails as $key => $value) :
                                                           $count++;

                                                           
                                                           $invoice_qty += $value['invoice_qty'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['name'];?></td>
                                                        <td><?php echo $value['part_number'].' - '.$value['lot_no'];?></td>
                                                        <td><?php echo $value['p_o_qty'];?></td>
                                                        <td><?php echo $value['invoice_qty'];?></td>
                                                       


                                                        <?php
                                                            $CI =& get_instance();
                                                            $CI->load->model('Admin_model');
                                                            $result_previous_qty = $CI->Admin_model->getPreviousrecordforbalenceqtyedit($value['incoming_details_item_id'],$value['mainincoming'],$value['part_number']);
                                                            $balence_qty = $value['p_o_qty'] -$value['invoice_qty'];

                                                            if($count == 1){
                                                                $balence_qty_val =  $balence_qty;
                                                            }else{
                                                                $balence_qty_val =  $balence_qty;
                                                            }
                                                         ?>


                                                        <td><?php echo $value['balance_qty'];?></td>
                                                        <td><?php echo $value['invoice_qty_in_kgs'];?></td>
                                                        <td><?php echo $value['invoice_no'];?></td>
                                                        <td><?php echo $value['invoice_date'];?></td>
                                                        <td><?php echo $value['net_weight'];?></td>
                                                        <td><?php echo $value['challan_no'];?></td>
                                                        <td><?php echo $value['challan_date'];?></td>
                                                        <td><?php echo $value['received_date'];?></td>
                                                        <td><?php echo $value['fg_material_gross_weight'];?></td>
                                                        <td><?php echo $value['units'];?></td>
                                                        <td><?php echo $value['boxex_goni_bundle'];?></td>
                                                       
                                                        <td><?php echo $value['remarks'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['incoming_details_item_id'];?>' class='fa fa-trash-o deleteIncomingDetailsitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table> -->

                                            <table class="table table-bordered" style="max-width: 68%;display: block;overflow-x: auto; white-space: nowrap;width: 70%; !important" id="view_incomingdetailss_item_on_edit">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>FG Part No</th>
                                                        <th>Description</th>
                                                        <th>Lot Number</th>
                                                        <th>P.O.Qty (in Pcs)</th>
                                                        <th>Invoice Qty (in Pcs)</th>
                                                        <th>Balance Qty in Pcs</th>
                                                        <th>Invoice Qty (in Kgs)</th>
                                                        <th>Invoice No.</th>
                                                        <th>Invoice Date.</th>
                                                        <th>Net weight (in Kgs)</th>
                                                        <th>Challan No.</th>
                                                        <th>Challan Date.</th>
                                                        <th>Received Date</th>
                                                        <th>FG Material Gross Weight</th>
                                                        <th>Units</th>
                                                        <th>No. of Boxes / Goni / Bundle</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><b>Total</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                    </div>

                                        <div class="container">
                                         
                                         <div id="rejection-list">
                                         </div>

                                    </div>
                                      <!-- Add New Package Modal -->
                                      <?php $this->load->helper("form"); ?>

                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <input readonly type="hidden" class="form-control"  id="incoiming_details_item_id" name="incoiming_details_item_id" required readonly>

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                </button>
                                            </div>
                                            <form role="form" id="saveincomingitemform" action="<?php echo base_url() ?>saveincomingitemform" method="post" role="form">

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">FG Part No <span class="required">*</span> (<small>Finished Goods Master</small>)</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <?php foreach ($finishgoodList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['fin_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">FG Part Description<span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input readonly type="text" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">P.O.Qty (In Pcs)<span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="number" class="form-control"  id="p_o_qty" name="p_o_qty" readonly>
                                                            <p class="error p_o_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Net weight (In Kgs) <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="net_weight" name="net_weight" readonly>
                                                            <p class="error net_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Invoice No <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="invoice_no" name="invoice_no">
                                                            <p class="error invoice_no_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Invoice Date <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control datepicker"  id="invoice_date" name="invoice_date">
                                                            <p class="error invoice_date_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Challan No <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="challan_no" name="challan_no">
                                                            <p class="error challan_no_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Challan Date <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control datepicker"  id="challan_date" name="challan_date">
                                                            <p class="error challan_date_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Received Date <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control datepicker"  id="received_date" name="received_date">
                                                            <p class="error received_date_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Invoice Qty (in Pcs) <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="number" class="form-control"  id="invoice_qty" name="invoice_qty">
                                                            <p class="error invoice_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Invoice Qty (in Kgs) <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="number" class="form-control"  id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                                            <p class="error invoice_qty_in_kgs_error"></p>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Balance Qty (in Pcs) <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="number" class="form-control"  id="balance_qty" name="balance_qty" readonly>
                                                            <p class="error balance_qty_error"></p>
                                                        </div>
                                                    </div> -->

                                                    
                                                    <div class="form-group row">
                                                    <input readonly type="hidden" class="form-control"  id="balance_qty" name="balance_qty" readonly>

                                                        <label class="col-sm-3 col-form-label">FG Material Gross Weight <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="fg_material_gross_weight" name="fg_material_gross_weight">
                                                            <p class="error fg_material_gross_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Units <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <select class="form-control" name="units" id="units">
                                                                <option value="">Select Part Name</option>
                                                                <option value="kgs">Kgs</option>
                                                                <option value="Pcs">Pcs</option>
                                                                <option value="Nos">Nos</option>
                                                                <option value="Sheet">Sheet</option>
                                                               <option value="Set">Set</option>
<option value="Mtr">Mtr</option>
<option value="Ltr">Ltr</option>
                                                             </select>
                                                            <p class="error units_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">No. of Boxes / Goni / Bundle <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="number" class="form-control"  id="boxex_goni_bundle" name="boxex_goni_bundle">
                                                            <p class="error boxex_goni_bundle_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Lot No. <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="lot_no" name="lot_no">
                                                            <p class="error lot_no_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Remarks</label>
                                                        <div class="col-sm-9">
                                                            <input readonly type="text" class="form-control"  id="remarks" name="remarks">
                                                            <p class="error remarks_error"></p>
                                                        </div>
                                                    </div>
                                                
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeIncomingDetailsmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveincomingitem" name="saveincomingitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
                                                </div>

                                            </form>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                               

                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                    <?php if($getAllitemdetails){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>

                                    <input readonly type="button" onclick="location.href = '<?php echo base_url() ?>incomingdetails'" class="btn btn-default" value="Back" />
                                </div>
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
