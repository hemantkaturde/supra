<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Export 
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Pre-Export</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Pre-Export Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savenewpreexportform" action="<?php echo base_url() ?>savenewpreexportform" method="post" role="form">
                            <div class="box-body">
                                    <?php
                                    
                                        $current_month = date("n"); // Get the current month without leading zeros

                                        if ($current_month >= 4) {
                                                // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                                $financial_year_indian = date("y") . "" . (date("y") + 1);
                                        } else {
                                                // If the current month is before April, the financial year is from April (last year) to March (current year)
                                                $financial_year_indian = (date("y") - 1) . "" . date("y");
                                        }

                                        if($getPreviousPreexport['pre_export_invoice_no']){
                                            // $arr = str_split($getPreviousCreditnotenumber['credit_note_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQCN2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $po_number = $inrno;

                                            // OLD LOGIC START HERE Commited ON 19-04-2024
                                            // $string = $getPreviousPreexport['pre_export_invoice_no'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "MG2324/".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $invoice_number = $inrno;

                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviousPreexport['pre_export_invoice_no'], -9);

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
                                                 
                                                  $string = $getPreviousPreexport['pre_export_invoice_no'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= "PEI".$financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $invoice_number = $inrno;
  
                                              } else {

                                                $getfinancial_year = substr($getPreviousPreexport['pre_export_invoice_no'], -9);

                                                $first_part_of_string = substr($getfinancial_year,0,4);
                                              
                                                 if($first_part_of_string==$financial_year_indian){

                                                    $string = $getPreviousPreexport['pre_export_invoice_no'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "PEI".$financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $invoice_number = $inrno;

                                                 }else{

                                                    $string = $getPreviousPreexport['pre_export_invoice_no'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviousPreexport['pre_export_invoice_no'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "PEI".$financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $invoice_number = $inrno;
                                                }
                                                  //$po_number = 'SQPO24250001';
                                              }  
                                            /* New Logic End Here */

                                        }else{
                                            //$invoice_number = 'MG-001/2324';
                                            $invoice_number = 'PEI'.$financial_year_indian.'/0001';
                                        }
                                    ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_number">Pre Export Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="invoice_number" value="<?=$invoice_number?>" name="invoice_number" required readonly>
                                            <p class="error invoice_number_error"></p>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="preexport_invoice_number">Invoice Number</label>
                                            <input type="text" class="form-control" id="preexport_invoice_number" name="preexport_invoice_number">
                                            <p class="error preexport_invoice_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                     <?php if($fetchALLpreCredititemList[0]['pre_date']){
                                        $date= $fetchALLpreCredititemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date<span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="date" value=<?=$date?> name="date" required>
                                            <p class="error date_error"></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
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
                                </div>    

                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po">Buyer PO<span class="required">*</span></label>
                                                <select class="form-control buyer_po_number_for_item" name="buyer_po_number" id="buyer_po_number">
                                                    <option st-id="" value="">Select Buyer PO</option>
                                                </select> 
                                        </div>
                                    </div>
                                </div> -->


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="total_no_of_pallets">Total No of Pallets </label>
                                                <input type="text" class="form-control" id="total_no_of_pallets" name="total_no_of_pallets">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="total_weight_of_pallets">Total Weight of Pallets </label>
                                                <input type="text" class="form-control" id="total_weight_of_pallets" name="total_weight_of_pallets">
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="pallet_1">Pallet 1 </label>
                                                <input type="text" class="form-control" id="pallet_1" name="pallet_1">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="pallet_2">Pallet 2 </label>
                                                <input type="text" class="form-control" id="pallet_2" name="pallet_2">
                                        </div>
                                    </div>
                                </div> -->

                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="mode_of_shipment">Mode of Shipment <span class="required">*</span></label>
                                                <select class="form-control mode_of_shipment" name="mode_of_shipment" id="mode_of_shipment">
                                                    <option st-id="" value="">Select Mode of Shipment</option>
                                                    <option st-id="" value="Air">Air</option>
                                                    <option st-id="" value="sea">Sea</option>
                                                </select>
                                            <p class="error mode_of_shipment_error"></p>
                                        </div>
                                    </div>
                                </div>  

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="fax">Remark </label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark" required></textarea>
                                                <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewpreexport" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>preexport'" class="btn btn-default" value="Back" />
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


$(document).ready(function(){
			$("select").select2();
	});

   $(function() {
			$(".datepicker").datepicker({ 
				// minDate: 0,
				todayHighlight: true,
                 dateFormat: 'yy-mm-dd',
				startDate: new Date()
			});
		});
</script>