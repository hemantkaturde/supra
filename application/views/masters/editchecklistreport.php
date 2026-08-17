<style>
    .select2-container--default{

       width: 287px !important;
}
    </style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit CheckList Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">CheckList Report</a></li>
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
                            <h3 class="box-title">Edit CheckList Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addchecklistreportform" action="<?php echo base_url() ?>addchecklistreportform" method="post" role="form">
                            <div class="box-body">


                                    <input type="hidden" class="form-control" id="checklist_id" value="<?php echo $getpreviouschecklistreportrecord[0]['checklist_id']; ?>" name="checklist_id">

                                    <div class="row">
                                     <div class="col-md-3" id="vendor_div">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name</label>
                                                    <select class="form-control" name="buyer_name" id="buyer_name">
                                                        <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>"  <?php if($getpreviouschecklistreportrecord[0]['buyer_id']==$value['buyer_id']){ echo 'selected'; } ?>><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_invoice_no">Buyer Invoice No</label>
                                               <input type="text" class="form-control" id="buyer_invoice_no" value="<?php echo $getpreviouschecklistreportrecord[0]['invoice_no']; ?>" name="buyer_invoice_no">
                                            <p class="error buyer_invoice_no_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <?php  
                                
                                 if($getpreviouschecklistreportrecord[0]['invoice_date']=='0000-00-00'){
                                   $invoice_date_buyer_invoice_date = '';
                                 }else{
                                    $invoice_date_buyer_invoice_date = $getpreviouschecklistreportrecord[0]['invoice_date'];
                                 }
                                
                                ?>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_po">Buyer Invoice Date</label>
                                            <input type="text" class="form-control datepicker" id="buyer_invoice_date" value="<?php echo $invoice_date_buyer_invoice_date; ?>"  name="buyer_invoice_date">
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" value="<?php echo $getpreviouschecklistreportrecord[0]['remark']; ?>"  name="remark">
                                            </select> 
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addchecklistreportformsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>checklistreport'" class="btn btn-default" value="Back" />
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
 $(function () {
    $(".datetimepicker").datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        controlType: "select",
        oneLine: true,
        minDate: 0
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">