<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Credit Note
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Credit Note</a></li>
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
                            <h3 class="box-title">Add Credit Note Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewcreditnoteform" action="<?php echo base_url() ?>addnnewcreditnoteform" method="post" role="form">
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

                                        if($getPreviousCreditnotenumber['credit_note_number']){
                                            // $arr = str_split($getPreviousCreditnotenumber['credit_note_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQCN2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $po_number = $inrno;

                                            // Old Logic Start Here commit 18-04-2024
                                            // $string = $getPreviousCreditnotenumber['credit_note_number'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "SQSD2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $po_number = $inrno;


                                            // New Logic Start Here 
                                            $getfinancial_year = substr($getPreviousCreditnotenumber['credit_note_number'], -8);

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
                                                
                                                $string = $getPreviousCreditnotenumber['credit_note_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "SQCN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $po_number = $inrno;

                                            } else {

                                                $getfinancial_year = substr($getPreviousCreditnotenumber['credit_note_number'], -8);

                                                $first_part_of_string = substr($getfinancial_year,0,4);

                                                if($first_part_of_string == $financial_year_indian){

                                                    $string = $getPreviousCreditnotenumber['credit_note_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQCN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $po_number = $inrno;

                                                }else{

                                                $string = $getPreviousCreditnotenumber['credit_note_number'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters1 = substr($string, -$n);

                                                if($lastNCharacters1  > 0){
                                                    if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                        $string1 =$getPreviousCreditnotenumber['credit_note_number'];
                                                    }else{
                                                        $string1 =0;
                                                    }                                                   
                                                }else{
                                                    $string1 =0;
                                                }

                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string1, -$n);
                                                $inrno= "SQCN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $po_number = $inrno;

                                                //$po_number = 'SQPO24250001';
                                            }  
                                            /* New Logic End Here */
                                        }


                                        }else{
                                            $po_number = 'SQCN'.$financial_year_indian.'0001';
                                        }
                                    ?>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="credit_note_number">Credit Note Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="credit_note_number" name="credit_note_number" value="<?=$po_number?>" required readonly>
                                            <p class="error credit_note_number_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpreCredititemList[0]['pre_date']){
                                        $date= $fetchALLpreCredititemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control buyer_name_for_currency" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpreCredititemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreCredititemList[0]['pre_buyer_po_number']){
                                        $display='block';
                                        $selected_value = $fetchALLpreCredititemList[0]['sales_order_number'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?> 

                                    <div class="col-md-12 buyer_po_number_div" >
                                            <div class="form-group">
                                                    <label for="buyer_po_number">Select Buyer PO Number <span class="required">*</span></label>
                                                    <select class="form-control buyer_po_number_for_item" name="buyer_po_number" id="buyer_po_number">
                                                    <option st-id="" value="<?=$fetchALLpreCredititemList[0]['pre_buyer_po_number']?>" selected ><?=$selected_value;?></option>
                                                        <!-- <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpreCredititemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?> -->
                                                    </select> 
                                                <p class="error buyer_po_number_error"></p>
                                            </div>
                                    </div>
                            

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Currency">Currency</label>
                                            <input type="text" class="form-control" id="currency" name="currency" value="<?=$fetchALLpreCredititemList[0]['currency']?>" required readonly>
                                            <p class="error currency_error"></p>
                                        </div>
                                    </div>
                             

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="<?=$fetchALLprejobworkitemList[0]['pre_remark'] ?>">
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
                                                        <th>Invoice Number</th>
                                                        <th>Invoice Date</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Inv Value</th>
                                                        <th>Recived Amount</th>
                                                        <th>Credit Note value</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLpreCredititemList as $key => $value) :
                                                           $count++;

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['partnumber'];?></td>
                                                        <td><?php echo $value['name'];?></td>
                                                        <td><?php echo $value['buyer_invoice_number'];?></td>
                                                        <td><?php echo $value['buyer_invoice_date'];?></td>
                                                        <td><?php echo $value['qty'];?></td>
                                                        <td><?php echo $value['price'];?></td>
                                                        <td><?php echo $value['invoice_value'];?></td>
                                                        <td><?php echo $value['recivable_amount'];?></td>
                                                        <td><?php echo $value['diff_credite_note_value'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                        <td>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['credit_note_item_id'];?>' class='fa fa-pencil-square-o editcreditnoteitem'  aria-hidden='true'></i>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['credit_note_item_id'];?>' class='fa fa-trash-o deletecreditnoteitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
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
                                            <form role="form" id="savecreditnoteinformationform" action="<?php echo base_url() ?>savecreditnoteinformationform" method="post" role="form">

                                                <input type="hidden" class="form-control"  id="cerdit_note_item_id" name="cerdit_note_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Finished Goods Master</small>)</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control part_number_for_export_invoice" name="part_number" id="part_number">
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
                                                        <label class="col-sm-4 col-form-label">HSN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="hsn_code" name="hsn_code" readonly>
                                                            <p class="error hsn_code_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice Number <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control invoice_number" name="invoice_number" id="invoice_number">
                                                                <option st-id="" value="">Select Invoice Name</option>
                                                                 <?php foreach ($exportInvoiceList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['buyer_invoice_number']; ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                            <p class="error invoice_number_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice Date <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="invoice_date" name="invoice_date" readonly>
                                                            <p class="error invoice_date_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Qty </label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="qty" name="qty">
                                                            <p class="error qty_error"></p>
                                                        </div>
                                                    </div>


                                                    
                                                
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Price</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rate" name="rate">
                                                            <p class="error rate_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Invoice Value</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="invoice_value" name="invoice_value">
                                                            <p class="error invoice_value_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Recivable Amount</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="recivable_amount" name="recivable_amount">
                                                            <p class="error recivable_amount_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Differnce (Credit Note Value)</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="diff_value" name="diff_value">
                                                            <p class="error diff_value_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closecreditnotemodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savecreditnoteitrminformation" name="savecreditnoteitrminformation" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLpreCredititemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewcreditnote" class="btn btn-primary" value="Submit">
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>creditnote'" class="btn btn-default" value="Back" />
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

