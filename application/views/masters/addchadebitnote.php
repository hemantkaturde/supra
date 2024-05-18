<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->

<script>
$(document).ready(function(){
	var i=1;
	$('#add_more').click(function(){
	     i++;
	     $('#dynamic_field').append('<div class="row" id="row'+i+'"><div class="col-md-3"><div class="form-group"><label for="AWB_No">AWB No <span class="required">*</span></label> <input type="text" class="form-control" id="AWB_No" name="AWB_No[]" required> <p class="error AWB_No_error"></p></div></div><div class="col-md-2"><div class="form-group"> <label for="debit_amount">Debit Amount</label> <input type="text" class="form-control" id="debit_amount" name="debit_amount[]" required> <p class="error debit_amount_error"></p> </div></div> <div class="col-md-2"> <div class="form-group"> <label for="SGST">SGST</label> <input type="text" class="form-control" id="SGST" name="SGST[]" required> <p class="error SGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="CGST">CGST</label> <input type="text" class="form-control" name="CGST[]" required> <p class="error CGST_error"></p> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="total">Total</label> <input type="text" class="form-control" name="total[]" required> <p class="error total_error"></p> </div> </div> <div class="col-md-1"> <div class="form-group" style="margin-top: 23px;"> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> </div> </div> </div></div>');
	});
	
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
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
                            <h3 class="box-title">Add  Debit Note Detials</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savechadebitnoteform" action="<?php echo base_url() ?>savechadebitnoteform" method="post" role="form">
                            <div class="box-body" id="dynamic_field">
                                <div class="row" >
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AWB_No">AWB No <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="AWB_No" name="AWB_No[]" required>
                                            <p class="error AWB_No_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="debit_amount">Debit Amount <span class="required">*</span></label>
                                            <input type="number" class="form-control" id="debit_amount" name="debit_amount[]" required>
                                            <p class="error debit_amount_error"></p>
                                        </div>
                                    </div>

                                     
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="SGST">SGST</label>
                                            <input type="number" class="form-control" id="SGST" name="SGST[]" required>
                                            <p class="error SGST_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="number">CGST</label>
                                            <input type="text" class="form-control" id="CGST" name="CGST[]" required>
                                            <p class="error CGST_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="number">Total</label>
                                            <input type="text" class="form-control" name="total" name="total[]" required>
                                            <p class="error total_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group" style="margin-top: 23px;">
                                           <input type="button" id="add_more" class="btn btn-primary" value="+ Add More" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                   <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="taxable_amount">Taxable Amount</label>
                                                    <input type="text" class="form-control" id="taxable_amount" name="taxable_amount" required>
                                                    <p class="error taxable_amount_error"></p>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cgst_sgst">CGST + SGST 18 %</label>
                                                    <input type="text" class="form-control" id="cgst_sgst" name="cgst_sgst" required>
                                                    <p class="error cgst_sgst_error"></p>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bill_amount">Bill Amount (inc GST)</label>
                                                    <input type="text" class="form-control" id="bill_amount" name="bill_amount" required>
                                                    <p class="error bill_amount_error"></p>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="debit_amount">Debit Amount (Rs)</label>
                                                    <input type="text" class="form-control" id="debit_amount" name="debit_amount" required>
                                                    <p class="error debit_amount_error"></p>
                                                </div>
                                            </div>
                                    </div>

                                     <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="amount_payable_before_tds">Amount Payable Before TDS</label>
                                                    <input type="text" class="form-control" id="amount_payable_before_tds" name="amount_payable_before_tds" required>
                                                    <p class="error amount_payable_before_tds_error"></p>
                                                </div>
                                            </div>
                                    </div>


                                    <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="less_tds">Less TDS</label>
                                                    <input type="text" class="form-control" id="less_tds" name="less_tds" required>
                                                    <p class="error less_tds_error"></p>
                                                </div>
                                            </div>
                                    </div>


                                    <div class="row" >
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="number">Payable Amount</label>
                                                    <input type="text" class="form-control" name="payable_amount" name="payable_amount" required>
                                                    <p class="error payable_amount_error"></p>
                                                </div>
                                            </div>
                                    </div>
                            </div>


                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savechadebitnote" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>chadebitnote'" class="btn btn-default" value="Back" />
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