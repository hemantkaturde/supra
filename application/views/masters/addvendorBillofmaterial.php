<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Vendor Bill of Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add New Vendor Bill of Material</a></li>
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
                            <h3 class="box-title">Add New Vendor Bill of Material Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewvendorbillofmaterialform" action="<?php echo base_url() ?>addnnewvendorbillofmaterialform" method="post" role="form">
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

                                        if($getPreviousBomnumber['bom_number']){

                                            $getPreviousBomnumber_po_N = substr($getPreviousBomnumber['bom_number'], -4);
                                            $getPreviousBomnumbervendor_po_N = substr($getPreviousBomnumbervendor['bom_number'], -4);

                                            $getfinancial_year = substr($getPreviousBomnumbervendor['bom_number'], -8);
                                            $first_part_of_string = substr($getfinancial_year,0,4);
 
                                            if($first_part_of_string == $financial_year_indian){

                                            if($getPreviousBomnumber_po_N > $getPreviousBomnumbervendor_po_N){

                                                if($getPreviousBomnumber_po_N){
                                                   
                                                    $getfinancial_year = substr($getPreviousBomnumber['bom_number'], -8);
        
                                                    // Function to check if a given year is the current Indian financial year
                                                    $year = substr($getfinancial_year,0,2);

                                                    // Current date
                                                    $currentDate = new DateTime();
                                                    
                                                    // Financial year in India starts from April 1st
                                                    $financialYearStart = new DateTime("$year-04-01");
                                                    
                                                    // Financial year in India ends on March 31st of the following year
                                                    $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                                    
                                                    // Check if the current date falls within the financial year
                                                    if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                       
                                                        $string = $getPreviousBomnumber_po_N;
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $po_number = $inrno;

                                                    } else {

                                                        $string = $getPreviousBomnumbervendor_po_N;
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $po_number = $inrno;

                                                        //$po_number = 'SQPO24250001';
                                                    }  
                                                  /* New Logic End Here */

                                                }else{
                                                    $po_number = 'SQBM'.$financial_year_indian.'0001';
                                                }     
                                            }else{

                                                if($getPreviousBomnumbervendor_po_N){


                                                     /* New Logic Statrt Here */ 
                                                      /* get finaicial Year from the Serial Number*/
                                                      $getfinancial_year = substr($getPreviousBomnumbervendor['bom_number'], -8);
        
                                                      // Function to check if a given year is the current Indian financial year
                                                      $year = substr($getfinancial_year,0,2);

                                                      // Current date
                                                      $currentDate = new DateTime();
                                                      
                                                      // Financial year in India starts from April 1st
                                                      $financialYearStart = new DateTime("$year-04-01");
                                                      
                                                      // Financial year in India ends on March 31st of the following year
                                                      $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                                      
                                                      // Check if the current date falls within the financial year
                                                      if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                         
                                                            $string = $getPreviousBomnumbervendor['bom_number'];
                                                            $n = 4; // Number of characters to extract from the end
                                                            $lastNCharacters = substr($string, -$n);
                                                            $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                            $po_number = $inrno;

                                                      } else {
                                                            $string = $getPreviousBomnumbervendor_po_N;
                                                            $n = 4; // Number of characters to extract from the end
                                                            $lastNCharacters = substr($string, -$n);
                                                            $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                            $po_number = $inrno;

                                                      }  
                                                    /* New Logic End Here */
                                                 


                                                }else{
                                                    $po_number = 'SQBM'.$financial_year_indian.'0001';
                                                }  
                                            }
                                        }else{

                                            $getfinancial_year = substr($getPreviousBomnumber['bom_number'], -8);

                                            $first_part_of_string = substr($getfinancial_year,0,4);

                                            if($first_part_of_string == $financial_year_indian){

                                                $string = $getPreviousBomnumber['bom_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $po_number = $inrno;
                                            }else{

                                                $string = 0;
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQBM". $financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $po_number = $inrno;

                                            }


                                        }

                                        }else{
                                                if($getPreviousBomnumbervendor['bom_number']){
                                                 

                                                     /* New Logic Statrt Here */ 
                                                      /* get finaicial Year from the Serial Number*/
                                                      $getfinancial_year = substr($getPreviousBomnumbervendor['bom_number'], -8);
        
                                                      // Function to check if a given year is the current Indian financial year
                                                      $year = substr($getfinancial_year,0,2);

                                                      // Current date
                                                      $currentDate = new DateTime();
                                                      
                                                      // Financial year in India starts from April 1st
                                                      $financialYearStart = new DateTime("$year-04-01");
                                                      
                                                      // Financial year in India ends on March 31st of the following year
                                                      $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                                      
                                                      // Check if the current date falls within the financial year
                                                      if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                         
                                                          $string = $getPreviousBomnumbervendor['bom_number'];
                                                          $n = 4; // Number of characters to extract from the end
                                                          $lastNCharacters = substr($string, -$n);
                                                          $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                          $po_number = $inrno;

                                                      } else {
                                                          $string = $getPreviousBomnumbervendor_po_N;
                                                          $n = 4; // Number of characters to extract from the end
                                                          $lastNCharacters = substr($string, -$n);
                                                          $inrno= "SQBM".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                          $po_number = $inrno;

                                                      }  
                                                    /* New Logic End Here */




                                                }else{
                                                    $po_number = 'SQBM'.$financial_year_indian.'0001';
                                                }

                                        }



                                    ?>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bom_number">BOM Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="bom_number" name="bom_number" value="<?=$po_number?>" required readonly>
                                            <p class="error bom_number_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_date']){
                                        $date= $fetchALLpreVendorpoitemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">BOM Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control vendor_name " name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$fetchALLpreVendorpoitemList[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_vendor_po_number']){
                                        $display='block';
                                        $selected_value = $fetchALLpreVendorpoitemList[0]['po_number'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select class="form-control vendor_po_for_item vendor_name_for_buyer_name vendor_po_number_for_view_item vendor_po_for_buyer_details_ vendor_po_for_incoming_details vendor_po_for_buyer_details_date_and_podetails vendor_po_for_rejection_data" name="vendor_po_number" id="vendor_po_number">
                                                        <option st-id="" value="<?=$fetchALLpreVendorpoitemList[0]['pre_vendor_po_number']?>" selected><?=$selected_value;?></option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>



                                  <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpreVendorpoitemList[0]['pre_buyer_name']){ echo 'selected';} ?>><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_buyer_po_number']){
                                        $display_buyer='block';
                                        $selected_value_buyer = $fetchALLpreVendorpoitemList[0]['sales_order_number'];

                                    }else{
                                        $display_buyer='none';
                                        $selected_value_buyer = 'Select Buyer PO Number';
                                    } ?>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO <span class="required">*</span></label>
                                                    <select class="form-control buyer_po_number  buyer_po_number_for_itam_mapping buyer_po_number_for_itam_display autobuyerpo" name="buyer_po_number" id="buyer_po_number">
                                                        <option st-id="" value="<?=$fetchALLpreVendorpoitemList[0]['pre_buyer_po_number']?>" selected><?=$selected_value_buyer?></option>
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_buyer_po_date']){
                                        $pre_buyer_po_date= $fetchALLpreVendorpoitemList[0]['pre_buyer_po_date'];
                                     }else{
                                        //$pre_buyer_po_date= date('Y-m-d');
                                        $pre_buyer_po_date= '';
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_date">Buyer PO Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_po_date" value="<?=$pre_buyer_po_date?>" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_buyer_delivery_date']){
                                        $pre_buyer_delivery_date= $fetchALLpreVendorpoitemList[0]['pre_buyer_delivery_date'];
                                     }else{
                                       // $pre_buyer_delivery_date= date('Y-m-d');
                                        $pre_buyer_delivery_date= '';
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_delivery_date">Buyer Delivery Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_delivery_date" value="<?=$pre_buyer_delivery_date?>"  name="buyer_delivery_date" required readonly>
                                            <p class="error buyer_delivery_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="bom_status">Status <span class="required">*</span></label>
                                                <select class="form-control bom_status" name="bom_status" id="bom_status">
                                                    <option st-id="" value="">Select Status Name</option>
                                                    <option value="OPEN"  <?php if($fetchALLpreVendorpoitemList[0]['pre_bom_status']=='OPEN'){ echo 'selected'; }  ?>>OPEN</option>
                                                    <option value="CLOSE" <?php if($fetchALLpreVendorpoitemList[0]['pre_bom_status']=='CLOSE'){ echo 'selected'; }  ?>>CLOSE</option>
                                                </select>
                                            <p class="error bom_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="incoming_details">Incoming Details </label>
                                                <select class="form-control  incoming_details_item_list_display" name="incoming_details" id="incoming_details">
                                                    <option st-id="" value="">Select Incoming Details</option>
                                                    <?php foreach ($incoming_details as $key => $value) {?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($fetchALLpreVendorpoitemList[0]['pre_incoming_details']== $value['id']){ echo 'selected'; } ?>><?php echo $value['incoming_details_id']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error incoming_details_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark"  value="<?=$fetchALLpreVendorpoitemList[0]['pre_remark']?>" name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl addNewModal" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Buyer Order Qty</th>
                                                        <th>Vendor Order Qty</th>
                                                        <th>Vendor Received Qty</th>
                                                        <th>Balanced Qty</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLpreVendorpoitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['buyer_order_qty'];?></td>
                                                        <td><?php echo $value['vendor_order_qty'];?></td>
                                                        <td><?php echo $value['vendor_received_qty'];?></td>
                                                        <td><?php echo $value['balenced_qty'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['vendoritmid'];?>' class='fa fa-pencil-square-o editVendorbillofmaterialpoitem'  aria-hidden='true'></i>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['vendoritmid'];?>' class='fa fa-trash-o deleteVendorbillofmaterialpoitem' aria-hidden='true'></i>
                                                        </td>
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
                                            <form role="form" id="saveVendorbilloamaterialitemform" action="<?php echo base_url() ?>saveVendorbilloamaterialitemform" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="vendor_bill_of_material_item_id" name="vendor_bill_of_material_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Finished Goods Master</small>)</label>
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
                                                        <label class="col-sm-4 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Buyer Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="buyer_order_qty" name="buyer_order_qty" readonly>
                                                            <p class="error buyer_order_qty_error"></p>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="vendor_order_qty" name="vendor_order_qty" readonly>
                                                            <p class="error vendor_order_qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Received Qty <span class="required">*</span>(Enter Zero If No Qty Received)</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="vendor_received_qty" name="vendor_received_qty">
                                                            <p class="error vendor_received_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Balanced Qty <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="balanced_aty" name="balanced_aty" readonly>
                                                            <p class="error balanced_aty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">VBOM Status<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="vbom_status_item" id="vbom_status_item">
                                                                 <option st-id="" value="">Select VBOM Status</option>
                                                                 <option value="Open" selected>Open</option>
                                                                 <option value="Close">Close</option>
                                                            </select>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closeVendorbillofmaterialmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveVendorbilloamaterialitem" name="saveVendorbilloamaterialitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLpreVendorpoitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewvendorBillofmaterial" class="btn btn-primary" value="Submit" <?php echo $disabled;?> >
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>vendorbillofmaterial'" class="btn btn-default" value="Back" />
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

