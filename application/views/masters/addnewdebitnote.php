<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Debit Note
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Debit Note</a></li>
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
                            <h3 class="box-title">Add Debit Note</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewdebitnoteform" action="<?php echo base_url() ?>addnewdebitnoteform" method="post" role="form">
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


                                        if($getPreviousDebitnote_number[0]['debit_note_number']){
                                            // $arr = str_split($getPreviousDebitnote_number[0]['debit_note_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQDN2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $debit_note_number = $inrno;
                                            
                                            // $string = $getPreviousDebitnote_number[0]['debit_note_number'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "SQSD2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $debit_note_number = $inrno;

                                            
                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviousDebitnote_number[0]['debit_note_number'], -8);

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
                                                 
                                                  $string = $getPreviousDebitnote_number[0]['debit_note_number'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= "SQDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $debit_note_number = $inrno;
  
                                              } else {


                                                if($first_part_of_string == $financial_year_indian){

                                                    $string = $getPreviousDebitnote_number[0]['debit_note_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $debit_note_number = $inrno;

                                                }else{

  
                                                    $string = $getPreviousDebitnote_number[0]['debit_note_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviousDebitnote_number[0]['debit_note_number'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "SQDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $debit_note_number = $inrno;
  
                                                  //$po_number = 'SQPO24250001';
                                                }
                                              }  
                                            /* New Logic End Here */

                                        }else{
                                            $debit_note_number = 'SQDN'.$financial_year_indian.'0001';
                                        }
                                    ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="debit_note_number">Debit Note Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="debit_note_number" value="<?=$debit_note_number?>" name="debit_note_number" readonly>
                                            <p class="error debit_note_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <?php if($getdebitnoteitemdetails[0]['pre_date']){
                                        $date= $getdebitnoteitemdetails[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="debit_note_date">Debit Note Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="debit_note_date" name="debit_note_date" required>
                                            <p class="error debit_note_date_error"></p>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="select_with_po_without_po">Select With PO / Without PO <span class="required">*</span></label>
                                                <select class="form-control" name="select_with_po_without_po" id="select_with_po_without_po">
                                                    <option st-id="" value="">Select With PO / Without PO</option>
                                                    <option value="with_po" <?php if($getdebitnoteitemdetails[0]['pre_select_with_po_without_po']=='with_po'){ echo 'selected'; } ?>>With PO</option>
                                                    <option value="without_po" <?php if($getdebitnoteitemdetails[0]['pre_select_with_po_without_po']=='without_po'){ echo 'selected'; } ?>>Without PO</option>
                                                </select>
                                            <p class="error select_with_po_without_po_error"></p>
                                        </div>
                                    </div> -->


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_supplier_name">Select Vendor / Supplier <span class="required">*</span></label>
                                                <select class="form-control vendor_supplier_name" name="vendor_supplier_name" id="vendor_supplier_name">
                                                    <option st-id="" value="">Select Vendor / Supplier</option>
                                                    <option value="vendor" <?php if($getdebitnoteitemdetails[0]['pre_vendor_supplier_name']=='vendor'){ echo 'selected'; } ?>>Vendor</option>
                                                    <option value="supplier" <?php if($getdebitnoteitemdetails[0]['pre_vendor_supplier_name']=='supplier'){ echo 'selected'; } ?>>Supplier</option>
                                                </select>
                                            <p class="error vendor_supplier_name_error"></p>
                                        </div>
                                    </div>


                                     <?php if($getdebitnoteitemdetails[0]['pre_vendor_name']){
                                      $display = 'block';
                                     }else{ 
                                      $display = 'none';
                                     } ?>

                                    <div id="vendor_name_div_for_hide_show" style="display:<?=$display;?>">
                                        <div class="col-md-12" >
                                            <div class="form-group">
                                                    <label for="vendor_name">Vendor Name</label>
                                                    <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getdebitnoteitemdetails[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                        </div>


                                        <?php
                                            if($getdebitnoteitemdetails[0]['pre_vendor_po_number']){
                                                $display='block';
                                                $selected_value = $getdebitnoteitemdetails[0]['vendor_po'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        
                                        ?>

                                        <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                            <div class="form-group">
                                                    <label for="vendor_po_number">Select Vendor PO Number</label>
                                                        <select class="form-control vendor_po_number_itam vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                                            <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                            <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_vendor_po_number']?>" selected="selected"><?=$selected_value?></option>
                                                        </select>
                                                <p class="error vendor_po_number_error"></p>
                                            </div>
                                        </div>
                                    </div>


                                     <?php if($getdebitnoteitemdetails[0]['pre_supplier_name']){
                                      $display = 'block';
                                     }else{ 
                                      $display = 'none';
                                     } ?>

                                        <div id="supplier_name_div_for_hide_show" style="display:<?=$display;?>">
                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                        <label for="supplier_name">Supplier Name </label>
                                                        <select class="form-control" name="supplier_name" id="supplier_name">
                                                            <option st-id="" value="">Select Supplier Name</option>
                                                            <?php foreach ($supplierList as $key => $value) {?>
                                                            <option value="<?php echo $value['sup_id']; ?>" <?php if($value['sup_id']==$getdebitnoteitemdetails[0]['pre_supplier_name']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <p class="error supplier_name_error"></p>
                                                </div>
                                            </div>

                                            <?php
                                                if($getdebitnoteitemdetails[0]['pre_supplier_po_number']){
                                                    $display='none';
                                                    $selected_value = $getdebitnoteitemdetails[0]['supplier_po'];
                                                }else{
                                                    $display='none';
                                                    $selected_value = 'Select Supplier PO Number';
                                                }        
                                            ?>

                                            <div class="col-md-12 supplier_po_number_div" id="supplier_po_number_div" style="display: <?=$display?>">
                                                <div class="form-group">
                                                        <label for="supplier_po_number">Select Supplier PO Number</label>
                                                            <select class="form-control supplier_po_number_item supplier_po_number_for_item supplier_po_get_data" name="supplier_po_number" id="supplier_po_number">
                                                                <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                                <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_supplier_po_number']?>" selected="selected"><?=$selected_value?></option>
                                                            </select>
                                                    <p class="error supplier_po_number_error"></p>
                                                </div>
                                            </div>
                                    </div>

                                    <?php if($getdebitnoteitemdetails[0]['pre_po_date']){
                                        $po_date= $getdebitnoteitemdetails[0]['pre_po_date'];
                                     }else{
                                        //$po_date= date('Y-m-d');
                                        $po_date= '';
                                     } ?>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="po_date">PO Date <span class="required">*</span></label>
                                                  <input type="text" class="form-control datepicker"  value="<?=$po_date?>" id="po_date" name="po_date" required readonly>
                                                <p class="error po_date_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="total_debit_amount">Total Debit Amount <span class="required">*</span></label>
                                                  <input type="text" class="form-control"  value="<?=number_format($totalDebitAndokQty['total_debit_amount'] + $totalDebitAndokQty['total_SGST_value'] + $totalDebitAndokQty['total_CGST_value'] + $totalDebitAndokQty['total_IGST_value'], 2, '.', ','); ?>" id="total_debit_amount" name="total_debit_amount" required readonly>
                                                <p class="error total_debit_amount_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="total_debit_amount_ok_qty">Total Amount of OK Quantity <span class="required">*</span></label>
                                                  <input type="text" class="form-control"  value="<?=$totalDebitAndokQty['total_amount_of_ok_qty_data']+$totalDebitAndokQty['SGST_value_ok_val']+$totalDebitAndokQty['CGST_value_ok_val']+$totalDebitAndokQty['IGST_value_ok_val'] + $totalDebitAndokQty['p_and_f_charges'];?>" id="total_amount_of_ok_qty_data" name="total_amount_of_ok_qty_data" required readonly>
                                                  <input type="hidden" class="form-control"  value="<?=$totalDebitAndokQty['total_amount_of_ok_qty']?>" id="total_amount_of_ok_qty" name="total_amount_of_ok_qty" required readonly>
                                                <p class="error total_debit_amount_ok_qty_error"></p>
                                            </div>
                                    </div>


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tds_amount">TDS Amount <span class="required">*</span></label>
                                                  <input type="text" class="form-control"  value="0" id="tds_amount" name="tds_amount" required>
                                                <p class="error tds_amount_error"></p>
                                            </div>
                                    </div>
                                    

                                    <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="freight_amount_charge">Courier/Return Charges<span class="required">*</span></label>
                                                  <input type="text" class="form-control"  value="0" id="freight_amount_charge" name="freight_amount_charge" required>
                                                <p class="error freight_amount_charge_error"></p>
                                            </div>
                                    </div> -->

                                
                                    <input type="hidden" class="form-control"  value="0" id="freight_amount_charge" name="freight_amount_charge" required>
                                    <input type="hidden" class="form-control" value="<?=$totalDebitAndokQty['p_and_f_charges']?>"  id="p_and_f_charges_main" name="p_and_f_charges_main">
                                    <input type="hidden" class="form-control"  value="" id="chq_amt" name="chq_amt" required>
                                    <input type="hidden" class="form-control" id="grand_total_main" value="<?=$totalDebitAndokQty['grandtotal']?>"  name="grand_total_main" required>

                                    <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="chq_amt">Chq Amount <span class="required">*</span></label>
                                                  <input type="text" class="form-control"  value="" id="chq_amt" name="chq_amt" required>
                                                <p class="error chq_amt_error"></p>
                                            </div>
                                    </div>
                                     -->


                                    <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="freight_amount_charge">Grand Total <span class="required">*</span></label>
                                                  <input type="hidden" class="form-control" id="grand_total_main" value="<?=$totalDebitAndokQty['grandtotal']?>"  name="grand_total_main" required>
                                                <p class="error grand_total_main_error"></p>
                                            </div>
                                    </div> -->


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="text_label">Text Label</label>
                                                  <input type="text" class="form-control" value="<?=$getdebitnoteitemdetails[0]['pre_text_label']?>" id="text_label" name="text_label" required>
                                                <p class="error text_label_error"></p>
                                            </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="text_amount_charge">Amount</label>
                                                  <input type="text" class="form-control"  value="<?=$getdebitnoteitemdetails[0]['pre_text_amount']?>" id="text_amount" name="text_amount" required>
                                                <p class="error text_amount_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vendor_inv_value">Vendor Invoice Value</label>
                                                  <input type="text" class="form-control"  value="<?=$getdebitnoteitemdetails[0]['pre_vendor_inv_value']?>" id="vendor_inv_value" name="vendor_inv_value" required>
                                                <p class="error vendor_inv_value_error"></p>
                                            </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required> <?=$getdebitnoteitemdetails[0]['pre_remark'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="max-width: 68%;display: block;overflow-x: auto; white-space: nowrap;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Invoice No</th>
                                                        <th>Invoice Date</th>
                                                        <th>Invoice Qty</th>
                                                        <th>OK Qty</th>
                                                        <th>Less Quantity</th>
                                                        <th>Rejected Quantity</th>
                                                        <th>Received Quantity</th>
                                                        <th>Rate </th>
                                                        <th>GST Rate</th>
                                                        <th>Debit GST</th>
                                                        <th>OK GST</th>
                                                        <th>Debit Amount</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($getdebitnoteitemdetails as $key => $value) :
                                                           $count++;
                                                           $debit_gst_value =  floatval($value['SGST_value']) + floatval($value['CGST_value']) + floatval($value['IGST_value']);


                                                        if($value['gst_rate']=='CGST_SGST'){
                                                            $gate_rate = '9'.' %';
                                                         }

                                                         if($value['gst_rate']=='CGST_SGST_6'){
                                                            $gate_rate = '6'.' %';
                                                         }

                                                         
                                                         if($value['gst_rate']=='IGST'){
                                                            $gate_rate = '18'.' %';
                                                         }

                                                         if($value['gst_rate']=='IGST_12'){
                                                            $gate_rate = '12'.' %';
                                                         }
                                                       


                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['part_name'];?></td>
                                                        <td><?php echo $value['invoice_no'];?></td>
                                                        <td><?php echo $value['invoice_date'];?></td>
                                                        <td><?php echo $value['invoice_qty'];?></td>
                                                        <td><?php echo $value['ok_qty'];?></td>
                                                        <td><?php echo $value['less_quantity'];?></td>
                                                        <td><?php echo $value['rejected_quantity'];?></td>
                                                        <td><?php echo $value['received_quantity'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['gst_rate'].'-'.$gate_rate;;?></td>
                                                        <td><?php echo $debit_gst_value;?></td>
                                                        <td><?php echo $value['total_amount_of_ok_qty'];?></td>
                                                        <td><?php echo $value['debit_amount'];?></td>
                                                        <td><?php echo $value['debit_note_remark'];?></td>
                                                        <td>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['debit_note_id'];?>' class='fa fa-pencil-square-o editDebitnoteitem'  aria-hidden='true'></i>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['debit_note_id'];?>' class='fa fa-trash-o deleteDebitnoteitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
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
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveDebitnoteitem_form" action="<?php echo base_url() ?>savedebitnoteitem" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="debit_note_item_id" name="debit_note_item_id" required readonly>

                                                <div class="modal-body">
                                                    <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?> -->
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Name / Description <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice No<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="invoice_no" name="invoice_no">
                                                            <p class="error invoice_noe_error"></p>
                                                        </div>
                                                    </div>

                                                    <?php $debit_note = date('Y-m-d'); ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice Date<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control datepicker" value='<?=$debit_note;?>' id="invoice_date" name="invoice_date">
                                                            <p class="error invoice_date_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="invoice_qty" name="invoice_qty">
                                                            <p class="error invoice_qty_error"></p>
                                                        </div>
                                                    </div>
                                                

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">OK Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="ok_qty" name="ok_qty">
                                                            <p class="error ok_qty_error"></p>
                                                        </div>
                                                    </div>

                                                   
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Less Quantity<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="less_quantity" name="less_quantity">
                                                            <p class="error less_quantity_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Rejected Quantity<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="rejected_quantity" name="rejected_quantity">
                                                            <p class="error rejected_quantity_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Received Quantity<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="received_quantity" name="received_quantity">
                                                            <p class="error received_quantity_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label" for="p_and_f_charges">P and F Charges <span class="required">*</span></label>
                                                            <div class="col-sm-8">
                                                                    <input type="number" class="form-control"  id="p_and_f_charges" name="p_and_f_charges" required>
                                                                    <p class="error p_and_f_charges_error"></p>
                                                            </div>    
                                                    </div>
                                               

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rate" name="rate" readonly>
                                                            <p class="error rate_error"></p>
                                                        </div>
                                                    </div>                                                  
                                                

                                                    <input type="hidden" class="form-control"  id="total_amount_ok_qty_data" name="total_amount_ok_qty_data">


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Select GST Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                                <select class="form-control" name="gst_rate" id="gst_rate">
                                                                    <option value="">Select GST Rate</option>
                                                                    <option value="CGST_SGST">CGST + SGST ( 9% + 9% )</option>
                                                                    <option value="CGST_SGST_6">CGST + SGST ( 6% + 6% )</option>
                                                                    <option value="IGST">IGST ( 18% )</option>
                                                                    <option value="IGST_12">IGST ( 12% )</option>
                                                                </select>
                                                            <p class="error gst_rate_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row cgst_sgst_div" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 9 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_9" name="SGST_rate_9" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 9 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_9" name="CGST_rate_9" readonly>
                                                            <p class="error CGST_rate_error"></p>
                                                        </div>
                                                    </div>
                                                   

                                                    <div class="form-group row cgst_sgst_div_6" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 6 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_6" name="SGST_rate_6" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 6 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_6" name="CGST_rate_6" readonly>
                                                            <p class="error CGST_rate_6_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row igst_div" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 18 % (<small> IGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_18" name="igst_rate_18" readonly>
                                                            <p class="error igst_rate_18_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row igst_div_12" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 12 % (<small> IGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_12" name="igst_rate_12" readonly>
                                                            <p class="error igst_rate_12_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row cgst_sgst_ok_9_div" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 9 % (<small> SGST Value for OK Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_9_ok" name="SGST_rate_9_ok" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 9 % (<small> SGST Value for OK Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_9_ok" name="CGST_rate_9_ok" readonly>
                                                            <p class="error CGST_rate_9_ok_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row cgst_sgst_ok_6_div" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 6 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_6_ok" name="SGST_rate_6_ok" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 6 % (<small> SGST Value for Debit Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_6_ok" name="CGST_rate_6_ok" readonly>
                                                            <p class="error CGST_rate_6_ok_error"></p>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group row igst_ok_qty_div" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 18 % (<small> IGST Value for OK Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_ok_18" name="igst_rate_ok_18" readonly>
                                                            <p class="error igst_rate_ok_18_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row igst_ok_div_12_div" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 12 % (<small> IGST Value for OK Qty</small>)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_ok_12" name="igst_rate_ok_12" readonly>
                                                            <p class="error igst_rate_ok_12_error"></p>
                                                        </div>
                                                    </div>

            


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Debit Amount<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="debit_amount" name="debit_amount" readonly>
                                                            <p class="error debit_amount_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                           <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                           <p class="error item_remark_error"></p>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control"  id="total_qty_into_rate" name="total_qty_into_rate" readonly>
                                                    <input type="hidden" class="form-control"  id="total_qty_normal_qty_plus_pnf" name="total_qty_normal_qty_plus_pnf" readonly>
                                                    <input type="hidden" class="form-control"  id="total_normal_gst_value" name="total_normal_gst_value" readonly>
                                                    <input type="hidden" class="form-control"  id="total_normal_gst_value_plus_total" name="total_normal_gst_value_plus_total" readonly>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closedebitnotemodel" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savedebitnoteitem" name="savedebitnoteitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($getdebitnoteitemdetails){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewdebitnote" class="btn btn-primary" value="Submit" <?=$disabled?>>
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>debitnote'" class="btn btn-default" value="Back" />
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
				startDate: new Date(),
			});
		});
</script>

