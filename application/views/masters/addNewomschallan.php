<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New OMS Challan
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> OMS Challan Details</a></li>
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
                     <h3 class="box-title">Add New OMS Challan Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewomschallanform" action="#" method="post" role="form">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="blasting_id">Blasting Id<span class="required">*</span></label>
                                        <?php

                                            // $current_month = date("n"); // Get the current month without leading zeros

                                            // if ($current_month >= 4) {
                                            //         // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                            //         $financial_year_indian = date("y") . "" . (date("y") + 1);
                                            // } else {
                                            //         // If the current month is before April, the financial year is from April (last year) to March (current year)
                                            //         $financial_year_indian = (date("y") - 1) . "" . date("y");
                                            // }


                                            // if($getpreviuousblasterId['blasting_id']){
                                            //     // $arr = str_split($getpreviuousblasterId['blasting_id']);
                                            //     // $i = end($arr);
                                            //     // $inrno= "JW/".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            //     // $stock_form_id = $inrno;
                                            //     $previous_enquiry_number = $getpreviuousblasterId['blasting_id'];
                                            
                                            //     // Extract financial year (last 4 digits)
                                            //     $previous_financial_year = substr($previous_enquiry_number, -4);
                                            

                                            //     if ($previous_financial_year == $financial_year_indian) {

                                            //         $string = $getpreviuousblasterId['blasting_id'];
                                            //         $n = 4; // Number of characters to extract from the end
                                            //         $lastNCharacters = substr($string, -$n);
                                            //         $inrno= "JW/".$financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            //         $stock_form_id = $inrno;

                                            //     }else{

                                            //         $stock_form_id ='JW/'.$financial_year_indian.'/0001';

                                            //     }

                                            

                                            // }else{
                                            //     $stock_form_id = 'JW/'.$financial_year_indian.'/0001';
                                            // }

                                            $current_month = date("n"); // Get current month
                                            $current_year = date("Y");

                                            // Determine financial year (4-digit format like 2024 or 2025)
                                            if ($current_month >= 4) {
                                                $financial_year = $current_year; // Start of FY is current year
                                            } else {
                                                $financial_year = $current_year - 1; // Before April, FY started last year
                                            }

                                            
                                           if (!empty($getpreviuousblasterId['blasting_id'])) {
                                                $previous_id = $getpreviuousblasterId['blasting_id']; // e.g., JW/2025/0012
                                                $parts = explode("/", $previous_id); // Split into parts: ["JW", "2025", "0012"]
                                            
                                                $prev_fy = isset($parts[1]) ? $parts[1] : null;
                                                $prev_number = isset($parts[2]) ? (int)$parts[2] : 0;
                                            
                                                if ($prev_fy == $financial_year) {
                                                    // Same financial year: increment number
                                                    $new_number = str_pad($prev_number + 1, 4, "0", STR_PAD_LEFT);
                                                } else {
                                                    // New financial year: start fresh
                                                    $new_number = "0001";
                                                }
                                            
                                                $stock_form_id = "JW/" . $financial_year . "/" . $new_number;
                                            } else {
                                                // First ever ID
                                                $stock_form_id = "JW/" . $financial_year . "/0001";
                                            }


                                        ?>
                                            <input type="text" class="form-control" id="blasting_id" name="blasting_id" value="<?=$stock_form_id;?>" required readonly>
                                            <p class="error blasting_id_error"></p>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="oms_challan_date">OMS Challan Date <span class="required">*</span></label>
                                            <?php 
                                            if($getomschallanitems[0]['pre_oms_challan_date']){
                                                $date= $getomschallanitems[0]['pre_oms_challan_date'];
                                            }else{
                                                $date= date('Y-m-d'); 
                                            }
                                            ?>
                                            <input type="text" class="form-control datepicker" id="oms_challan_date" name="oms_challan_date" value="<?=$date?>"  required >
                                            <p class="error oms_challan_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                            <option value="<?php echo $value['ven_id']; ?>" <?php if($getomschallanitems[0]['pre_vendor_name']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                    <div class="form-group">
                                        <?php 
                                            if($getomschallanitems[0]['pre_vendor_po_number']){
                                                $po_number=  '<option st-id="" value="'.$getomschallanitems[0]['pre_vendor_po_number'].'">'.$getomschallanitems[0]['po_number'].'</option>';
                                            }else{
                                                $po_number= '<option st-id="" value="">Select Vendor Name</option>'; 
                                            }
                                        ?>
                                        <label for="vendor_po_number">Select Vendor PO Number</label>
                                            <select class="form-control vendor_po_for_item vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                                <?php echo $po_number;?>
                                            </select>
                                        <p class="error vendor_po_number_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">

                                           <?php 
                                            if($getomschallanitems[0]['pre_vendor_date']){
                                                $vendor_po_date= $getomschallanitems[0]['pre_vendor_date'];
                                            }else{
                                                $vendor_po_date= date('Y-m-d'); 
                                            }
                                            ?>

                                    <div class="form-group">
                                        <label for="buyer_po">Vendor PO Date</label>
                                            <input type="text" class="form-control" id="vendor_po_date" name="vendor_po_date" value="<?=$vendor_po_date ?>" required readonly>
                                            <p class="error vendor_po_date_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="remark" class="form-control" id="remark" name="remark" value="<?=$getomschallanitems[0]['pre_remark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-md-12">
                           <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                             <table class="table  table-bordered">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">F.G Description</th>
                                        <th scope="col">R.M Description</th>
                                        <th scope="col">Gross Weight</th>
                                        <th scope="col">Net Weight</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">No of Bags</th>
                                        <th scope="col">HSN No</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getomschallanitems){
                                               $i=1;
                                            foreach ($getomschallanitems as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo  $i++; ?></td>
                                                <td><?=$value['part_number']?></td>
                                                <td><?=$value['fgdiscription']?></td>
                                                <td><?=$value['type_of_raw_material']?></td>
                                                <td><?=$value['omsgross_weight']?></td>
                                                <td><?=$value['omsnet_weight']?></td>
                                                <td><?=$value['omsqty']?></td>
                                                <td><?=$value['no_of_bags']?></td>
                                                <td><?=$value['hsn_no']?></td>
                                                <td><?=$value['omsremark']?></td>
                                                <td>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['omsid'];?>' class='fa fa-pencil-square-o editChallanformitem'  aria-hidden='true'></i>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['omsid'];?>' class='fa fa-trash-o deleteOmschallnitem' aria-hidden='true'></i>
                                                </td>
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No OMS Challan Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                            <?php if($getomschallanitems){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>
                           <input type="submit" id="addnewomschallan" class="btn btn-primary" value="Submit" <?=$button?>>
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>omschallan'" class="btn btn-default" value="Back" />
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
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">

                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveomschallanform" action="<?php echo base_url() ?>saveomschallanform" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="oms_challan_item_id" name="oms_challan_item_id" required readonly>

                                               <div class="modal-body">
                                                    <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="part_number">F.G Part Number <span class="required">*</span></label>
                                                                    <select class="form-control" name="part_number" id="part_number">
                                                                        <option st-id="" value="">Select F.G Part Number</option>
                                                                    </select>
                                                                   <p class="error part_number_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="fg_description">F.G. Description</label>
                                                                <input type="text" class="form-control" id="fg_description" name="fg_description" readonly>
                                                                <p class="error fg_description_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="rm_description">R.M Description</label>
                                                                <input type="text" class="form-control" id="rm_description" name="rm_description" readonly>
                                                                <p class="error rm_description_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="gross_weight">Gross Weight</label>
                                                                <input type="text" class="form-control" id="gross_weight" name="gross_weight">
                                                                <p class="error gross_weight_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="unit">Unit</label>
        
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

                                                            <div class="form-group">
                                                                <label for="calculation">Calculation</label>
                                                                <input type="text" class="form-control" id="calculation" name="calculation">
                                                                <p class="error calculation_error"></p>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="form-group">
                                                                <label for="net_weight">Net Weight</label>
                                                                <input type="text" class="form-control" id="net_weight" name="net_weight">
                                                                <p class="error net_weight_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="qty">Qty (in pcs)</label>
                                                                <input type="number" class="form-control" id="qty" name="qty" >
                                                                <p class="error qty_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="no_of_bags">No Of Bags</label>
                                                                <input type="number" class="form-control" id="no_of_bags" name="no_of_bags" >
                                                                <p class="error no_of_bags_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="hsn_no">HSN No</label>
                                                                <input type="text" class="form-control" id="hsn_no" name="hsn_no" readonly>
                                                                <p class="error hsn_no_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closeomschallan" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveomschallan_item" name="saveomschallan_item" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
