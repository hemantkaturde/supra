<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Buyer PO
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Buyer PO Master</a></li>
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
                            <h3 class="box-title">Add Buyer PO Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewbuyerform" action="<?php echo base_url() ?>addnewbuyerform" method="post" role="form">
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

                                   
                                        if($getPreviousSalesOrderNumber['sales_order_number']){
                                                // $arr = str_split($getPreviousSalesOrderNumber['sales_order_number']);
                                                // $i = end($arr);
                                                // $inrno= "SQBO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                // $sales_order_number = $inrno;
                                                // echo $removed_string_last;
                           
                                                // get last digit of string 

                                                $getfinancial_year = substr($getPreviousSalesOrderNumber['sales_order_number'], -8);

                                                $first_part_of_string = substr($getfinancial_year,0,4);


                                                if($first_part_of_string == $financial_year_indian){

                                                    //    $arr = str_split($getPreviousSalesOrderNumber['sales_order_number']);
                                                    //    $i = end($arr);
                                                    //    $inrno= "SQBO2425".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                    //    $sales_order_number = $inrno;
                                                    // echo $removed_string_last;

                                                 $string = $getPreviousSalesOrderNumber['sales_order_number'];
                                                 $n = 4; // 
                                                 $lastNCharacters = substr($string, -$n);

                                                 $inrnossss= "SQBO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);

                                                 $sales_order_number = $inrnossss;

                                                }else{
                                                        $lastDigit = substr($getPreviousSalesOrderNumber['sales_order_number'], -1);

                                                        // Get the current date
                                                        $currentDate = new DateTime();

                                                        // Check if the current date is on or after April 1st
                                                        if ($currentDate >= new DateTime(date('Y') . '-04-01')) {
                                                            // If it is, the financial year has started in the current calendar year
                                                            //$startYear = date('Y');
                                                            $startYear = date('y');
                                                            $endYear = $startYear + 1;
                                                        } else {
                                                            // If it is not, the financial year has started in the previous calendar year
                                                            //$endYear = date('Y');
                                                            $endYear = date('y');
                                                            $startYear = $endYear - 1;
                                                        }

                                                        // Display the financial year
                                                        //$financialYear = $startYear . '-' . $endYear;
                                                        $financialYear = $startYear.$endYear;
                                                        $string = $getPreviousSalesOrderNumber['sales_order_number'];
                                                        $n = 4; // Number of characters to extract from the end


                                                        // Extract the current year
                                                        $currentYear = $currentDate->format('Y');
                                                        
                                                        // Define the start and end dates of the financial year (April 1st to March 31st)
                                                        $financialYearStart = new DateTime("$currentYear-04-01");
                                                        $financialYearEnd = new DateTime(($currentYear + 1) . '-03-31');
                                                        
                                                        // Check if the current date is within the financial year
                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $n =0;
                                                        } else {
                                                            $n =$lastDigit;
                                                        }

                                                        $lastNCharacters = substr($string, -$n);
                                                                
                                                        $inrno= "SQBO".$financialYear.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $sales_order_number = $inrno;

                                                }

                                        }else{
                                            $sales_order_number = 'SQBO'.$financialYear.'0001';
                                        }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sales_order_number">Sales Order Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="sales_order_number" name="sales_order_number" value="<?=$sales_order_number?>" required readonly>
                                            <p class="error sales_order_number_error"></p>
                                        </div>
                                    </div>


                                     <?php if($fetchALLitemList[0]['pre_date']){
                                        $date= $fetchALLitemList[0]['pre_date'];
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
                                            <label for="buyer_po_number">Buyer PO Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_po_number" value="<?=$fetchALLitemList[0]['pre_buyer_po_number'];?>" name="buyer_po_number" >
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLitemList[0]['pre_buyer_po_date']){
                                        $buyer_po_date= $fetchALLitemList[0]['pre_buyer_po_date'];
                                     }else{
                                        $buyer_po_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?=$buyer_po_date;?>" id="buyer_po_date" name="buyer_po_date" required>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="currency">Currency <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="currency" value="<?=$fetchALLitemList[0]['pre_currency'];?>" name="currency" readonly>
                                            <p class="error currency_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLitemList[0]['pre_delivery_date']){
                                        $delivery_date= $fetchALLitemList[0]['pre_delivery_date'];
                                     }else{
                                        $delivery_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="order_quantity">Delivery Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$delivery_date;?>" i id="delivery_date" name="delivery_date">
                                            <p class="error delivery_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="generate_po">Generate PO <span class="required">*</span></label>
                                                 <select class="form-control" name="generate_po" id="generate_po">
                                                    <option value="">Select Generate PO </option>
                                                    <option value="YES" <?php if($fetchALLitemList[0]['pre_generate_po']=='YES'){ echo 'selected';} ?> selected>YES</option>
                                                    <option value="NO"  <?php if($fetchALLitemList[0]['pre_generate_po']=='NO'){ echo 'selected';} ?>>NO</option>
                                                 </select>
                                            <p class="error generate_po_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_status">PO Status<span class="required">*</span></label>
                                                 <select class="form-control" name="po_status" id="po_status">
                                                    <option value="">Select PO Status </option>
                                                    <option value="Open" <?php if($fetchALLitemList[0]['pre_po_status']=='Open'){ echo 'selected';} ?> selected>Open</option>
                                                    <option value="Close"  <?php if($fetchALLitemList[0]['pre_po_status']=='Close'){ echo 'selected';} ?>>Close</option>
                                                 </select>
                                            <p class="error pre_po_status_error"></p>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_open_close_status">PO Open / Close Status  <span class="required">*</span></label>
                                                 <select class="form-control" name="po_open_close_status" id="po_open_close_status">
                                                    <option value="">Select Generate PO </option>
                                                    <option value="OPEN" <?php if($fetchALLitemList[0]['pre_generate_po']=='YES'){ echo 'selected';} ?>>YES</option>
                                                    <option value="CLOSE"  <?php if($fetchALLitemList[0]['pre_generate_po']=='NO'){ echo 'selected';} ?>>NO</option>
                                                 </select>
                                            <p class="error po_open_close_status_error"></p>
                                        </div>
                                    </div> -->


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required> <?=$fetchALLitemList[0]['pre_remark'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Order Qty</th>
                                                        <th>Unit</th>
                                                        <th>Rate</th>
                                                        <th>Value</th>
                                                        <th>Buyer PO Delivery Date</th>
                                                        <th>Packaging Instraction</th>
                                                        <th>Item PO Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['order_oty'];?></td>
                                                        <td><?php echo $value['unit'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td><?php echo $value['buyer_po_part_delivery_date'];?></td>
                                                        <td><?php echo $value['packaging_instraction'];?></td>
                                                        <td><?php echo $value['item_po_status'];?></td>
                                                        <td>
                                                          <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-pencil-square-o editbuyerpoitem'  aria-hidden='true'></i>
                                                          <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-trash-o deleteBuyerpoitem' aria-hidden='true'></i>
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
                                            <form role="form" id="addbuyeritemform" action="<?php echo base_url() ?>addbuyeritem" method="post" role="form">


                                            <input type="hidden" class="form-control"  id="buyer_po_item_id" name="buyer_po_item_id" required readonly>
                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Part Number <span class="required">*</span> (<small>Finished Goods Master</small>)</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <?php foreach ($finishgoodList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['fin_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Order Quantity <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="qty" name="qty">
                                                            <p class="error qty_error"></p>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Unit</label>
                                                        <div class="col-sm-9">
                                                             <select class="form-control" name="unit" id="unit">
                                                                <option value="">Select Part Name</option>
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
                                                        <label class="col-sm-3 col-form-label">Rate <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="rate" name="rate">
                                                            <p class="error rate"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Value <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="value" name="value" readonly>
                                                            <p class="error value_error"></p>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Buyer PO Part Delivery Date <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control datepicker"  id="buyer_po_part_delivery_date" name="buyer_po_part_delivery_date">
                                                            <p class="error buyer_po_part_delivery_date_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Packaging Instruction</label>
                                                        <div class="col-sm-9">
                                                             <select class="form-control" name="packaging_instraction" id="packaging_instraction">
                                                                <option value="">Select Packaging Instruction</option>
                                                                <option value="Open" selected>Open</option>
                                                                <option value="Close">Close</option>
                                                             </select>
                                                            <p class="error packaging_instraction_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Item PO Status<span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <select class="form-control" name="item_po_status" id="item_po_status">
                                                                <option value="">Select Item PO Status</option>
                                                                <option value="from_po" selected>From PO</option>
                                                                <option value="from_stock">From Stock</option>
                                                             </select>
                                                            <p class="error item_po_status_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Inco Terms</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"  id="inco_terms" name="inco_terms">
                                                            <p class="error inco_terms_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closebuyerpo" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savebuyeritem" name="savebuyeritem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>

                                    <input type="submit" id="savenewbuyerpo" class="btn btn-primary" value="Submit"   <?=$disabled;?>/>
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>buyerpo'" class="btn btn-default" value="Back" />
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

