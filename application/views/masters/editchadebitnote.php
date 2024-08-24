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
            '"><div class="col-md-3"><div class="form-group"><label for="AWB_No">AWB No <span class="required">*</span></label> <input type="text" class="form-control" id="AWB_No" name="AWB_No[]" required> <p class="error AWB_No_error"></p></div></div><div class="col-md-2"><div class="form-group"> <label for="debit_amount">Debit Amount</label> <input type="text" class="form-control" id="debit_amount" name="debit_amount[]" required> <p class="error debit_amount_error"></p> </div></div> <div class="col-md-2"> <div class="form-group"> <label for="SGST">SGST</label> <input type="text" class="form-control" id="SGST" name="SGST[]" required> <p class="error SGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="CGST">CGST</label> <input type="text" class="form-control" name="CGST[]" required> <p class="error CGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="total">Total</label> <input type="text" class="form-control" name="total[]" required> <p class="error total_error"></p> </div> </div> <div class="col-md-1"> <div class="form-group" style="margin-top: 23px;"> <button type="button" name="remove" id="' +
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

                            <input type="hidden" class="form-control" id="cha_debit_note_id"
                            name="cha_debit_note_id"  value="<?=$getchadebitnotedetails[0]['debit_note_id']?>" required readonly>

                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cha_debit_note_number">CHA Debit Note Number <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="cha_debit_note_number"
                                                name="cha_debit_note_number"  value="<?=$getchadebitnotedetails[0]['cha_debit_number']?>" required readonly>
                                            <p class="error cha_debit_note_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cha_debit_note_date">CHA Debit Note Date <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$getchadebitnotedetails[0]['cha_debit_note_date']?>"  id="cha_debit_note_date"
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
                                                <option value="<?php echo $value['cha_id']; ?>" <?php if($value['cha_id']==$getchadebitnotedetails[0]['cha_name_id']){ echo 'selected';} ?>>
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
                                            <input type="text" class="form-control"  value="<?=$getchadebitnotedetails[0]['subject']?>"  id="subject"
                                                name="subject" required>
                                            <p class="error subject_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_1">Invoice 1</label>
                                            <input type="text" class="form-control"  value="<?=$getchadebitnotedetails[0]['invoice_1']?>"  id="invoice_1"
                                                name="invoice_1" required>
                                            <p class="error invoice_1_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_2">Invoice 2 </label>
                                            <input type="text" class="form-control" id="invoice_2" value="<?=$getchadebitnotedetails[0]['invoice_2']?>"
                                                name="invoice_2" required>
                                            <p class="error invoice_2_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="invoice_3">Invoice 3</label>
                                            <input type="text" class="form-control" id="invoice_3" value="<?=$getchadebitnotedetails[0]['invoice_3']?>"
                                                name="invoice_3" required>
                                            <p class="error invoice_3_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_1">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_1" value="<?=$getchadebitnotedetails[0]['date_1']?>"
                                                name="date_1" required>
                                            <p class="error date_1_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_2">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_2" value="<?=$getchadebitnotedetails[0]['date_2']?>"
                                                name="date_2" required>
                                            <p class="error date_2_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_3">Date </label>
                                            <input type="text" class="form-control datepicker" id="date_3" value="<?=$getchadebitnotedetails[0]['date_3']?>"
                                                name="date_3" required>
                                            <p class="error date_3_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body" id="dynamic_field">
                                <div style="margin-left: 14px;margin-right: 35px;padding:5px;background:antiquewhite">
                                   

                                    <?php $i=1; foreach ($getcurrentorderdetails as $key => $value) { ?>

                                        <div class="row" style="padding: 4px;" id="row<?=$i?>">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="AWB_No">AWB No <span class="required">*</span></label>
                                                    <input type="text" class="form-control" value="<?=$value['AWB_No'] ?>" id="AWB_No" name="AWB_No[]"
                                                        required>
                                                    <p class="error AWB_No_error"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="debit_amount">Debit Amount <span
                                                            class="required">*</span></label>
                                                    <input type="number" class="form-control"  value="<?=$value['debit_amount'] ?>" id="debit_amount"
                                                        name="debit_amount[]" required>
                                                    <p class="error debit_amount_error"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="SGST">SGST</label>
                                                    <input type="number" class="form-control" id="SGST" value="<?=$value['SGST'] ?>" name="SGST[]"
                                                        required>
                                                    <p class="error SGST_error"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="number">CGST</label>
                                                    <input type="text" class="form-control" id="CGST"  value="<?=$value['CGST'] ?>" name="CGST[]"
                                                        required>
                                                    <p class="error CGST_error"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="number">Total</label>
                                                    <input type="text" class="form-control" id="total" value="<?=$value['total'] ?>"  name="total[]"
                                                        required>
                                                    <p class="error total_error"></p>
                                                </div>
                                            </div>

                                            <?php if($i==1){ ?>
                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-top: 23px;">
                                                    <input type="button" id="add_more" class="btn btn-primary"
                                                        value="+ Add More" />
                                                </div>
                                            </div>

                                            <?php }else{ ?>

                                                <button type="button" name="remove" id="<?=$i++; ?>" class="btn btn-danger btn_remove">X</button>

                                            <?php } ?>
                                            
                                        </div>

                                    <?php $i++; } ?>

                                </div>
                            </div>


                            <div class="box-body">
                                <div class="col-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="taxable_amount">Taxable Amount</label>
                                            <input type="text" class="form-control" id="taxable_amount" value="<?=$getchadebitnotedetails[0]['taxable_amount']?>"
                                                name="taxable_amount" required>
                                            <p class="error taxable_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cgst_sgst">CGST + SGST 18 %</label>
                                            <input type="text" class="form-control" id="cgst_sgst" name="cgst_sgst" value="<?=$getchadebitnotedetails[0]['cgst_sgst']?>"
                                                required>
                                            <p class="error cgst_sgst_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bill_amount">Bill Amount (inc GST)</label>
                                            <input type="text" class="form-control" id="bill_amount" name="bill_amount" value="<?=$getchadebitnotedetails[0]['bill_amount']?>"
                                                required>
                                            <p class="error bill_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="debit_amount_total">Debit Amount (Rs)</label>
                                            <input type="text" class="form-control" id="debit_amount_total" value="<?=$getchadebitnotedetails[0]['debit_amount']?>"
                                                name="debit_amount_total" required>
                                            <p class="error debit_amount_total_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount_payable_before_tds">Amount Payable Before TDS</label>
                                            <input type="text" class="form-control" id="amount_payable_before_tds" value="<?=$getchadebitnotedetails[0]['amount_payable_before_tds']?>"
                                                name="amount_payable_before_tds" required>
                                            <p class="error amount_payable_before_tds_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="less_tds">Less TDS</label>
                                            <input type="text" class="form-control" id="less_tds" name="less_tds"  value="<?=$getchadebitnotedetails[0]['less_tds']?>"
                                                required> 
                                            <p class="error less_tds_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="number">Payable Amount</label>
                                            <input type="text" class="form-control" name="payable_amount" value="<?=$getchadebitnotedetails[0]['payable_amount']?>"
                                                name="payable_amount" required>
                                            <p class="error payable_amount_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="number">Remark</label>
                                            <input type="text" class="form-control" name="remark" value="<?=$getchadebitnotedetails[0]['remark']?>"
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
