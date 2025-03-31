<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Challan Form
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Challan Form</a></li>
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
                            <h3 class="box-title">Add Challan Form</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewchallanform" action="<?php echo base_url() ?>addchallanform" method="post" role="form">
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


                                        if($getPreviousChallanform_number[0]['challan_no']){
                                            // $arr = str_split($getPreviousChallanform_number[0]['challan_no']);
                                            // $i = end($arr);
                                            // $inrno= "SQCH2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $challan_number = $inrno;


                                            // New Logic Start Here 
                                            $getfinancial_year = substr($getPreviousChallanform_number[0]['challan_no'], -8);

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
                                               
                                                $string = $getPreviousChallanform_number[0]['challan_no'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQCH".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $challan_number = $inrno;

                                            } else {


                                                if($first_part_of_string == $financial_year_indian){

                                                    $string = $getPreviousChallanform_number[0]['challan_no'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQCH".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $challan_number = $inrno;

                                                }else{


                                                  $string = $getPreviousChallanform_number[0]['challan_no'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters1 = substr($string, -$n);
                                                  
                                                  if($lastNCharacters1  > 0){

                                                      if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                          $string1 =$getPreviousChallanform_number[0]['challan_no'];
                                                      }else{
                                                          $string1 =0;
                                                      }

                                                  }else{
                                                      $string1 =0;
                                                  }

                                                  $lastNCharacters = substr($string1, -$n);
                                                  $inrno= "SQCH".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $challan_number = $inrno;
                                                }

                                                //$po_number = 'SQPO24250001';
                                            }  
                                          /* New Logic End Here */


                                        }else{

                    
                                            $challan_number = 'SQCH'.$financial_year_indian.'0001';
                                        }
                                    ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_no">Challan No<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="challan_no" value="<?=$challan_number?>" name="challan_no" readonly>
                                            <p class="error challan_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <?php if($getChallanformlist[0]['pre_date']){
                                        $date= $getChallanformlist[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_date">Challan Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="challan_date" name="challan_date" required>
                                            <p class="error challan_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_supplier_name">Select Vendor / Supplier <span class="required">*</span></label>
                                                <select class="form-control vendor_supplier_name" name="vendor_supplier_name" id="vendor_supplier_name">
                                                    <option st-id="" value="">Select Vendor / Supplier</option>
                                                    <option value="vendor" <?php if($getChallanformlist[0]['pre_vendor_supplier_name']=='vendor'){ echo 'selected'; } ?>>Vendor</option>
                                                    <option value="supplier" <?php if($getChallanformlist[0]['pre_vendor_supplier_name']=='supplier'){ echo 'selected'; } ?>>Supplier</option>
                                                </select>
                                            <p class="error vendor_supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <?php if($getChallanformlist[0]['pre_vendor_name']){
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
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getChallanformlist[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                        </div>


                                        <?php
                                            if($getChallanformlist[0]['pre_vendor_po_number']){
                                                $display='block';
                                                $selected_value = $getChallanformlist[0]['vendor_po_number'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        

                                        ?>

                                        <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div" style="display:<?=$display;?>">
                                            <div class="form-group">
                                                    <label for="vendor_po_number">Select Vendor PO Number</label>
                                                        <select class="form-control vendor_po_number_itam" name="vendor_po_number" id="vendor_po_number">
                                                            <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                            <option st-id="" value="<?=$getChallanformlist[0]['pre_vendor_po_number']?>" selected="selected"><?=$selected_value?></option>
                                                        </select>
                                                <p class="error vendor_po_number_error"></p>
                                            </div>
                                        </div>
                                    </div>


                                    <?php if($getChallanformlist[0]['pre_supplier_name']){
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
                                                            <option value="<?php echo $value['sup_id']; ?>" <?php if($value['sup_id']==$getChallanformlist[0]['pre_supplier_name']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <p class="error supplier_name_error"></p>
                                                </div>
                                            </div>

                                            <?php
                                                if($getChallanformlist[0]['pre_supplier_po_number']){
                                                    $display='block';
                                                    $selected_value = $getChallanformlist[0]['supplier_po_number'];
                                                }else{
                                                    $display='none';
                                                    $selected_value = 'Select Supplier PO Number';
                                                }        
                                            ?>

                                            <div class="col-md-12 supplier_po_number_div" id="supplier_po_number_div" style="display: <?=$display?>">
                                                <div class="form-group">
                                                        <label for="supplier_po_number">Select Supplier PO Number</label>
                                                            <select class="form-control supplier_po_number_item supplier_po_number_for_item" name="supplier_po_number" id="supplier_po_number">
                                                                <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                                <option st-id="" value="<?=$getChallanformlist[0]['pre_supplier_po_number']?>" selected="selected"><?=$selected_value?></option>
                                                            </select>
                                                    <p class="error supplier_po_number_error"></p>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="col-md-12" >
                                            <div class="form-group">
                                                    <label for="usp">USP </label>
                                                    <select class="form-control usp" name="usp" id="usp">
                                                        <option st-id="" value="">Select USP</option>
                                                        <?php foreach ($getUSPmasterlist as $key => $value) {?>
                                                        <option value="<?php echo $value['usp_id']; ?>" <?php if($value['usp_id']==$getChallanformlist[0]['pre_usp_id']){ echo 'selected';} ?>><?php echo $value['usp_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <p class="error usp_error"></p>
                                            </div>
                                    </div>


                                        
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dispatched_by">Dispatched by</label>
                                            <input type="text" class="form-control" id="dispatched_by" name="dispatched_by" value="<?=$getChallanformlist[0]['pre_dispatched_by'];?>" required>
                                            <p class="error dispatched_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_gross_weight_in_kgs">Total Gross Weight In kgs</label>
                                            <input type="text" class="form-control" id="total_gross_weight_in_kgs" name="total_gross_weight_in_kgs" value="<?=$getChallanformlist[0]['pre_total_gross_weight_in_kgs'];?>" required>
                                            <p class="error total_gross_weight_in_kgs_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_netweight_in_kgs">Total Net Weight In kgs</label>
                                            <input type="text" class="form-control" id="total_netweight_in_kgs" name="total_netweight_in_kgs" value="<?=$getChallanformlist[0]['pre_total_netweight_in_kgs'];?>" required>
                                            <p class="error total_netweight_in_kgs_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="no_of_bags_boxs_goni">No of Bags/Boxes/Goni </label>
                                            <input type="text" class="form-control" id="no_of_bags_boxs_goni" name="no_of_bags_boxs_goni" value="<?=$getChallanformlist[0]['pre_no_of_bags_boxs_goni'];?>" required>
                                            <p class="error no_of_bags_boxs_goni_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12" >
                                            <div class="form-group">
                                                    <label for="paid_unpaid">Paid/Unpaid <span class="required">*</span></label>
                                                    <select class="form-control paid_unpaid" name="paid_unpaid" id="paid_unpaid">
                                                        <option st-id="" value="">Select Paid/Unpaid</option>
                                                        <option value="Paid" <?php if($getChallanformlist[0]['pre_paid_unpaid']=='Paid'){ echo 'selected';} ?>>Paid</option>
                                                        <option value="Unpaid" <?php if($getChallanformlist[0]['pre_paid_unpaid']=='Unpaid'){ echo 'selected';} ?>>Unpaid</option>
                                                    </select>
                                                <p class="error paid_unpaid_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required> <?=$getChallanformlist[0]['pre_remark'];?></textarea>
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
                                                        <th>Quantity</th>
                                                        <th>Rate</th>
                                                        <th>Value</th>
                                                        <th>Type Of Platting</th>
                                                        <th>Row Material Cost</th>
                                                        <th>Total </th>
                                                        <th>GST</th>
                                                        <th>Grand Total</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($getChallanformlist as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description1'];?></td>
                                                        <td><?php echo $value['qty'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td><?php echo $value['type_of_raw_platting'];?></td>
                                                        <td><?php echo $value['row_material_cost'];?></td>
                                                        <td><?php echo $value['row_material_cost'] + $value['value'];?></td>
                                                        <td><?php echo $value['gst_rate'];?></td>
                                                        <td><?php echo $value['grand_total'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                        <td>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['challanformid'];?>' class='fa fa-pencil-square-o editChallanformitem'  aria-hidden='true'></i>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['challanformid'];?>' class='fa fa-trash-o deleteChallanformitem' aria-hidden='true'></i>
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
                                            <form role="form" id="saveChallanformitem_form" action="<?php echo base_url() ?>saveChallanformitem" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="challan_form_item_id" name="challan_form_item_id" required readonly>

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
                                                        <label class="col-sm-4 col-form-label">HSN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="HSN_Code" name="HSN_Code" readonly>
                                                            <p class="error HSN_Code_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">SAC Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="SAC" name="SAC" readonly>
                                                            <p class="error SAC_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Type Of Row Material</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="type_of_raw_material" name="type_of_raw_material" readonly>
                                                            <p class="error type_of_raw_material_error"></p>
                                                        </div>
                                                    </div>
                                                

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Type Of Row Platting</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="type_of_raw_platting" name="type_of_raw_platting">
                                                            <p class="error type_of_raw_platting_error"></p>
                                                        </div>
                                                    </div>

                                                   
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Quantity<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="quantity" name="quantity">
                                                            <p class="error quantity_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Unit <span class="required">*</span></label>
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
                                                        <label class="col-sm-4 col-form-label">Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="rate" name="rate">
                                                            <p class="error rate_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Value<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="value" name="value" readonly>
                                                            <p class="error value_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Row Material Cost<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="row_material_cost" name="row_material_cost">
                                                            <p class="error row_material_cost_error"></p>
                                                        </div>
                                                    </div>
                                                
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
                                                        <label class="col-sm-2 col-form-label">SGST 9 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_9" name="SGST_rate_9" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 9 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_9" name="CGST_rate_9" readonly>
                                                            <p class="error CGST_rate_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row igst_div" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 18 %<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_18" name="igst_rate_18" readonly>
                                                            <p class="error igst_rate_18_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row cgst_sgst_div_6" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 6 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate_6" name="SGST_rate_6" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 6 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate_6" name="CGST_rate_6" readonly>
                                                            <p class="error CGST_rate_6_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row igst_div_12" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 12 %<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate_12" name="igst_rate_12" readonly>
                                                            <p class="error igst_rate_12_error"></p>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control"  id="gst" name="gst" readonly>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Grand Total<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="grand_total" name="grand_total" readonly>
                                                            <p class="error grand_total_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closechallanformmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveChallanformpopopitem" name="saveChallanformpopopitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($getChallanformlist){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewchallanform" class="btn btn-primary" value="Submit">
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>challanform'" class="btn btn-default" value="Back" />
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

