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
                        <form role="form" id="addstockform" action="#" method="post" role="form">
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

                                        if($getPriviousstockid[0]['stock_id_number']){
                                        
                                            $getfinancial_year = substr($getPriviousstockid[0]['stock_id_number'], -8);

                                            $first_part_of_string = substr($getfinancial_year,0,4);
                                            $year = substr($getfinancial_year,0,2);

                                            // Current date
                                            $currentDate = new DateTime();
                                            
                                            // Financial year in India starts from April 1st
                                            $financialYearStart = new DateTime("$year-04-01");
                                            
                                            // Financial year in India ends on March 31st of the following year
                                            $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                            
                                            // Check if the current date falls within the financial year
                                            if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                               
                                                $string = $getPriviousstockid[0]['stock_id_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "USPID-".$financial_year_indian.'-'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $id_number = $inrno;

                                            } else {

                                                $string = $getPriviousstockid[0]['stock_id_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "USPID-".$financial_year_indian.'-'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $id_number = $inrno;

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
                                        if($getStockforminformation[0]['pre_stock_date']){
                                            $usp_date= $getStockforminformation[0]['pre_stock_date'];
                                        }else{
                                            $usp_date= date('Y-m-d'); 
                                        }
                                       ?>
                                            <input type="text" class="form-control datepicker" id="usp_date"
                                                name="usp_date" value="<?=$usp_date?>" required>
                                            <p class="error usp_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_challan">Select Vendor / Challan<span
                                                    class="required">*</span></label>
                                            <select class="form-control" name="vendor_challan" id="vendor_challan">
                                                <option st-id="" value="NA">Select Vendor / Challan</option>
                                                <option st-id="" value="Vendor">Vendor</option>
                                                <option st-id="" value="Challan">Challan</option>
                                            </select>
                                            <p class="error vendor_challan_error"></p>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-4">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor Name</label>
                                            <select class="form-control" name="vendor_po" id="vendor_po">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                <?php foreach ($vendorList as $key => $value) {?>
                                                <option value="<?php echo $value['ven_id']; ?>"
                                                    <?php if($getStockforminformation[0]['pre_vendor_name']==$value['ven_id']){ echo 'selected'; }?>>
                                                    <?php echo $value['vendor_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_po_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_po_id">Vendor PO Number</label>
                                            <select class="form-control" name="vendor_po_id" id="vendor_po_id">
                                                <option st-id="" value="">Select Vendor PO Number</option>
                                                <?php foreach ($vendorpoList as $key => $value) {?>
                                                <option value="<?php echo $value['id']; ?>">
                                                    <?php echo $value['po_number']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_po_id_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_name">USP Name</label>
                                            <select class="form-control" name="vendor_name" id="vendor_name">
                                                <option st-id="" value="">Select USP Name</option>
                                                <?php foreach ($getUSPmasterlist as $key => $value) {?>
                                                <option value="<?php echo $value['usp_id']; ?>">
                                                    <?php echo $value['usp_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_number">Challan Number</label>
                                            <select class="form-control" name="challan_number" id="challan_number">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                <?php foreach ($challanList as $key => $value) {?>
                                                <option value="<?php echo $value['challan_id']; ?>">
                                                    <?php echo $value['challan_no']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error challan_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="buyer_po">Date</label>
                                            <?php 
                                        if($getStockforminformation[0]['pre_vendor_po_date']){
                                            $pre_vendor_po_date= $getStockforminformation[0]['pre_vendor_po_date'];
                                        }else{
                                            $pre_vendor_po_date= date('Y-m-d'); 
                                        }
                                       ?>

                                            <input type="text" class="form-control" id="vendor_challan_date"
                                                name="vendor_challan_date" value="<?=$pre_vendor_po_date?>" required>
                                            <p class="error vendor_challan_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="report_by">Report By</label>
                                            <input type="text" class="form-control" id="report_by" name="report_by"
                                                value="<?=$total_invoice_qty_In_kgs;?>">
                                            <p class="error report_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="report_date">Report Date</label>
                                            <input type="text" class="form-control" id="report_date" name="report_date"
                                                value="<?=$total_invoice_qty_In_kgs;?>">
                                            <p class="error report_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="remark" class="form-control" id="remark"
                                                value="<?=$getStockforminformation[0]['pre_remark_item']?>"
                                                name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
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
                                            <th scope="col">Qty</th>
                                            <th scope="col">Net Weight Per / pcs (in kgs)</th>
                                            <th scope="col">Challan No</th>
                                            <th scope="col">Challan Date</th>
                                            <th scope="col">Received Qty (In Pcs)</th>
                                            <th scope="col">Received Qty (In Kgs)</th>
                                            <th scope="col">Gross Weight (Including Bag)</th>
                                            <th scope="col">Units</th>
                                            <th scope="col">No of Bags</th>
                                            <th scope="col">Lot No</th>
                                            <th scope="col">Remark</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <?php 
                                           if($getItemlistStockform){
                                               $i=1;
                                            foreach ($getItemlistStockform as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo  $i++; ?></td>
                                        <td><?=$value['part_name_fg']?></td>
                                        <td><?=$value['name']?></td>
                                        <td><?=$value['buyer_order_qty']?></td>
                                        <td><?=$value['f_g_order_qty']?></td>
                                        <td><?=$value['invoice_number']?></td>
                                        <td><?=$value['invoice_date']?></td>
                                        <td><?=round($value['invoice_qty_In_pcs'],3)?></td>
                                        <td><?=round($value['invoice_qty_In_kgs'],3)?></td>
                                        <td><?=$value['lot']?></td>
                                        <td><?=$value['actual_received_qty_in_pcs']?></td>
                                        <td><?=$value['actual_received_qty_in_kgs']?></td>
                                        <td><?=$value['previous_balence']?></td>
                                        <td><?=$value['item_remark']?></td>
                                        <td>
                                            <i style='font-size: x-large;cursor: pointer'
                                                data-id='<?php echo $value['stock_item_id'];?>'
                                                data_id_part_number='<?php echo $value['fin_id'];?>'
                                                class='fa fa-pencil-square-o editStockformitem' aria-hidden='true'></i>

                                            <i style='font-size: x-large;cursor: pointer'
                                                data-id='<?php echo $value['stock_item_id'];?>'
                                                class='fa fa-trash-o deleteStockformitem' aria-hidden='true'></i>
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

                                    <?php if($getItemlistStockform){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>

                                    <input type="submit" id="addnewstockform" class="btn btn-primary" value="Submit"
                                        <?=$button?>>
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>stockform'"
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
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <form role="form" id="saveBillofmaterialform" action="<?php echo base_url() ?>saveBillofmaterialform"
                method="post" role="form">

                <input type="hidden" class="form-control" id="stock_form_item_id" name="stock_form_item_id" required>

                <div class="modal-body">
                    <div class="loader_ajax" style="display:none;">
                        <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_number">Part Number <span class="required">*</span></label>
                                <select class="form-control part_number_for_incoming_details" name="part_number"
                                    id="part_number">
                                    <option st-id="" value="">Select F.G Part Number</option>
                                </select>
                                <p class="error part_number_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description">
                                <p class="error description_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="part_number">Qty</label>
                                <input type="text" class="form-control" id="buyre_order_qty" name="buyre_order_qty">
                                <p class="error buyre_order_qty_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="fg_order_qty">Net Weight Per / pcs (in kgs)</label>
                                <input type="text" class="form-control" id="fg_order_qty" name="fg_order_qty">
                                <p class="error tfg_order_qty_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="fg_order_qty">Challan No</label>
                                <input type="text" class="form-control" id="fg_order_qty" name="fg_order_qty">
                                <p class="error tfg_order_qty_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="fg_order_qty">Challan Date</label>
                                <input type="text" class="form-control" id="fg_order_qty" name="fg_order_qty">
                                <p class="error tfg_order_qty_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="invoice_number">Received Qty (In Pcs)</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                                <p class="error invoice_number_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="invoice_date">Received Qty (In Kgs)</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                                <p class="error invoice_date_error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice_qty_in_pcs">Gross Weight (Including Bag)</label>
                                <input type="text" class="form-control" id="invoice_qty_in_pcs"
                                    name="invoice_qty_in_pcs">
                                <p class="error invoice_qty_in_pcs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="invoice_qty_in_kgs">Units</label>
                                <input type="text" class="form-control" id="invoice_qty_in_kgs"
                                    name="invoice_qty_in_kgs">
                                <p class="error invoice_qty_in_kgs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="actaul_recived_qty_in_pics">No of Bags</label>
                                <input type="text" class="form-control" id="actaul_recived_qty_in_pics"
                                    name="actaul_recived_qty_in_pics">
                                <p class="error actaul_recived_qty_in_pics_error"></p>
                            </div>


                            <div class="form-group">
                                <label for="actaul_recived_qty_in_kgs">Lot No</label>
                                <input type="text" class="form-control" id="actaul_recived_qty_in_kgs"
                                    name="actaul_recived_qty_in_kgs">
                                <p class="error tactaul_recived_qty_in_kgs_error"></p>
                            </div>

                            <div class="form-group">
                                <label for="itemremark">Remark</label>
                                <input type="text" class="form-control" id="itemremark" name="itemremark">
                                <p class="error itemremark_error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xl closestockform"
                        data-dismiss="modal">Close</button>
                    <button type="submit" id="saveStockform_item" name="saveStockform_item" class="btn btn-primary"
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