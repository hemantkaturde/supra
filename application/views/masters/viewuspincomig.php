<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View USP incoming
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> View USP incoming</a></li>
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
                            <h3 class="box-title">View USP incoming</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsupincomingform" action="#" method="post" role="form">

                        <input readonly type="hidden" class="form-control" id="usp_incoming_id" name="usp_incoming_id"
                        value="<?=$getuspincomingdetailsforedit['usp_incoming_id'];?>" required>

                            <div class="box-body">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_number">ID Number <span class="required">*</span></label>
                                        
                                            <input readonly type="text" class="form-control" id="id_number" name="id_number"
                                                value="<?=$getuspincomingdetailsforedit['usp_id_number'];?>" required>
                                            <p class="error id_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usp_date">USP Incoming Date <span class="required">*</span></label>
                                            <input readonly type="text" class="form-control datepicker" id="usp_date"
                                                name="usp_date"value="<?=$getuspincomingdetailsforedit['date'];?>" required>
                                            <p class="error usp_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usp_name">USP Name</label>
                                            <select class="form-control searchfilter" name="usp_name" id="usp_name">
                                                <option st-id="" value="">Select USP Name</option>
                                                <?php foreach ($getUSPmasterlist as $key => $value) {?>
                                                <option value="<?php echo $value['usp_id']; ?>" <?php if($getuspincomingdetailsforedit['usp_name_id']==$value['usp_id']){ echo 'selected'; } ?> >
                                                    <?php echo $value['usp_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($getuspincomingdetailsforedit['challan_no']){
                                        $selected_value = $getuspincomingdetailsforedit['challan_no'];

                                    }else{
                                        $selected_value = 'Select Challan Number';
                                    } ?>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_number">Challan Number</label>
                                            <select class="form-control searchfilter challan_number_for_part_number" name="challan_number"
                                                id="challan_number">
                                                <option st-id="" value="">Select Challan Number</option>
                                                <option st-id=""
                                                    value="<?=$getuspincomingdetailsforedit['challan_number_id']?>" selected>
                                                    <?=$selected_value;?></option>

                                            </select>
                                            <p class="error challan_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_date">Challan Date</label>
                                            <input readonly type="text" class="form-control" id="challan_date" value="<?=$getuspincomingdetailsforedit['challan_date'] ?>"
                                                name="challan_date" required readonly>
                                            <p class="error challan_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="report_by">Report By</label>
                                            <input readonly type="text" class="form-control" id="report_by" name="report_by" value="<?=$getuspincomingdetailsforedit['report_by'] ?>"
                                                value="">
                                            <p class="error report_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input readonly type="text" class="form-control" id="remark" name="remark" value="<?=$getuspincomingdetailsforedit['mainremark'] ?>"
                                                value="">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="usp_status">USP Status</label>
                                                <select class="form-control searchfilter" name="usp_status" id="usp_status">
                                                    <option st-id="" value="">Select Status</option>
                                                    <option st-id="" value="Open" <?php if($getuspincomingdetailsforedit['usp_status']=='Open'){ echo 'selected'; } ?>>Open</option>
                                                    <option st-id="" value="Close" <?php if($getuspincomingdetailsforedit['usp_status']=='Close'){ echo 'selected'; } ?>>Close</option>
                                                </select>
                                            <p class="error usp_status_error"></p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input readonly type="remark" class="form-control" id="remark" value="" value="<?=$getitemdetaiilsuspincoming[0]['remark'] ?>"
                                                name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-md-12">
                                <!-- <p>Note : In case of change of actual recd qty in between then you need to manual update previous stock of next enteries </p> -->
                                <table class="table  table-bordered">
                                    <thead style="background-color: #3c8dbc;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Part Number</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Challan Qty</th>
                                            <th scope="col">Net Weight Per / pcs (in kgs)</th>
                                            <th scope="col">Challan No</th>
                                            <th scope="col">Challan Date</th>
                                            <th scope="col">Received Qty (In Pcs)</th>
                                            <th scope="col">Received Qty (In Kgs)</th>
                                            <th scope="col">Gross Weight (Including Bag)</th>
                                            <th scope="col">Units</th>
                                            <th scope="col">No of Bags</th>
                                            <th scope="col">Lot No</th>
                                            <th scope="col">Balance Qty (In PCS)</th>
                                            <th scope="col">Balance Qty (In KGS)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Remark</th>
                                        </tr>
                                    </thead>

                                    <?php 
                                           if($getitemdetaiilsuspincomingedit){
                                               $i=1;
                                            foreach ($getitemdetaiilsuspincomingedit as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo  $i++; ?></td>
                                        <td><?=$value['part_number']?></td>
                                        <td><?=$value['name']?></td>
                                        <td><?=$value['challan_qty']?></td>
                                        <td><?=$value['net_weight_per_pcs']?></td>
                                        <td><?=$value['challan_no']?></td>
                                        <td><?=$value['challan_date']?></td>
                                        <td><?=round($value['received_qty_In_pcs'],3)?></td>
                                        <td><?=round($value['received_qty_In_kgs'],3)?></td>
                                        <td><?=$value['gross_weight_Including_bag']?></td>
                                        <td><?=$value['units']?></td>
                                        <td><?=$value['no_of_bags']?></td>
                                        <td><?=$value['lot_no']?></td>
                                        <td><?=$value['balance_qty_in_pcs']?></td>
                                        <td><?=$value['balance_qty_in_kgs']?></td>
                                        <td><?=$value['item_status']?></td>
                                        <td><?=$value['itemremark']?></td>
                                    <tr>

                                        <?php  } }else{ ?>
                                    <tr>
                                        <td colspan="14">
                                            <p> <i>No Stock Form Items Found</i></p>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                    <input readonly type="button" onclick="location.href = '<?php echo base_url() ?>uspincoming'"
                                        class="btn btn-default " value="Back" />
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

<!-- Add New Package Modal -->
<?php $this->load->helper("form"); ?>
<div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="additem">Add New Item</h3>
                </button>
            </div>
            <form role="form" id="saveuspincoming_item_form" action="<?php echo base_url() ?>saveuspincomingitemform"
                method="post" role="form">

                <input readonly type="hidden" class="form-control" id="usp_incoming_item_id" name="usp_incoming_item_id" required>

                <div class="modal-body">
                    <div class="loader_ajax" style="display:none;">
                        <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_number">Part Number <span class="required">*</span></label>
                                <select class="form-control partnumberforpreviousbal" name="part_number"
                                    id="part_number">
                                    <option st-id="" value="">Select F.G Part Number</option>
                                </select>
                                <p class="error part_number_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input readonly type="text" class="form-control" id="description" name="description" readonly>
                                <p class="error description_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_qty">Challan Qty</label>
                                <input readonly type="text" class="form-control" id="challan_qty" name="challan_qty" readonly>
                                <p class="error challan_qty_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="net_weight_per_kgs_pcs">Net Weight Per / pcs (in kgs)</label>
                                <input readonly type="text" class="form-control" id="net_weight_per_kgs_pcs" name="net_weight_per_kgs_pcs" readonly>
                                <p class="error net_weight_per_kgs_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="previous_balance">Previous Balance</label>
                                <input readonly type="text" class="form-control" id="previous_balance" name="previous_balance" readonly>
                                <p class="error previous_balance_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_no">Challan No</label>
                                <input readonly type="text" class="form-control" id="challan_no" name="challan_no">
                                <p class="error challan_no_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_date_item">Challan Date</label>
                                <input readonly type="text" class="form-control datepicker" id="challan_date_item" name="challan_date_item">
                                <p class="error challan_date_item_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="received_qty_in_pcs">Received Qty (In Pcs)</label>
                                <input readonly type="text" class="form-control" id="received_qty_in_pcs" name="received_qty_in_pcs">
                                <p class="error received_qty_in_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="received_qty_in_kgs">Received Qty (In Kgs)</label>
                                <input readonly type="text" class="form-control" id="received_qty_in_kgs" name="received_qty_in_kgs">
                                <p class="error received_qty_in_kgs_error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gross_qty_in_includin_bg">Gross Weight (Including Bag)</label>
                                <input readonly type="text" class="form-control" id="gross_qty_in_includin_bg"
                                    name="gross_qty_in_includin_bg">
                                <p class="error gross_qty_in_includin_bg_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="units">Units</label><span class="required">*</span>
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

                            <div class="form-group">
                                <label for="no_of_bags">No of Bags</label>
                                <input readonly type="text" class="form-control" id="no_of_bags"
                                    name="no_of_bags">
                                <p class="error no_of_bags_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="lot_no">Lot No</label>
                                <input readonly type="text" class="form-control" id="lot_no"
                                    name="lot_no">
                                <p class="error lot_no_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="itemremark">Remark</label>
                                <input readonly type="text" class="form-control" id="itemremark" name="itemremark">
                                <p class="error itemremark_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="balance_qty_in_pcs">Balance Qty (In PCS)</label>
                                <input readonly type="text" class="form-control" id="balance_qty_in_pcs" name="balance_qty_in_pcs">
                                <p class="error balance_qty_in_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="balance_qty_in_kgs">Balance Qty (In Kgs)</label>
                                <input readonly type="text" class="form-control" id="balance_qty_in_kgs" name="balance_qty_in_kgs">
                                <p class="error balance_qty_in_kgs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label><span class="required">*</span>
                                     <select class="form-control" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option value="Open" selected>Open</option>
                                        <option value="Close">Close</option>
                                    </select>
                                <p class="error status_error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xl closeuspincoming_item"
                        data-dismiss="modal">Close</button>
                    <button type="submit" id="saveuspincoming_item" name="saveuspincoming_item" class="btn btn-primary"
                        class="btn btn-success btn-xl">Save</button>
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
