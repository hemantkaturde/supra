<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New USP incoming
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Add New USP incoming</a></li>
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
                            <h3 class="box-title">Add New USP incoming</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsupincomingform" action="#" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_number">ID Number <span class="required">*</span></label>
                                            <?php
                                                $current_month = date("n"); // Get the current month without leading zeros

                                                if ($current_month >= 4) {
                                                        // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                                        $financial_year_indian = date("y") . "" . (date("y") + 1);
                                                } else {
                                                        // If the current month is before April, the financial year is from April (last year) to March (current year)
                                                        $financial_year_indian = (date("y") - 1) . "" . date("y");
                                                }




                                                if($getPrevioususpincomingnumber['usp_id_number']){
                                                
                                                    // $getfinancial_year = substr($getPrevioususpincomingnumber['usp_id_number'], -8);

                                                    // $first_part_of_string = substr($getfinancial_year,0,4);
                                                    // $year = substr($getfinancial_year,0,2);
                                                    $string = $getPrevioususpincomingnumber['usp_id_number'];
                                                    $parts = explode("-", $string);
                                                    $year = $parts[1]; // Extracts "252

                                                    // Current date
                                                    $currentDate = new DateTime();
                                                    
                                                    // Financial year in India starts from April 1st
                                                    $financialYearStart = new DateTime("$year-04-01");
                                                    
                                                    // Financial year in India ends on March 31st of the following year
                                                    $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                                    
                                                    // Check if the current date falls within the financial year
                                                    if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                    
                                                        $string = $getPrevioususpincomingnumber['usp_id_number'];
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "USPID-".$financial_year_indian.'-'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $id_number = $inrno;

                                                    } else {


                                                        // $getfinancial_year = substr($getPrevioususpincomingnumber['usp_id_number'], -8);

                                                        // $first_part_of_string = substr($getfinancial_year,0,4);

                                                        $string = $getPrevioususpincomingnumber['usp_id_number'];
                                                        $parts = explode("-", $string);
                                                        $year = $parts[1]; // Extracts "252
            
                                                        if($year == $financial_year_indian){

                                                            $string = $getPrevioususpincomingnumber['usp_id_number'];
                                                            $n = 4; // Number of characters to extract from the end
                                                            $lastNCharacters = substr($string, -$n);
                                                            $inrno= "USPID-".$financial_year_indian.'-'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                            $id_number = $inrno;

                                                        }else{

                                                            $string = 0;
                                                            $n = 4; // Number of characters to extract from the end
                                                            $lastNCharacters = substr($string, -$n);
                                                            $inrno= "USPID-".$financial_year_indian.'-'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                            $id_number = $inrno;
                                                        }

                                                        //$po_number = 'SQPO24250001';
                                                    }  
                                                /* New Logic End Here */

                                                }else{
                                                    $id_number = 'USPID-'.$financial_year_indian.'-'.'0001';
                                                }
                                            ?>
                                            <input type="text" class="form-control" id="id_number" name="id_number"
                                                value="<?=$id_number;?>" required>
                                            <p class="error id_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usp_date">USP Incoming Date <span class="required">*</span></label>
                                            <?php 
                                                if($getitemdetaiilsuspincoming[0]['pre_usp_date']){
                                                    $usp_date= $getitemdetaiilsuspincoming[0]['pre_usp_date'];
                                                }else{
                                                    $usp_date= date('Y-m-d'); 
                                                }
                                            ?>
                                            <input type="text" class="form-control datepicker" id="usp_date"
                                                name="usp_date" value="<?=$usp_date?>" required>
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
                                                <option value="<?php echo $value['usp_id']; ?>" <?php if($getitemdetaiilsuspincoming[0]['pre_usp_name']==$value['usp_id']){ echo 'selected'; } ?> >
                                                    <?php echo $value['usp_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($getitemdetaiilsuspincoming[0]['pre_challan_number']){
                                        $selected_value = $getitemdetaiilsuspincoming[0]['challan_no'];

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
                                                    value="<?=$getitemdetaiilsuspincoming[0]['pre_challan_number']?>" selected>
                                                    <?=$selected_value;?></option>

                                            </select>
                                            <p class="error challan_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_date">Challan Date</label>
                                            <input type="text" class="form-control" id="challan_date" value="<?=$getitemdetaiilsuspincoming[0]['challan_date'] ?>"
                                                name="challan_date" required readonly>
                                            <p class="error challan_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="report_by">Report By</label>
                                            <input type="text" class="form-control" id="report_by" name="report_by" value="<?=$getitemdetaiilsuspincoming[0]['pre_report_by'] ?>"
                                                value="">
                                            <p class="error report_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="<?=$getitemdetaiilsuspincoming[0]['itemremark'] ?>"
                                                value="">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="usp_status">USP Status</label>
                                                <select class="form-control searchfilter" name="usp_status" id="usp_status">
                                                    <option st-id="" value="">Select Status</option>
                                                    <option st-id="" value="Open" <?php if($getitemdetaiilsuspincoming[0]['pre_status']=='Open'){ echo 'selected'; } ?> selected>Open</option>
                                                    <option st-id="" value="Close" <?php if($getitemdetaiilsuspincoming[0]['pre_status']=='Close'){ echo 'selected'; } ?>>Close</option>
                                                </select>
                                            <p class="error usp_status_error"></p>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="remark" class="form-control" id="remark" value="" value="<?=$getitemdetaiilsuspincoming[0]['itemremark'] ?>"
                                                name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="button" class="btn btn-success btn-xl" data-toggle="modal"
                                    data-target="#addNewModal">Add New Items</button><br /><br />
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
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <?php 
                                           if($getitemdetaiilsuspincoming){
                                               $i=1;
                                            foreach ($getitemdetaiilsuspincoming as $key => $value) { ?>
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
                                        <td>
                                            <i style='font-size: x-large;cursor: pointer'
                                                data-id='<?php echo $value['uspincoming_item_id'];?>'
                                                data_id_part_number='<?php echo $value['fin_id'];?>'
                                                class='fa fa-pencil-square-o edituspincomingitem' aria-hidden='true'></i>

                                            <i style='font-size: x-large;cursor: pointer'
                                                data-id='<?php echo $value['uspincoming_item_id'];?>'
                                                class='fa fa-trash-o deleteuspincomingitem' aria-hidden='true'></i>
                                        </td>
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

                                    <?php if($getitemdetaiilsuspincoming){ 
                                        $button ="";
                                        }else{
                                        $button ="disabled";
                                    } ?>

                                    <input type="submit" id="addnewsupincomingformsubmit" class="btn btn-primary" value="Submit"
                                        <?=$button?>>
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>uspincoming'"
                                        class="btn btn-default" value="Back" />
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

                <input type="hidden" class="form-control" id="usp_incoming_item_id" name="usp_incoming_item_id" required>

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
                                <input type="text" class="form-control" id="description" name="description" readonly>
                                <p class="error description_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_qty">Challan Qty</label>
                                <input type="text" class="form-control" id="challan_qty" name="challan_qty" readonly>
                                <p class="error challan_qty_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="net_weight_per_kgs_pcs">Net Weight Per / pcs (in kgs)</label>
                                <input type="text" class="form-control" id="net_weight_per_kgs_pcs" name="net_weight_per_kgs_pcs" readonly>
                                <p class="error net_weight_per_kgs_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="previous_balance">Previous Balance</label>
                                <input type="text" class="form-control" id="previous_balance" name="previous_balance" readonly>
                                <p class="error previous_balance_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_no">Challan No</label>
                                <input type="text" class="form-control" id="challan_no" name="challan_no">
                                <p class="error challan_no_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="challan_date_item">Challan Date</label>
                                <input type="text" class="form-control datepicker" id="challan_date_item" name="challan_date_item">
                                <p class="error challan_date_item_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="received_qty_in_pcs">Received Qty (In Pcs)</label>
                                <input type="text" class="form-control" id="received_qty_in_pcs" name="received_qty_in_pcs">
                                <p class="error received_qty_in_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="received_qty_in_kgs">Received Qty (In Kgs)</label>
                                <input type="text" class="form-control" id="received_qty_in_kgs" name="received_qty_in_kgs" readonly>
                                <p class="error received_qty_in_kgs_error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gross_qty_in_includin_bg">Gross Weight (Including Bag)</label>
                                <input type="text" class="form-control" id="gross_qty_in_includin_bg"
                                    name="gross_qty_in_includin_bg">
                                <p class="error gross_qty_in_includin_bg_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="units">Units</label><span class="required">*</span>
                                     <select class="form-control" name="units" id="units">
                                        <option value="">Select Unit</option>
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
                                <input type="text" class="form-control" id="no_of_bags"
                                    name="no_of_bags">
                                <p class="error no_of_bags_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="lot_no">Lot No <span class="required">*</span></label>
                                <input type="text" class="form-control" id="lot_no"
                                    name="lot_no">
                                <p class="error lot_no_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="itemremark">Remark</label>
                                <input type="text" class="form-control" id="itemremark" name="itemremark">
                                <p class="error itemremark_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="balance_qty_in_pcs">Balance Qty (In PCS)</label>
                                <input type="text" class="form-control" id="balance_qty_in_pcs" name="balance_qty_in_pcs">
                                <p class="error balance_qty_in_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="balance_qty_in_kgs">Balance Qty (In Kgs)</label>
                                <input type="text" class="form-control" id="balance_qty_in_kgs" name="balance_qty_in_kgs">
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
