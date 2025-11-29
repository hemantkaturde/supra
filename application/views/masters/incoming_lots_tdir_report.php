<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Inspection Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Inspection Report</a></li>
                </ul>
            </small>
        </h1>
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>tdir">
                        <i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
    </section>

    
    <input type="hidden" class="form-control" value="<?php echo $getTdirdata[0]['vendor_po']; ?>" id="vendor_po_id" name="vendor_po_id">
    <input type="hidden" class="form-control" value="<?php echo $getTdirdata[0]['tdir_id']; ?>" id="tdir_id" name="tdir_id">


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add Inspection Report</h3>

                            <h4>
                                <p><b>Inspection Report Number :</b> <?=$getTdirdata[0]['report_number'] ?></p>
                                <p><b>Vendor Name :</b> <?=$getTdirdata[0]['vendor_name_label'] ?></p>
                                <p><b>Vendor PO Number :</b> <?=$getTdirdata[0]['po_number'] ?></p>
                                <p><b>Part Number :</b> <?=$getTdirdata[0]['part_number_label'] ?></p>
                                <p><b>Vendor Order Qty :</b> <?=$getTdirdata[0]['vendor_order_qty'] ?></p>
                            </h4>
                        </div>
                        <?php $this->load->helper("form"); ?>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Incoming Lots</h2>

                                        <div class="lots-container">

                                            <?php  
                                    
                          
                                          // foreach ($getincoinglotdetailsfortdir as $key => $value) { ?>


                                            <!-- <div class="lot-box">
                                                <h3>Lot 1</h3>
                                                <div class="lot-details">
                                                    <p><strong>Invoice Qty:</strong> <?=$value['invoice_qty']  ?></p>
                                                    <p><strong>Invoice Date:</strong> <?=$value['invoice_date']  ?></p>
                                                    <p><strong>Material Grade:</strong> <?=$value['material_grade']  ?>
                                                    </p>
                                                    <p><strong>Additional Process:</strong>
                                                        <?=$value['additional_process']  ?></p>
                                                </div>
                                                <div class="form-section">
                                                    <label>Qty:</label>
                                                    <input type="number" placeholder="Enter qty">

                                                    <label>Checking:</label>
                                                    <input type="checkbox"> Done

                                                    <label>Checked By:</label>
                                                    <input type="text" placeholder="Enter name">

                                                    <button class="btn">Save</button>
                                                </div>
                                            </div> -->

                                            <?php //}  ?>


                                        
                                           <div class="container-fluid py-4">
                                            <form id="submittdirincominglotdataform" method="post">
                                                <div class="row g-4 justify-content-center">
                                                    <?php foreach ($getincoinglotdetailsfortdir as $key => $value) { ?>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                                            <div class="lot-box">
                                                                <div class="lot-title">Lot <?= $key + 1 ?></div>

                                                                <p><strong>Invoice Qty:</strong> <?= $value['invoice_qty'] ?></p>
                                                                <p><strong>Invoice Date:</strong> <?= $value['invoice_date'] ?></p>
                                                                <p><strong>Material Grade:</strong> <?= $value['material_grade'] ?></p>
                                                                <p><strong>Additional Process:</strong> <?= $value['additional_process_part'] ?></p>

                                                                <!-- Hidden Inputs -->
                                                                <input type="hidden" name="lots[<?= $key ?>][incoming_id]" value="<?= $value['incoming_id'] ?>">
                                                                <input type="hidden" name="lots[<?= $key ?>][incomping_details_item_id]" value="<?= $value['incomping_details_item_id'] ?>">
                                                                <input type="hidden" name="lots[<?= $key ?>][fin_part_id]" value="<?= $value['fin_id'] ?>">
                                                                <input type="hidden" name="lots[<?= $key ?>][vendor_po_id]" value="<?= $getTdirdata[0]['vendor_po'] ?>">
                                                                <input type="hidden" name="lots[<?= $key ?>][tdir_id]" value="<?= $getTdirdata[0]['tdir_id'] ?>">

                                                                <input type="hidden" name="lots[<?= $key ?>][lot_id]" value="<?= $getincomingcheckedbydata[$key]['id'] ?>">

                                                                <!-- Form Inputs -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Qty</label>
                                                                    <input type="number" class="form-control" name="lots[<?= $key ?>][qty]" Value="<?= $getincomingcheckedbydata[$key]['qty']?>" required>
                                                                </div>

                                                                <?php  if($getincomingcheckedbydata[$key]['checking']==1){ 
                                                                      $checked = 'checked';
                                                                 }else{
                                                                       $checked = '';
                                                                 } ?>

                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="checkbox" name="lots[<?= $key ?>][checking]" value="<?= $getincomingcheckedbydata[$key]['checking'] ?? '' ?>" id="check_<?= $key ?>" <?php echo $checked; ?> >
                                                                    <label class="form-check-label" for="check_<?= $key ?>">Checking Done</label>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Checked By</label>
                                                                    <input type="text" class="form-control" name="lots[<?= $key ?>][checked_by]" Value="<?= $getincomingcheckedbydata[$key]['checked_by']?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" id="submittdirincominglotdata" class="btn btn-primary px-5 py-2">
                                                        Save All
                                                    </button>
                                                </div>
                                            </form>
                                           </div>



                                        </div>

                                    </div>
                                </div>

                            </div>
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



<style>
    .lot-box {
        background: #ffffff;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease-in-out;
    }
    .lot-box:hover {
        transform: scale(1.02);
    }
    .lot-title {
        font-size: 20px;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .container-fluid {
        background: #f4f6f9;
        min-height: 100vh;
        padding: 30px;
    }
    .form-label {
        font-weight: 600;
    }
    .btn-primary {
        font-size: 18px;
        font-weight: 500;
        border-radius: 10px;
    }
</style>
