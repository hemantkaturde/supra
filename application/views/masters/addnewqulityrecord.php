<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Quality Record
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> Quality Record Details</a></li>
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
                     <h3 class="box-title">Add New Quality Record</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewqualityform" action="#" method="post" role="form">
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

                              if($get_prevoius_QR_REcord[0]['quality_records_number']){
                                    //   $arr = str_split($get_prevoius_QR_REcord[0]['quality_records_number']);
                                    //   $i = end($arr);
                                    //   $inrno= "SQQR2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                    //   $quality_records_number = $inrno;

                                    // $string = $get_prevoius_QR_REcord[0]['quality_records_number'];
                                    // $n = 4; // Number of characters to extract from the end
                                    // $lastNCharacters = substr($string, -$n);
                                    // $inrno= "SQQR2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                    // $quality_records_number = $inrno;


                                            // New Logic Start Here 
                                            $getfinancial_year = substr($get_prevoius_QR_REcord[0]['quality_records_number'], -8);

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
                                               
                                                $string = $get_prevoius_QR_REcord[0]['quality_records_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $quality_records_number = $inrno;

                                            } else {

                                                $getfinancial_year = substr($get_prevoius_QR_REcord[0]['quality_records_number'], -8);

                                                $first_part_of_string = substr($getfinancial_year,0,4);

                                                if($first_part_of_string == $financial_year_indian){

                                                    $string = $get_prevoius_QR_REcord[0]['quality_records_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $quality_records_number = $inrno;

                                                }else{
                                                    
                                                    $string = $get_prevoius_QR_REcord[0]['quality_records_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string1, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){
                                                        $string1 =$get_prevoius_QR_REcord[0]['quality_records_number'];
                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $quality_records_number = $inrno;
                                             }

                                                //$po_number = 'SQPO24250001';
                                            }  
                                          /* New Logic End Here */



                              }else{
                                  $quality_records_number = 'SQQR'.$financial_year_indian.'0001';
                              }
                              ?>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="QR_details_number">QR Number<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="c" value="<?=$quality_records_number?>" name="QR_details_number" readonly>
                                    <p class="error QR_details_number_error"></p>
                                 </div>
                              </div>
                              <?php $date= date('Y-m-d'); ?>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="QR_details_date">QR Date <span class="required">*</span></label>
                                    <input type="text" class="form-control datepicker"  value="<?=$date?>" id="QR_details_date" name="QR_details_date" required>
                                    <p class="error QR_details_date_error"></p>
                                 </div>
                              </div>
                              <div class="col-md-12" >
                                 <div class="form-group">
                                    <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                    <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                       <option st-id="" value="">Select Vendor Name</option>
                                       <?php foreach ($vendorList as $key => $value) {?>
                                       <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$get_qulityrecorditemrecord[0]['vendor_id_qty_record']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                       <?php } ?>
                                    </select>
                                    <p class="error vendor_name_error"></p>
                                 </div>
                              </div>

                                       <?php
                                            if($get_qulityrecorditemrecord[0]['pre_vendor_po_number']){
                                                $display='block';
                                                $selected_value = $get_qulityrecorditemrecord[0]['qtypo_number'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        
                                        ?>


                              <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                 <div class="form-group">
                                    <label for="vendor_po_number">Vendor PO Number <span class="required">*</span></label>
                                    <select class="form-control vendor_po_number_itam vendor_po_get_data vendor_po_number_for_view_item_stock_form" name="vendor_po_number" id="vendor_po_number">
                                       <option st-id="" value="">Select Vendor PO Number</option>
                                       <option st-id="" value="<?=$get_qulityrecorditemrecord[0]['pre_vendor_po_number']?>" selected="selected"><?=$selected_value?></option>
                                    </select>
                                    <p class="error vendor_po_number_error"></p>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="vedor_po_date">PO Date </label>
                                    <input type="text" class="form-control datepicker"  Value="<?=$get_qulityrecorditemrecord[0]['vendorpodate'];?>" id="vedor_po_date" name="vedor_po_date" readonly>
                                    <p class="error vedor_po_date_error"></p>
                                 </div>
                              </div>


                              
                                        <?php
                                            if($get_qulityrecorditemrecord[0]['pre_buyer_name']){
                                                $display='block';
                                                $selected_value = $get_qulityrecorditemrecord[0]['byuerqty'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        
                                        ?>

                              <div class="col-md-12">
                                 <div class="form-group">
                                       <label for="buyer_name">Buyer Name</label>
                                          <select class="form-control" name="buyer_name" id="buyer_name" readonly>
                                             <option st-id="" value="">Select Buyer Name</option>
                                             <option st-id="" value="<?=$get_qulityrecorditemrecord[0]['pre_buyer_name']?>" selected="selected"><?=$selected_value?></option>

                                              <!-- <?php foreach ($buyerList as $key => $value) {?> -->
                                             <!-- <option value="<?php echo $value['buyer_id']; ?>" <?php if($fetchALLpreBillofmaterailist[0]['pre_buyer_name']== $value['buyer_id']){ echo 'selected'; } ?> ><?php echo $value['buyer_name']; ?></option> -->
                                          <!-- <?php } ?> -->
                                       </select>
                                    <p class="error buyer_name_error"></p>
                                 </div>
                              </div>


                              <?php
                                            if($get_qulityrecorditemrecord[0]['pre_buyer_po_number']){
                                                $display='block';
                                                $selected_value = $get_qulityrecorditemrecord[0]['sales_order_number'];
                                            }else{
                                                $display='none';
                                                $selected_value = 'Select Buyer PO Number';
                                            }        
                                        ?>


                              <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO </label>
                                                    <select class="form-control buyer_po_number  buyer_po_number_for_itam_mapping buyer_po_number_for_itam_display autobuyerpo" name="buyer_po_number" id="buyer_po_number" readonly>
                                                        <option st-id="" value="">Select Buyer PO</option>
                                                        <option st-id="" value="<?=$get_qulityrecorditemrecord[0]['pre_buyer_po_number']?>" selected="selected"><?=$selected_value?></option>

                                                        <!-- <option st-id="" value="<?=$fetchALLpreBillofmaterailist[0]['pre_buyer_po_number'] ?>"><?=$sales_order_number ?></option> -->
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="remark">Remark</label>
                                 <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$get_qulityrecorditemrecord[0]['remarkitem'];?></textarea>
                                 <p class="error remark_error"></p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="max-width: 70%;display: block;overflow-x: auto; white-space: nowrap;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>F.G Part Number</th>
                                                        <th>F.G Description</th>
                                                        <th>Inspection Report No</th>
                                                        <th>Inspection Report Date</th>
                                                        <th>LOT Qty</th>
                                                        <th>Inspected By</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($get_qulityrecorditemrecord as $key => $value) :
                                                           $count++;
                                                           $debit_gst_value =  '';
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['name'];?></td>
                                                        <td><?php echo $value['inspection_report_no'];?></td>
                                                        <td><?php echo $value['inspection_report_date'];?></td>
                                                        <td><?php echo $value['lot_qty'];?></td>
                                                        <td><?php echo $value['inspected_by'];?></td>
                                                        <td><?php echo $value['remarkitem'];?></td>
                                                        <td>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['qtyid'];?>' class='fa fa-pencil-square-o editqualityrecordsitem'  aria-hidden='true'></i>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['qtyid'];?>' class='fa fa-trash-o deletequalityrecordsitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <div class="container">
                                         <div id="stockform_item_list">
                                         </div>
                                    </div>

                                     <!-- <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div> -->


                                    
                                    <div class="container">
                                         <div id="export-list">
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
                                            <form role="form" id="savequlityrecord_form" action="#" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="quality_record_item_id" name="quality_record_item_id" required readonly>

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
                                                        <label class="col-sm-4 col-form-label">Inspection Report No<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="inspection_report_no" name="Inspection Report No">
                                                            <p class="error inspection_report_no_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Inspection Report Date<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control datepicker"  id="inspection_report_date" name="inspection_report_date">
                                                            <p class="error inspection_report_date_error"></p>
                                                        </div>
                                                    </div>  

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">LOT Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="lot_qty" name="lot_qty">
                                                            <p class="error lot_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Inspected By<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="inspected_by" name="inspected_by">
                                                            <p class="error inspected_by_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closequlityrecordmodel" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savequlityrecorditem" name="savequlityrecorditem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                           <input type="submit" id="addnewquality" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>qualityrecord'" class="btn btn-default" value="Back" />
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