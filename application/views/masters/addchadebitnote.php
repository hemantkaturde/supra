<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->

<script>
$(document).ready(function() {
    var i = 1;
    $('#add_more').click(function() {
        i++;
        $('#dynamic_field').append(
            '<div style="margin-left: 14px;margin-right: 35px;padding:5px;background:antiquewhite"><div style="padding: 4px;" class="row" id="row' +
            i +
            '"><div class="col-md-3"><div class="form-group"><label for="AWB_No">AWB No <span class="required">*</span></label> <input type="text" class="form-control" id="AWB_No" name="AWB_No[]" required> <p class="error AWB_No_error"></p></div></div><div class="col-md-2"><div class="form-group"> <label for="debit_amount">Debit Amount</label> <input type="text" class="form-control" id="debit_amount" name="debit_amount[]" required> <p class="error debit_amount_error"></p> </div></div> <div class="col-md-2"> <div class="form-group"> <label for="SGST">SGST</label> <input type="text" class="form-control" id="SGST" name="SGST[]" required> <p class="error SGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="CGST">CGST</label> <input type="text" class="form-control" name="CGST[]" required> <p class="error CGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="total">Total</label> <input type="text" class="form-control" id="total" name="total[]" required> <p class="error total_error"></p> </div> </div> <div class="col-md-1"> <div class="form-group" style="margin-top: 23px;"> <button type="button" name="remove" id="' +
            i +
            '" class="btn btn-danger btn_remove">X</button> </div> </div></div> </div> </div></div>'
            );
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});
</script>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add CHA Debit Note
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">CHA Debit Note Master</a></li>
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
                            <h3 class="box-title">Add Debit Note Detials</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savechadebitnoteform"
                            action="<?php echo base_url() ?>savechadebitnoteform" method="post" role="form">
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

                                if($getPreviousCHAdebitnotnumber['cha_debit_number']){
                                   
                                    $getfinancial_year = substr($getPreviousCHAdebitnotnumber['cha_debit_number'], -8);

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
                                        
                                        $string = $getPreviousCHAdebitnotnumber['cha_debit_number'];
                                        $n = 4; // Number of characters to extract from the end
                                        $lastNCharacters = substr($string, -$n);
                                        $inrno= "EXDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                        $CHA_debit_number = $inrno;

                                    } else {

                                        $getfinancial_year = substr($getPreviousCHAdebitnotnumber['cha_debit_number'], -8);

                                        $first_part_of_string = substr($getfinancial_year,0,4);

                                        if($first_part_of_string == $financial_year_indian){

                                            $string = $getPreviousCHAdebitnotnumber['cha_debit_number'];
                                            $n = 4; // Number of characters to extract from the end
                                            $lastNCharacters = substr($string, -$n);
                                            $inrno= "EXDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            $CHA_debit_number = $inrno;

                                        }else{

                                        $string = $getPreviousCHAdebitnotnumber['cha_debit_number'];
                                        $n = 4; // Number of characters to extract from the end
                                        $lastNCharacters1 = substr($string, -$n);

                                        if($lastNCharacters1  > 0){
                                            if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                $string1 =$getPreviousCHAdebitnotnumber['cha_debit_number'];
                                            }else{
                                                $string1 =0;
                                            }                                                   
                                        }else{
                                            $string1 =0;
                                        }

                                        $n = 4; // Number of characters to extract from the end
                                        $lastNCharacters = substr($string1, -$n);
                                        $inrno= "EXDN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                        $CHA_debit_number = $inrno;
                                     }

                                    }  
                                    /* New Logic End Here */
                                }else{
                                    $CHA_debit_number = 'EXDN'.$financial_year_indian.'0001';
                                }
                                ?>


                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cha_debit_note_number">CHA Debit Note Number <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="cha_debit_note_number"
                                                name="cha_debit_note_number"  value="<?=$CHA_debit_number?>" required readonly>
                                            <p class="error cha_debit_note_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cha_debit_note_date">CHA Debit Note Date <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="cha_debit_note_date"
                                                name="cha_debit_note_date" required>
                                            <p class="error cha_debit_note_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cha_name_date">CHA Name <span
                                                    class="required">*</span></label>
                                            <select class="form-control" name="cha_name" id="cha_name">
                                                <option st-id="" value="">Select CHA Name</option>
                                                <?php foreach ($getchamaster as $key => $value) {?>
                                                <option value="<?php echo $value['cha_id']; ?>">
                                                    <?php echo $value['cha_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <p class="error cha_name_error"></p>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input type="text" class="form-control" id="subject"
                                                name="subject" required>
                                            <p class="error subject_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_1">Invoice 1</label>
                                            <input type="text" class="form-control" id="invoice_1"
                                                name="invoice_1" required>
                                            <p class="error invoice_1_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_2">Invoice 2 </label>
                                            <input type="text" class="form-control" id="invoice_2"
                                                name="invoice_2" required>
                                            <p class="error invoice_2_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_3">Invoice 3</label>
                                            <input type="text" class="form-control" id="invoice_3"
                                                name="invoice_3" required>
                                            <p class="error invoice_3_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_1">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_1"
                                                name="date_1" required>
                                            <p class="error date_1_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_2">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_2"
                                                name="date_2" required>
                                            <p class="error date_2_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_3">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_3"
                                                name="date_3" required>
                                            <p class="error date_3_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body" id="dynamic_field">
                                <div style="margin-left: 14px;margin-right: 35px;padding:5px;background:antiquewhite">
                                    <div class="row" style="padding: 4px;">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="AWB_No">AWB No <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="AWB_No" name="AWB_No[]"
                                                    required>
                                                <p class="error AWB_No_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="debit_amount">Debit Amount <span
                                                        class="required">*</span></label>
                                                <input type="number" class="form-control" id="debit_amount"
                                                    name="debit_amount[]" required>
                                                <p class="error debit_amount_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="SGST">SGST</label>
                                                <input type="number" class="form-control" id="SGST" name="SGST[]"
                                                    required>
                                                <p class="error SGST_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="number">CGST</label>
                                                <input type="text" class="form-control" id="CGST" name="CGST[]"
                                                    required>
                                                <p class="error CGST_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="number">Total</label>
                                                <input type="text" class="form-control" id="total" name="total[]"
                                                    required>
                                                <p class="error total_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group" style="margin-top: 23px;">
                                                <input type="button" id="add_more" class="btn btn-primary"
                                                    value="+ Add More" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body">
                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="taxable_amount">Taxable Amount</label>
                                            <input type="text" class="form-control" id="taxable_amount"
                                                name="taxable_amount" required>
                                            <p class="error taxable_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cgst_sgst">CGST + SGST 18 %</label>
                                            <input type="text" class="form-control" id="cgst_sgst" name="cgst_sgst"
                                                required>
                                            <p class="error cgst_sgst_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bill_amount">Bill Amount (inc GST)</label>
                                            <input type="text" class="form-control" id="bill_amount" name="bill_amount"
                                                required>
                                            <p class="error bill_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="debit_amount_total">Debit Amount (Rs)</label>
                                            <input type="text" class="form-control debit_amount_total" id="debit_amount_total"
                                                name="debit_amount_total" required>
                                            <p class="error debit_amount_total_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount_payable_before_tds">Amount Payable Before TDS</label>
                                            <input type="text" class="form-control" id="amount_payable_before_tds"
                                                name="amount_payable_before_tds" required>
                                            <p class="error amount_payable_before_tds_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="less_tds">Less TDS</label>
                                            <input type="text" class="form-control" id="less_tdsss" name="less_tds"
                                                required>
                                            <p class="error less_tds_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="number">Payable Amount</label>
                                            <input type="text" class="form-control" id="payable_amount" name="payable_amount"
                                                name="payable_amount" required>
                                            <p class="error payable_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="number">Remark</label>
                                            <input type="text" class="form-control" name="remark"
                                                name="remark" required>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savechadebitnote" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>chadebitnote'"
                                    class="btn btn-default" value="Back" />
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
