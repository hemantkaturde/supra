<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Bill of Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Bill of Material</a></li>
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
                            <h3 class="box-title">View Bill of Material Work</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewbillofmaterialform" action="<?php echo base_url() ?>addnnewbillofmaterialform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <input readonly  type="hidden" class="form-control" id="bom_id_edit" name="bom_id_edit" value="<?=$getbillofmaterialdataforedit['bomidedit']?>" required readonly>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bom_number">BOM Number<span class="required">*</span></label>
                                            <input readonly  type="text" class="form-control" id="bom_number" name="bom_number" value="<?=$getbillofmaterialdataforedit['bom_number']?>" required readonly>
                                            <p class="error bom_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">BOM Date <span class="required">*</span></label>
                                            <input readonly  type="text" class="form-control datepicker"  value="<?=$getbillofmaterialdataforedit['bomdate']?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select readonly  class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getbillofmaterialdataforedit['bomvendor']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select readonly  class="form-control vendor_po_number_itam_mapping vendor_po_number_for_view_item vendor_po_for_buyer_details_ vendor_po_for_incoming_details vendor_po_for_buyer_details_date_and_podetails" name="vendor_po_number" id="vendor_po_number">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <option st-id="" value="<?=$getbillofmaterialdataforedit['vendor_po_id']?>" Selected><?=$getbillofmaterialdataforedit['po_number']?></option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name</label>
                                                <input readonly  type="text" class="form-control" id="supplier_name" value="<?=$getbillofmaterialdataforedit['supplier_name']?>" name="supplier_name" readonly>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_po_number">Supplier PO Number</label>
                                                <input readonly  type="text" class="form-control supplier_po_number" id="supplier_po_number" value="<?=$getbillofmaterialdataforedit['supplier_po_number']?>" name="supplier_po_number" readonly>
                                            <p class="error supplier_po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_po_date">Supplier PO Date</label>
                                                <input readonly  type="text" class="form-control" id="supplier_po_date" value="<?=$getbillofmaterialdataforedit['supplier_po_date']?>" name="supplier_po_date" readonly>
                                            <p class="error supplier_po_date_error"></p>
                                        </div>
                                    </div>

                                  <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select readonly  class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($getbillofmaterialdataforedit['bill_of_buyer_id']== $value['buyer_id']){ echo 'selected'; } ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO <span class="required">*</span></label>
                                                    <select readonly  class="form-control buyer_po_number  buyer_po_number_for_itam_mapping buyer_po_number_for_itam_display autobuyerpo" name="buyer_po_number" id="buyer_po_number">
                                                        <!-- <option st-id="" value="">Select Buyer PO</option> -->

                                                        <option st-id="" value="<?=$getbillofmaterialdataforedit['buyer_po_number'] ?>"><?=$getbillofmaterialdataforedit['sales_order_number'].'-'.$getbillofmaterialdataforedit['bp_number'] ?></option>
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_date">Buyer PO Date<span class="required">*</span></label>
                                                <input readonly  type="text" class="form-control" id="buyer_po_date" value="<?=$getbillofmaterialdataforedit['buyer_po_date'] ?>" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>

                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_delivery_date">Buyer Delivery Date<span class="required">*</span></label>
                                                <input readonly  type="text" class="form-control" id="buyer_delivery_date" value="<?=$getbillofmaterialdataforedit['buyer_delivery_date'] ?>"  name="buyer_delivery_date" required readonly>
                                            <p class="error buyer_delivery_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="bom_status">Status <span class="required">*</span></label>
                                                <select readonly  class="form-control bom_status" name="bom_status" id="bom_status">
                                                    <option st-id="" value="">Select Status Name</option>
                                                    <option value="OPEN" <?php if($getbillofmaterialdataforedit['bom_status']== 'OPEN'){ echo 'selected'; } ?>>OPEN</option>
                                                    <option value="CLOSE" <?php if($getbillofmaterialdataforedit['bom_status']== 'CLOSE'){ echo 'selected'; } ?>>CLOSE</option>
                                                </select>
                                            <p class="error bom_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="incoming_details">Incoming Details </label>
                                                <select readonly  class="form-control  incoming_details_item_list_display" name="incoming_details" id="incoming_details">
                                                    <option st-id="" value="">Select Incoming Details</option>
                                                    <?php foreach ($incoming_details as $key => $value) {
                                                        if($getbillofmaterialdataforedit['incoming_details']== $value['id']){ ?>
                                                            <option value="<?php echo $value['id']; ?>" <?php if($getbillofmaterialdataforedit['incoming_details']== $value['id']){ echo 'selected'; } ?>><?php echo $value['incoming_details_id']; ?></option>
                                                       <?php }  ?>
                                                    <?php } ?>
                                                </select>
                                            <p class="error incoming_details_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input readonly  type="text" class="form-control" id="remark" name="remark" value="<?=$getbillofmaterialdataforedit['remark'] ?>">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="container" style="width: 140%;">
                                            <table class="table table-bordered" style="">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>RM Order Qty</th>
                                                        <th>Rm Actual Qty</th>
                                                        <th>RM Type</th>
                                                        <th>Slitting Size</th>
                                                        <!-- <th>Diameter</th>
                                                        <th>Thickness</th>
                                                        <th>Hex A/F </th> -->
                                                        <th>Gross Weight</th>
                                                        <th>Expected Qty</th>
                                                        <th>Vendor Actual Received Qty</th>
                                                        <th>Net Weight Per Pcs</th>
                                                        <th>Total Net Weight</th>
                                                        <th>Short Excess</th>
                                                        <th>Scrap In kgs</th>
                                                        <!-- <th>Actual Scrap Received In kgs</th>
                                                        <th>Remark</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLpreBillofmaterailistedit as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['rmsupplier_order_qty'];?></td>
                                                        <td><?php echo $value['rm_actual_aty'];?></td>
                                                        <td><?php echo $value['type_of_raw_material'];?></td>
                                                        <td><?php echo $value['sitting_size'];?></td>
                                                        <!-- <td><?php echo $value['diameter'];?></td>
                                                        <td><?php echo $value['thickness'];?></td>
                                                        <td><?php echo $value['hex_a_f'];?></td> -->
                                                        <td><?php echo $value['groass_weight'];?></td>
                                                        <td><?php echo $value['expected_qty'];?></td>
                                                        <td><?php echo $value['vendor_actual_recived_qty'];?></td>
                                                        <td><?php echo $value['net_weight_per_pcs'];?></td>
                                                        <td><?php echo $value['total_neight_weight'];?></td>
                                                        <td><?php echo $value['short_excess'];?></td>
                                                        <td><?php echo $value['scrap_in_kgs'];?></td>
                                                        <!-- <td><?php echo $value['actual_scrap_received_in_kgs'];?></td>
                                                        <td><?php echo $value['remark'];?></td> -->
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                     <div class="container">
                                         
                                         <div id="customers-list">
                                         </div>

                                         <div id="buyer_po_item_list">
                                         </div>

                                         <div id="incoming_details_item_list">
                                         </div>

                                         <div id="rejection-list">
                                         </div>

                                    </div>

                                      <!-- Add New Package Modal -->
                                    <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                      
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveBillofmaterialform" action="<?php echo base_url() ?>saveBillofmaterialform" method="post" role="form">
                                            <input readonly  type="hidden" class="form-control"  id="bill_of_material_item_id" name="bill_of_material_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-8">
                                                            <select readonly  class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?> -->
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">RM Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="number" class="form-control"  id="rm_order_qty" name="rm_order_qty" readonly>
                                                            <p class="error rm_order_qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">RM Actual Qty </label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="number" class="form-control"  id="rm_actual_aty" name="rm_actual_aty" value="0">
                                                            <p class="error rm_actual_aty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">RM Type <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="rm_type" name="rm_type" readonly>
                                                            <p class="error rm_type_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Slitting Size<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="slitting_size" name="slitting_size" readonly>
                                                            <p class="error slitting_size_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Diameter<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="diameter" name="diameter" readonly>
                                                            <p class="error diameter_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Thickness<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="thickness" name="thickness" readonly>
                                                            <p class="error thickness_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Hex A/F <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="hex_af" name="hex_af" readonly>
                                                            <p class="error hex_af_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Gross Weight<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="gross_weight" name="gross_weight" readonly>
                                                            <p class="error gross_weight_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Expected Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="expected_qty" name="expected_qty" value="0">
                                                            <p class="error expected_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="vendor_order_qty" name="vendor_order_qty" value="0">
                                                            <p class="error vendor_order_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Actual Received Qty (Enter Zero If No Qty Received)</label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="vendor_actual_received_Qty"  name="vendor_actual_received_Qty">
                                                            <p class="error vendor_actual_received_Qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Net Weight Per Pcs<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="net_weight_per_pcs" name="net_weight_per_pcs" readonly>
                                                            <p class="error net_weight_per_pcs_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Total Net Weight<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="total_net_weight" name="total_net_weight" readonly>
                                                            <p class="error total_net_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Short Excess<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="short_access" name="short_access" readonly>
                                                            <p class="error short_access_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Scrap In kgs<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="scrap" name="scrap" readonly>
                                                            <p class="error scrap_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Actual Scrap Received In kgs</label>
                                                        <div class="col-sm-8">
                                                            <input readonly  type="text" class="form-control"  id="actual_scrap_recived" name="actual_scrap_recived">
                                                            <p class="error actual_scrap_recived_error"></p>
                                                        </div>
                                                    </div>

                                          
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                           <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                           <p class="error item_remark_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closebillofmaterialmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveBillofmaterialtem" name="saveBillofmaterialtem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLpreBillofmaterailist){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input readonly  type="button" onclick="location.href = '<?php echo base_url() ?>billofmaterial'" class="btn btn-default" value="Back" />
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


        $(document).ready(function () {
    $('.table').DataTable({
        scrollX: true,
    });
});
</script>

