<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Packing Challan
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Challan Master</a></li>
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
                            <h3 class="box-title">Add New Packing Challan</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewpackingchallanform" action="<?php echo base_url() ?>addnewpackingchallanform" method="post" role="form">
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

                                    if($getPreviousPackingchallannumber[0]['packing_challan_id']){
                                        
                                        // New Logic Start Here 
                                        $getfinancial_year = substr($getPreviousPackingchallannumber[0]['packing_challan_id'], -8);

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
                                            
                                            $string = $getPreviousPackingchallannumber[0]['packing_challan_id'];
                                            $n = 4; // Number of characters to extract from the end
                                            $lastNCharacters = substr($string, -$n);
                                            $inrno= "SQPC".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            $POD_details_number = $inrno;

                                        } else {


                                            $getfinancial_year = substr($getPreviousPackingchallannumber[0]['packing_challan_id'], -8);

                                            $first_part_of_string = substr($getfinancial_year,0,4);
    
                                            if($first_part_of_string == $financial_year_indian){

                                                $string = $getPreviousPackingchallannumber[0]['packing_challan_id'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQPC".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $POD_details_number = $inrno;

                                            }else{

                                                $string = $getPreviousPackingchallannumber[0]['packing_challan_id'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters1 = substr($string, -$n);
                                                
                                                if($lastNCharacters1  > 0){

                                                    if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                        $string1 =$getPreviousPackingchallannumber[0]['packing_challan_id'];
                                                    }else{
                                                        $string1 =0;
                                                    }

                                                }else{
                                                    $string1 =0;
                                                }

                                                $lastNCharacters = substr($string1, -$n);
                                                $inrno= "SQPC".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $POD_details_number = $inrno;
                                            }

                                            //$po_number = 'SQPO24250001';
                                        }  
                                        /* New Logic End Here */
                                    }else{
                                        $POD_details_number = 'SQPC'.$financial_year_indian.'0001';
                                    }
                                    ?>
                                  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="packing_challan_id">Packing Challan No<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="packing_challan_id" name="packing_challan_id" value="<?=$POD_details_number?>" required readonly>
                                            <p class="error packing_challan_id_error"></p>
                                        </div>
                                    </div>


                                     <?php if($get_previous_added_item_details[0]['pre_packing_challan_date']){
                                        $date= $get_previous_added_item_details[0]['pre_packing_challan_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Packing Challan Date <span class="required">*</span></label>
                                            <input type="text" class="form-control"  value="<?=$date?>" id="packing_challan_date" name="packing_challan_date" required>
                                            <p class="error packing_challan_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$get_previous_added_item_details[0]['pre_vendor_id']){ echo 'selected';} ?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dispatched_by">Dispatched By</label>
                                            <input type="text" class="form-control" id="dispatched_by" value="<?=$get_previous_added_item_details[0]['pre_dispatched_by']?>" name="dispatched_by">
                                            <p class="error dispatched_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_weight">Total Weight</label>
                                            <input type="text" class="form-control" id="total_weight" value="<?=$get_previous_added_item_details[0]['pre_total_weight']?>" name="total_weight">
                                            <p class="error total_weight_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_goni">Total Goni</label>
                                            <input type="text" class="form-control" id="total_goni" value="<?=round($gettotalcountoftotalkgsandtotalgoni[0]['total_quantity_in_gonis'],2)?>" name="total_goni">
                                            <p class="error total_goni_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_qty_in_kgs">Total Qty in kgs</label>
                                            <input type="text" class="form-control" id="total_qty_in_kgs" value="<?=round($gettotalcountoftotalkgsandtotalgoni[0]['total_qty_in_kgs'],2)?>" name="total_qty_in_kgs">
                                            <p class="error total_qty_in_kgs_error"></p>
                                        </div>
                                    </div>

                
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$get_previous_added_item_details[0]['pre_remark']?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl createnewitem" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Description Of packing Material</th>
                                                        <th>Quantity in Gonis</th>
                                                        <th>Qty in kgs</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
                                                        <th>GST Rate</th>
                                                        <th>Grand Total</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($get_previous_added_item_details as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['quantity_in_gonis'];?></td>
                                                        <td><?php echo $value['qty_in_kgs'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['amount'];?></td>
                                                        <td><?php echo $value['gst_rate'];?></td>
                                                        <td><?php echo $value['grand_total'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                        <td>
                                                            <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['packing_challan_id'];?>' class='fa fa-pencil-square-o editpackingchallanitem'  aria-hidden='true'></i>
                                                            <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['packing_challan_id'];?>' class='fa fa-trash-o deletepackingchallanitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <div class="container">
                                         <div id="customers-list">

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
                                            <form role="form" id="addpackingchallanitemform" action="<?php echo base_url() ?>addpackingchallanitemform" method="post" role="form">
                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                        <input type="hidden" class="form-control"  id="packing_challan_item_id" name="packing_challan_item_id">

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Description Of Packing Material<span class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="discription_of_packing_material" id="discription_of_packing_material">
                                                                    <option st-id="" value="">Select Description Of Packing Material</option>
                                                                    <?php foreach ($description_of_packing_material as $key => $value) {?>        
                                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['description']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <p class="error discription_of_packing_material_error"></p>
                                                            </div>
                                                        </div>
                                                   

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Quantity in Gonis <span class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"  id="quantity_in_gonis" name="quantity_in_gonis">
                                                                <p class="error quantity_in_gonis_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Qty in kgs</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"  id="qty_in_kgs" name="qty_in_kgs">
                                                                <p class="error qty_in_kgs_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Rate <span class="required">*</span></label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"  id="rate" name="rate">
                                                                    <p class="error rate_error"></p>
                                                                </div>
                                                        </div>

                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Amount</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"  id="amount" name="amount">
                                                                    <p class="error amount_error"></p>
                                                                </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">GST Rate</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="gst_rate" id="gst_rate">
                                                                    <option value="">Select GST Rate</option>
                                                                    <option value="cgst_sgst_18">CGST + SGST (9% + 9%)</option>
                                                                    <option value="cgst_sgst_12">CGST + SGST (6% + 6%)</option>
                                                                    <option value="igst_18">IGST (18%)</option>
                                                                    <option value="igst_12">IGST (12%)</option>
                                                                </select>
                                                                <p class="error gst_rate_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div id="CGST_SGST_Div" style="display:none">
                                                                <label class="col-sm-2 col-form-label">CGST Value</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"  id="CGST_value" name="CGST_value">
                                                                    <p class="error CGST_value_error"></p>
                                                                </div>

                                                                <label class="col-sm-2 col-form-label">SGST Value</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"  id="SGST_value" name="SGST_value">
                                                                    <p class="error SGST_value_error"></p>
                                                                </div>
                                                            </div>    
                                                            <div id="IGST_Div" style="display:none">
                                                                <label class="col-sm-2 col-form-label">IGST Value</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"  id="IGST_value" name="IGST_value">
                                                                    <p class="error IGST_value_error"></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Grand Total</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"  id="grand_total" name="grand_total">
                                                                    <p class="error grand_total_error"></p>
                                                                </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Remark</label>
                                                            <div class="col-sm-9">
                                                            <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                            <p class="error item_remark_error"></p>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closepackingchallanform" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savepackingchallanitem" name="savepackingchallanitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($get_previous_added_item_details){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewpackingchallan" class="btn btn-primary" value="Submit"  <?=$disabled?>/>
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>packing_challan'" class="btn btn-default" value="Back" />
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

