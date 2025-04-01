<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Supplier PO
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Supplier PO Master</a></li>
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
                            <h3 class="box-title">Add Supplier PO Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewSupplierform" action="<?php echo base_url() ?>addnewSupplierform"
                            method="post" role="form">
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


                                        if($getPreviousvendorPONumber['po_number']){
                                    

                                             $getPreviousvendorPONumber_number = substr($getPreviousvendorPONumber['po_number'], -4);
                                             $getPreviousPONumber_number = substr($getPreviousPONumber['po_number'], -4);
                                           
                                              $getfinancial_year = substr($getPreviousvendorPONumber['po_number'], -8);

                                              $first_part_of_string = substr($getfinancial_year,0,4);
                                           
                                              if($first_part_of_string == $financial_year_indian){
                                           
                                               if($getPreviousvendorPONumber_number > $getPreviousPONumber_number){

                                            
                                              
                                                    if($getPreviousvendorPONumber_number){
                                                        echo "in 2 condition";
                                                        // $arr = str_split($getPreviousvendorPONumber_number);
                                                        // $i = end($arr);
                                                        // $inrno= "SQPO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                        // $po_number = $inrno;

                                                        // $string = $getPreviousvendorPONumber_number;
                                                        // $n = 4; // Number of characters to extract from the end
                                                        // $lastNCharacters = substr($string, -$n);
                                                        // $inrno= "SQPO2425".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        // $po_number = $inrno;

                                                        /* New Logic Statrt Here */ 
                                                        /* get finaicial Year from the Serial Number*/
                                                            $getfinancial_year = substr($getPreviousvendorPONumber['po_number'], -8);
            
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
                                                            
                                                                $string = $getPreviousvendorPONumber_number;
                                                                $n = 4; // Number of characters to extract from the end
                                                                $lastNCharacters = substr($string, -$n);
                                                                $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                $po_number = $inrno;

                                                            } else {

                                                                $getfinancial_year = substr($getPreviousPONumber['po_number'], -8);

                                                                $first_part_of_string = substr($getfinancial_year,0,4);

                                                                if($first_part_of_string == $financial_year_indian){


                                                                        $string = $getPreviousPONumber['po_number'];
                                                                        $n = 4; // Number of characters to extract from the end
                                                                        $lastNCharacters = substr($string, -$n);
                                                                        $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                        $po_number = $inrno;
                                                                }else{


                                                                    
                                                                    $string = 0;
                                                                    $n = 0; // Number of characters to extract from the end
                                                                    $lastNCharacters = substr($string, -$n);
                                                                    $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                    $po_number = $inrno;


                                                                }

                                                                //$po_number = 'SQPO24250001';
                                                            }  
                                                        /* New Logic End Here */

                                                    }else{


                                                        $getfinancial_year = substr($getPreviousvendorPONumber_number['po_number'], -8);

                                                        $first_part_of_string = substr($getfinancial_year,0,4);

                                                        if($first_part_of_string == $financial_year_indian){

                                                        $string = $getPreviousvendorPONumber_number['po_number'];
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $po_number = $inrno;
                                                    // $po_number = 'SQPO'.$financial_year_indian.'0001';
                                                        }else{

                                                            
                                                            
                                                        $string = 0;
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $po_number = $inrno;
                                                    // $po_number = 'SQPO'.$financial_year_indian.'0001';



                                                        }
                                                    }  
                                                
                                                }else{
                                                   // $po_number = 'SQPO'.$financial_year_indian.'0001';
                                                   $getfinancial_year = substr($getPreviousPONumber['po_number'], -8);

                                                   $first_part_of_string = substr($getfinancial_year,0,4);

                                                   if($first_part_of_string == $financial_year_indian){

                                                       $string = $getPreviousPONumber['po_number'];
                                                       $n = 4; // Number of characters to extract from the end
                                                       $lastNCharacters = substr($string, -$n);
                                                       $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                       //$po_number = $inrno;
                                                       $po_number = $inrno;

                                                   }else{
                                                       $string = 0;
                                                       $n = 0; // Number of characters to extract from the end
                                                       $lastNCharacters = substr($string, -$n);
                                                       $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                       $po_number = $inrno;
                                                   
                                                   }

                                                }
                                                    

                                               
                                                }else{
                                                    if($getPreviousPONumber_number){
                                                        // $arr = str_split($getPreviousPONumber_number);
                                                        // $i = end($arr);
                                                        // $inrno= "SQPO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                        // $po_number = $inrno;

                                                        // $string = $getPreviousPONumber_number;
                                                        // $n = 4; // Number of characters to extract from the end
                                                        // $lastNCharacters = substr($string, -$n);
                                                        // $inrno= "SQPO2425".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        // $po_number = $inrno;


                                                        /* New Logic Statrt Here */ 
                                                        /* get finaicial Year from the Serial Number*/
                                                        $getfinancial_year = substr($getPreviousPONumber['po_number'], -8);
            
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
                                                            
                                                                $string = $getPreviousPONumber['po_number'];
                                                                $n = 4; // Number of characters to extract from the end
                                                                $lastNCharacters = substr($string, -$n);
                                                                $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                $po_number = $inrno;

                                                        } else {

                                                            echo "in 5 condition";
                                                            $getfinancial_year = substr($getPreviousvendorPONumber['po_number'], -8);

                                                            $first_part_of_string = substr($getfinancial_year,0,4);
                                            

                                                            if($first_part_of_string == $financial_year_indian){

                                                                $string = $getPreviousvendorPONumber['po_number'];
                                                                $n = 4; // Number of characters to extract from the end
                                                                $lastNCharacters = substr($string, -$n);
                                                                $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                $po_number = $inrno;
                                                            }else{

                                                                $string = 0;
                                                                $n =0; // Number of characters to extract from the end
                                                                $lastNCharacters = substr($string, -$n);
                                                                $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                                $po_number = $inrno;
                                                            }


                                                        }  
                                                        /* New Logic End Here */
                                                    }else{
                                                        $po_number = 'SQPO'.$financial_year_indian.'0001';
                                                    }   
                                                }

                                                }else{
                                        
                                                if($getPreviousPONumber['po_number']){
                                                // $arr = str_split($getPreviousPONumber['po_number']);
                                                // $i = end($arr);
                                                // $inrno= "SQPO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                // $po_number = $inrno;

                                                // $string = $getPreviousPONumber['po_number'];
                                                // $n = 4; // Number of characters to extract from the end
                                                // $lastNCharacters = substr($string, -$n);
                                                // $inrno= "SQPO2425".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                // $po_number = $inrno;
                                                
                                                    /* New Logic Statrt Here */ 
                                                      /* get finaicial Year from the Serial Number*/
                                                      $getfinancial_year = substr($getPreviousPONumber['po_number'], -8);
        
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
                                                         
                                                          $string = $getPreviousPONumber['po_number'];
                                                          $n = 4; // Number of characters to extract from the end
                                                          $lastNCharacters = substr($string, -$n);
                                                          $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                          $po_number = $inrno;

                                                      } else {
                                                        echo "in 6 condition";
                                                        $getfinancial_year = substr($getPreviousPONumber['po_number'], -8);

                                                        $first_part_of_string = substr($getfinancial_year,0,4);

                                                        if($first_part_of_string == $financial_year_indian){


                                                          $string = $getPreviousPONumber['po_number'];
                                                          $n = 4; // Number of characters to extract from the end
                                                          $lastNCharacters = substr($string, -$n);
                                                          $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                          $po_number = $inrno;
                                                        }else{


                                                            $string = 0;
                                                            $n = 4; // Number of characters to extract from the end
                                                            $lastNCharacters = substr($string, -$n);
                                                            $inrno= "SQPO".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                            $po_number = $inrno;

                                                        }

                                                      }  
                                                    /* New Logic End Here */


                                            }else{
                                                $po_number = 'SQPO'.$financial_year_indian.'0001';
                                            }

                                        }


                                        // if($getPreviousPONumber['po_number']){
                                        //     $arr = str_split($getPreviousPONumber['po_number']);
                                        //     $i = end($arr);
                                        //     $inrno= "SQPO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                        //     $po_number = $inrno;
                                        // }else{
                                        //     $po_number = 'SQPO23240001';
                                        // }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_number">PO Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="po_number" name="po_number"
                                                value="<?=$po_number?>" required readonly>
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpresupplieritemList[0]['pre_date']){
                                        $date= $fetchALLpresupplieritemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?=$date?>"
                                                id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name <span
                                                    class="required">*</span></label>
                                            <select class="form-control" name="supplier_name" id="supplier_name">
                                                <option st-id="" value="">Select Supplier Name</option>
                                                <?php foreach ($supplierList as $key => $value) {?>
                                                <option value="<?php echo $value['sup_id']; ?>"
                                                    <?php if($value['sup_id']==$fetchALLpresupplieritemList[0]['pre_supplier_name']){ echo 'selected';} ?>>
                                                    <?php echo $value['supplier_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                            <select class="form-control" name="buyer_name" id="buyer_name">
                                                <option st-id="" value="">Select Buyer Name</option>
                                                <?php foreach ($buyerList as $key => $value) {?>
                                                <option value="<?php echo $value['buyer_id']; ?>"
                                                    <?php if($value['buyer_id']==$fetchALLpresupplieritemList[0]['pre_buyer_name']){ echo 'selected';} ?>>
                                                    <?php echo $value['buyer_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpresupplieritemList[0]['pre_buyer_po_number']){
                                        $display='block';
                                        $selected_value = $fetchALLpresupplieritemList[0]['sales_order_number'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?>


                                    <div class="col-md-12 buyer_po_number_div" style="display:<?=$display;?>">
                                        <div class="form-group">
                                            <label for="buyer_po_number">Select Buyer PO Number <span
                                                    class="required">*</span></label>
                                            <select class="form-control buyer_po_number_for_item" name="buyer_po_number"
                                                id="buyer_po_number">
                                                <option st-id=""
                                                    value="<?=$fetchALLpresupplieritemList[0]['pre_buyer_po_number']?>"
                                                    selected><?=$selected_value;?></option>
                                                <!-- <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpresupplieritemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?> -->
                                            </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                            <select class="form-control" name="vendor_name" id="vendor_name">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                <?php foreach ($vendorList as $key => $value) {?>
                                                <option value="<?php echo $value['ven_id']; ?>"
                                                    <?php if($value['ven_id']==$fetchALLpresupplieritemList[0]['pre_vendor_name']){ echo 'selected';} ?>>
                                                    <?php echo $value['vendor_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="quatation_ref_no">Quotation Ref No.</label>
                                            <input type="text" class="form-control" id="quatation_ref_no"
                                                value="<?=$fetchALLpresupplieritemList[0]['pre_quatation_ref_number'];?>"
                                                name="quatation_ref_no">
                                            <p class="error quatation_ref_no_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpresupplieritemList[0]['pre_quatation_date']){
                                        $buyer_po_date= $fetchALLpresupplieritemList[0]['pre_quatation_date'];
                                     }else{
                                        //$buyer_po_date= date('Y-m-d');
                                        $buyer_po_date= '';
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="quatation_date">Quotation Date</label>
                                            <input type="text" class="form-control datepicker"
                                                value="<?=$buyer_po_date;?>" id="quatation_date" name="quatation_date"
                                                required>
                                            <p class="error quatation_date_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpresupplieritemList[0]['pre_delivery_date']){
                                        $delivery_date= $fetchALLpresupplieritemList[0]['pre_delivery_date'];
                                     }else{
                                        $delivery_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery_date">Delivery Date <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"
                                                value="<?=$delivery_date;?>" i id="delivery_date" name="delivery_date">
                                            <p class="error delivery_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery">Delivery </label>
                                            <input type="text" class="form-control" id="delivery"
                                                value="<?=$fetchALLpresupplieritemList[0]['pre_delivery'];?>"
                                                name="delivery">
                                            <p class="error delivery_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery_address">Delivery Address</label>
                                            <textarea type="text" class="form-control" id="delivery_address"
                                                name="delivery_address"
                                                required> <?=$fetchALLpresupplieritemList[0]['pre_deliveey_address'];?></textarea>
                                            <p class="error delivery_address_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="work_order">Payment Terms </label>
                                            <input type="text" class="form-control" id="work_order"
                                                value="<?=$fetchALLpresupplieritemList[0]['pre_work_order'];?>"
                                                name="work_order">
                                            <p class="error work_order_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <textarea type="text" class="form-control" id="remark" name="remark"
                                                required> <?=$fetchALLpresupplieritemList[0]['pre_remark'];?></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl createnewitem"
                                            data-toggle="modal" data-target="#addNewModal">Add New
                                            Items</button><br /><br />
                                        <table class="table table-bordered"
                                            style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                            <thead style="background-color:#3c8dbc;color:#fff">
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Part Number</th>
                                                    <th>Description</th>
                                                    <th>Vendor Qty</th>
                                                    <th>Order Qty</th>
                                                    <th>Unit</th>
                                                    <th>Rate</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count=0;
                                                           foreach ($fetchALLpresupplieritemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                <tr>
                                                    <td><?php echo $count;?></td>
                                                    <td><?php echo $value['part_number'];?></td>
                                                    <td><?php echo $value['description'];?></td>
                                                    <td><?php echo $value['vendor_qty'];?></td>
                                                    <td><?php echo $value['order_oty'];?></td>
                                                    <td><?php echo $value['unit'];?></td>
                                                    <td><?php echo $value['rate'];?></td>
                                                    <td><?php echo $value['value'];?></td>
                                                    <td>
                                                        <i style='font-size: x-large;cursor: pointer'
                                                            data-id='<?php echo $value['supplirid'];?>'
                                                            class='fa fa-pencil-square-o editSupplierpoitem'
                                                            aria-hidden='true'></i>
                                                        <i style='font-size: x-large;cursor: pointer'
                                                            data-id='<?php echo $value['supplirid'];?>'
                                                            class='fa fa-trash-o deleteSupplierpoitem'
                                                            aria-hidden='true'></i>
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
                                                <form role="form" id="addbuyeritemform"
                                                    action="<?php echo base_url() ?>addbuyeritem" method="post"
                                                    role="form">

                                                    <input type="hidden" class="form-control" id="supplier_po_item_id"
                                                        name="supplier_po_item_id" required readonly>

                                                    <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img
                                                                    src="<?php echo ICONPATH;?>/preloader_ajax.gif">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row " id="part_number_old">
                                                            <label class="col-sm-3 col-form-label">Part Number <span
                                                                    class="required">*</span> (<small>Row Material Goods
                                                                    Master</small>)</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="part_number"
                                                                    id="part_number">
                                                                    <option st-id="" value="">Select Part Name</option>
                                                                    <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                        <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                    <?php } ?> -->
                                                                </select>
                                                                <p class="error part_number_error"></p>

                                                            </div>
                                                        </div>



                                                        <div class="form-group row" id="part_number_new">
                                                            <label class="col-sm-3 col-form-label">Part Number <span
                                                                    class="required">*</span> (<small>Row Material Goods
                                                                    Master</small>)</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="part_number_1"
                                                                    id="part_number_1" disabled>
                                                                    <option st-id="" value="">Select Part Name</option>
                                                                    <?php foreach ($rowMaterialList as $key => $value) {?>
                                                                    <option value="<?php echo $value['raw_id']; ?>">
                                                                        <?php echo $value['part_number']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="hidden" class="form-control"
                                                                    id="part_number_1_edit" name="part_number_1_edit"
                                                                    required readonly>
                                                                <p class="error part_number_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Part Name <span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="description"
                                                                    name="description" required readonly>
                                                                <p class="error description_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Diameter </label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="diameter"
                                                                    name="diameter" required readonly>
                                                                <p class="error diameter_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Slitting Size</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control"
                                                                    id="slitting_size" name="slitting_size" required
                                                                    readonly>
                                                                <p class="error slitting_size_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Thickness</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="thickness"
                                                                    name="thickness" required readonly>
                                                                <p class="error thickness_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Hex A/F</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="hex_af"
                                                                    name="hex_af" required readonly>
                                                                <p class="error hex_af_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">HSN Code</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="hsn_code"
                                                                    name="hsn_code" required readonly>
                                                                <p class="error hsn_code_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Length</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="length"
                                                                    name="length" required readonly>
                                                                <p class="error length_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Gross Weight</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control"
                                                                    id="gross_weight" name="gross_weight" required
                                                                    readonly>
                                                                <p class="error gross_weight_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Net Weight</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="net_weight"
                                                                    name="net_weight" required readonly>
                                                                <p class="error net_weight_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">SAC</label>
                                                            <div class="col-sm-9">
                                                                <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                                <input type="type" class="form-control" id="sac"
                                                                    name="sac" required readonly>
                                                                <p class="error sac_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Description 1</label>
                                                            <div class="col-sm-9">
                                                                <textarea type="text" class="form-control"
                                                                    id="description_1" name="description_1"></textarea>
                                                                <p class="error  description_1_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Description 2</label>
                                                            <div class="col-sm-9">
                                                                <textarea type="text" class="form-control"
                                                                    id="description_2" name="description_2"></textarea>
                                                                <p class="error  description_2_error"></p>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Order Quantity <span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" id="qty"
                                                                    name="qty">
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
                                                            <label class="col-sm-3 col-form-label">Rate <span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" id="rate"
                                                                    name="rate">
                                                                <p class="error rate"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Value <span
                                                                    class="required">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" id="value"
                                                                    name="value">
                                                                <p class="error value"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Vendor Quantity (In
                                                                pcs)</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control"
                                                                    id="vendor_qty" name="vendor_qty">
                                                                <p class="error vendor_qty_error"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Remark</label>
                                                            <div class="col-sm-9">
                                                                <textarea type="text" class="form-control"
                                                                    id="item_remark" name="item_remark"></textarea>
                                                                <p class="error item_remark_error"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-secondary btn-xl closeSupplierpo"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" id="savesupplieritem"
                                                            name="savesupplieritem" class="btn btn-primary"
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
                            <?php if($fetchALLpresupplieritemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                            <input type="submit" id="savenewsupplierpo" class="btn btn-primary" value="Submit"
                                <?=$disabled;?> />
                            <input type="button" onclick="location.href = '<?php echo base_url() ?>supplierpo'"
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