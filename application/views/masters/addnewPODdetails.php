<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New POD Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> POD Details</a></li>
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
                            <h3 class="box-title">Add POD Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewPODform" action="#" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
                                    <?php

                                        $current_month = date("n"); // Get the current month without leading zeros

                                        if ($current_month >= 4) {
                                            // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                            $financial_year_indian = date("y") . "" . (date("y") + 1);
                                        } else {
                                            // If the current month is before April, the financial year is from April (last year) to March (current year)
                                            $financial_year_indian = (date("y") - 1) . "" . date("y");
                                        }

                                        if($getPreviousPODdetails_number[0]['pod_details_number']){
                                            // $arr = str_split($getPreviousPODdetails_number[0]['pod_details_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQPD2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $POD_details_number = $inrno;

                                            if($first_part_of_string == $financial_year_indian){

                                            }else{}
                                            
                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviousPODdetails_number[0]['pod_details_number'], -8);

                                              $first_part_of_string = substr($getfinancial_year,0,4);
                                              $year = substr($first_part_of_string,0,2);

                                              // Current date
                                              $currentDate = new DateTime();
                                              
                                              // Financial year in India starts from April 1st
                                              $financialYearStart = new DateTime("$year-04-01");
                                              
                                              // Financial year in India ends on March 31st of the following year
                                              $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                              
                                              // Check if the current date falls within the financial year
                                              if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                 
                                                  $string = $getPreviousPODdetails_number[0]['pod_details_number'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= "SQPD".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $POD_details_number = $inrno;
  
                                              } else {


                                                if($first_part_of_string == $financial_year_indian){
                                                    $string = $getPreviousPODdetails_number[0]['pod_details_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQPD".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $POD_details_number = $inrno;

                                                }else{
  
                                                    $string = $getPreviousPODdetails_number[0]['pod_details_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviousPODdetails_number[0]['pod_details_number'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "SQPD".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $POD_details_number = $inrno;
  
                                                  //$po_number = 'SQPO24250001';
                                                }
                                              }  
                                            /* New Logic End Here */

                                        }else{
                                            $POD_details_number = 'SQPD'.$financial_year_indian.'0001';
                                        }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="POD_details_number">POD Details Number<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="c"
                                                value="<?=$POD_details_number?>" name="POD_details_number" readonly>
                                            <p class="error POD_details_number_error"></p>
                                        </div>
                                    </div>
                                    <?php if($getpoddetails[0]['pre_date']){
                                 $date= $getpoddetails[0]['pre_date'];
                                 }else{
                                 $date= date('Y-m-d');
                              } ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="POD_details_date">POD Details Date <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?=$date?>"
                                                id="POD_details_date" name="POD_details_date" required>
                                            <p class="error POD_details_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_supplier_name">Select Vendor / Supplier <span
                                                    class="required">*</span></label>
                                            <select class="form-control vendor_supplier_name"
                                                name="vendor_supplier_name" id="vendor_supplier_name">
                                                <option st-id="" value="">Select Vendor / Supplier</option>
                                                <option value="vendor"
                                                    <?php if($getpoddetails[0]['pre_vendor_supplier_name']=='vendor'){ echo 'selected'; } ?>>
                                                    Vendor</option>
                                                <option value="supplier"
                                                    <?php if($getpoddetails[0]['pre_vendor_supplier_name']=='supplier'){ echo 'selected'; } ?>>
                                                    Supplier</option>
                                            </select>
                                            <p class="error vendor_supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <?php if($getpoddetails[0]['pre_vendor_name']){
                                      $display = 'block';
                                     }else{ 
                                      $display = 'none';
                                     } ?>

                                    <div id="vendor_name_div_for_hide_show" style="display:<?=$display;?>">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vendor_name">Vendor Name</label>
                                                <select class="form-control vendor_name" name="vendor_name"
                                                    id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"
                                                        <?php if($value['ven_id']==$getpoddetails[0]['pre_vendor_name']){ echo 'selected';} ?>>
                                                        <?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                        </div>


                                        <?php
                                            if($getpoddetails[0]['pre_vendor_po_number']){
                                                $display='block';
                                                $selected_value = $getpoddetails[0]['vendor_po'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        
                                        ?>

                                        <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div"
                                            style="display:<?=$display;?>">
                                            <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number</label>
                                                <select class="form-control vendor_po_number_itam vendor_po_get_data"
                                                    name="vendor_po_number" id="vendor_po_number">
                                                    <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                    <option st-id=""
                                                        value="<?=$getpoddetails[0]['pre_vendor_po_number']?>"
                                                        selected="selected"><?=$selected_value?></option>
                                                </select>
                                                <p class="error vendor_po_number_error"></p>
                                            </div>
                                        </div>
                                    </div>


                                    <?php if($getpoddetails[0]['pre_supplier_name']){
                                      $display = 'block';
                                     }else{ 
                                      $display = 'none';
                                     } ?>

                                    <div id="supplier_name_div_for_hide_show" style="display:<?=$display;?>">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="supplier_name">Supplier Name </label>
                                                <select class="form-control" name="supplier_name" id="supplier_name">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>"
                                                        <?php if($value['sup_id']==$getpoddetails[0]['pre_supplier_name']){ echo 'selected';} ?>>
                                                        <?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <p class="error supplier_name_error"></p>
                                            </div>
                                        </div>

                                        <?php
                                                if($getpoddetails[0]['pre_supplier_po_number']){
                                                    $display_po='block';
                                                    $selected_value = $getpoddetails[0]['supplier_po'];
                                                }else{
                                                    $display_po='none';
                                                    $selected_value = 'Select Supplier PO Number';
                                                }        
                                            ?>


                                        <div class="col-md-12 supplier_po_number_div" id="supplier_po_number_div" style="display: <?=$display_po?>">
                                            <div class="form-group">
                                                <label for="supplier_po_number">Select Supplier PO Number</label>
                                                <select
                                                    class="form-control supplier_po_number_item supplier_po_number_for_item supplier_po_get_data"
                                                    name="supplier_po_number" id="supplier_po_number">
                                                    <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                    <option st-id=""
                                                        value="<?=$getpoddetails[0]['pre_supplier_po_number']?>"
                                                        selected="selected"><?=$selected_value?></option>
                                                </select>
                                                <p class="error supplier_po_number_error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($getpoddetails[0]['pre_po_date']){
                                        $po_date= $getpoddetails[0]['pre_po_date'];
                                     }else{
                                        //$po_date= date('Y-m-d');
                                        $po_date= '';
                                     } ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_date">PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?=$po_date;?>"
                                                id="po_date" name="po_date" required>
                                            <p class="error po_date_error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <textarea type="text" class="form-control" id="remark"
                                                name="remark"><?=$getpoddetails[0]['pre_remark'];?></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" id="add_item_details" data-toggle="modal"
                                            data-target="#addNewModal">Add New Items</button><br /><br />
                                        <table class="table table-bordered"
                                            style="max-width: 68%;display: block;overflow-x: auto; white-space: nowrap;">
                                            <thead style="background-color:#3c8dbc;color:#fff">
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Part Number</th>
                                                    <th>Description</th>
                                                    <th>Order Qty</th>
                                                    <th>Lot Number</th>
                                                    <th>Qty Recived</th>
                                                    <th>Unit</th>
                                                    <th>Bill Number</th>
                                                    <th>Bill Date</th>
                                                    <th>Short/Excess Qty</th>
                                                    <th>Remarky</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php      if($getpoddetails){
                                                           $count=0;
                                                           foreach ($getpoddetails as $key => $value) :
                                                           $count++;
                                                           $debit_gst_value =  intval($value['SGST_value']) + intval($value['CGST_value']) + intval($value['IGST_value']);

                                                    ?>
                                                <tr>
                                                    <td><?php echo $count;?></td>
                                                    <td><?php echo $value['part_number'];?></td>
                                                    <td><?php echo $value['name'];?></td>
                                                    <td><?php echo $value['order_qty'];?></td>
                                                    <td><?php echo $value['lot_no'];?></td>
                                                    <td><?php echo $value['qty_recived'];?></td>
                                                    <td><?php echo $value['unit'];?></td>
                                                    <td><?php echo $value['bill_no'];?></td>
                                                    <td><?php echo $value['bill_date'];?></td>
                                                    <td><?php echo $value['short_excess_qty'];?></td>
                                                    <td><?php echo $value['pod_remark'];?></td>
                                                    <td>
                                                    <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['pod_id'];?>' class='fa fa-pencil-square-o editPODitem'  aria-hidden='true'></i>
                                                    <i style='font-size: x-large;cursor: pointer'
                                                            data-id='<?php echo $value['pod_id'];?>'
                                                            class='fa fa-trash-o deletePODitem' aria-hidden='true'></i>
                                                    </td>
                                                </tr>
                                                <?php endforeach; } else { ?>
                                                   <tr><td colspan="11"><center><i>No records Found</i></center></td></tr>
                                                   
                                                 <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div> -->

                                    <!-- Add New Package Modal -->
                                    <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem"
                                        aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="additem">Add New Item</h3>
                                                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                    <!-- <span aria-hidden="true">&times;</span> -->
                                                    </button>
                                                </div>
                                                <form role="form" id="savePODitem_form"
                                                    action="<?php echo base_url() ?>savePODitem" method="post"
                                                    role="form">

                                                    <input type="hidden" class="form-control" id="poditems_id"
                                                                    name="poditems_id" readonly>

                                                    <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img
                                                                    src="<?php echo ICONPATH;?>/preloader_ajax.gif">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Part Number <span
                                                                    class="required">*</span> (<small>Row Material Goods
                                                                    Master</small>)</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control part_number_for_previous_short_excess" name="part_number"
                                                                    id="part_number">
                                                                    <option st-id="" value="">Select Part Name</option>
                                                                    <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?> -->
                                                                </select>
                                                                <p class="error part_number_error"></p>

                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Part Name /
                                                                Description <span class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="type" class="form-control" id="description"
                                                                    name="description" required readonly>
                                                                <p class="error description_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Order Qty<span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="order_qty"
                                                                    name="order_qty" readonly>
                                                                <p class="error order_qty_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Lot No<span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="lot_no"
                                                                    name="lot_no">
                                                                <p class="error lot_no_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Qty Recived<span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="qty_recived"
                                                                    name="qty_recived">
                                                                <p class="error qty_recived_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Unit <span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="unit" id="unit">
                                                                    <option value="">Select Unit</option>
                                                                    <option value="kgs">Kgs</option>
                                                                    <option value="Pcs">Pcs</option>
                                                                    <option value="Nos">Nos</option>
                                                                    <option value="Sheet">Sheet</option>
                                                                   <option value="Set">Set</option>
<option value="Mtr">Mtr</option>
<option value="Ltr">Ltr</option>
                                                                </select>
                                                                <p class="error unit_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Bill No<span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="bill_no"
                                                                    name="bill_no">
                                                                <p class="error bill_no_error"></p>
                                                            </div>
                                                        </div>


                                                    

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Bill Date<span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="bill_date"
                                                                    name="bill_date">
                                                                <p class="error bill_date_error"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"> Previous Short / Excess
                                                                Qty</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" value="0"
                                                                    id="previous_short_excess_qty" name="previous_short_excess_qty" 
                                                                    readonly>
                                                                <p class="error previous_short_excess_qty_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Short / Excess
                                                                Qty<span class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="short_excess_qty" name="short_excess_qty"
                                                                    readonly>
                                                                <p class="error short_excess_qty_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Remark</label>
                                                            <div class="col-sm-8">
                                                                <textarea type="text" class="form-control"
                                                                    id="item_remark" name="item_remark"></textarea>
                                                                <p class="error item_remark_error"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-secondary btn-xl closedebitnotemodel"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" id="savePODitem" name="savePODitem"
                                                            class="btn btn-primary"
                                                            class="btn btn-success btn-xl">Save</button>
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
                            <input type="submit" id="savenewpoddetails" class="btn btn-primary" value="Submit">
                            <input type="button" onclick="location.href = '<?php echo base_url() ?>poddetails'"
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