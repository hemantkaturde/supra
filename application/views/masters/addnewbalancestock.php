<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-hdd-o"></i> Add Balance Stock
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li><a href="javascript:void(0);">Balance Stock form</a></li>
                    <li class="active">Balance Stock Form</li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Balance Stock Form</h3>
                    </div>
                    
                    <form role="form" id="addTicketForm" method="post" action="#">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                        <select class="form-control" id="vendor_name" name="vendor_name">
                                            <option value="">Select Part No</option>
                                            <?php foreach($vendorList as $p): ?>
                                                <option value="<?= $p['ven_id']; ?>">
                                                    <?= $p['vendor_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                      <p class="error vendor_name_error"></p>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ticket_date">Date:<span class="required">*</span></label>
                                        <input type="text" class="form-control datepicker" id="ticket_date" name="ticket_date" value="<?= date('d-m-Y') ?>">
                                        <p class="error ticket_date_error"></p>
                                    </div>
                                </div> -->
                            </div>

                            <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vendor_po_name">Vendor PO Number <span class="required">*</span></label>
                                        <select class="form-control" id="vendor_po_name" name="vendor_po_name">
                                            <option value="">Select Vendor PO No</option>
                                            <?php foreach($vendorList as $p): ?>
                                                <option value="<?= $p['ven_id']; ?>">
                                                    <?= $p['vendor_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                      <p class="error vendor_po_name_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parts_no">FG.Part No<span class="required">*</span></label>
                                        <select class="form-control" id="parts_no" name="parts_no">
                                            <option value="">Select Part No</option>
                                            <?php foreach($parts_no_list as $p): ?>
                                                <option value="<?= $p['fin_id']; ?>">
                                                    <?= $p['part_number']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error parts_no_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fg_part_description">FG.Part Description<span class="required">*</span></label>
                                        <input type="text" class="form-control" id="fg_part_description" name="fg_part_description">
                                         <p class="error fg_part_description_error"></p>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="balance_qty">Balance Qty<span class="required">*</span></label>
                                        <input type="text" class="form-control" id="balance_qty" name="balance_qty">
                                         <p class="error balance_qty_error"></p>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                                        <p class="error remarks_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="box-footer">
                                <input type="submit" id="savenewTicket" class="btn btn-primary" value="Save" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>storeform'" class="btn btn-default" value="Back" />
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });
    });
</script>
