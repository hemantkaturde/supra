<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Packing Instructions Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add Packing Instructions Details</a></li>
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
                            <h3 class="box-title">Add Packing Instructions Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addpackingdetailsform" action="<?php echo base_url() ?>addpackingdetailsform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Order Qty</th>
                                                    <th scope="col">Rate</th>
                                                    <th scope="col">Value</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $i=1;
                                            foreach ($getbuyeritemdetails as $key => $value) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$i;?></th>
                                                        <td><?=$value['part_number'];?></td>
                                                        <td><?=$value['description'];?></td>
                                                        <td><?=$value['order_oty'];?></td>
                                                        <td><?=$value['rate'];?></td>
                                                        <td><?=$value['value'];?></td>
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
                                </div>


                                <div class="col-md-8">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="part_number">Select Part Number<span class="required">*</span></label>
                                                <select class="form-control" name="part_number" id="part_number">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($getbuyeritemdetails as $key => $value) {?>
                                                                <option value="<?php echo $value['item_details']; ?>"><?php echo $value['part_number']; ?></option>
                                                        <?php } ?>
                                                </select> 
                                            <p class="error part_number_error"></p>
                                        </div>

                                        <input type="hidden" class="form-control" id="main_id" name="main_id" value="<?=$main_id?>" >

                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer Invoice Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_number" name="buyer_invoice_number" required>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>


                                        <div class="form-group">
                                            <label for="buyer_invoice_date">Buyer Invoice Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="buyer_invoice_date" name="buyer_invoice_date" required>
                                            <p class="error buyer_invoice_date_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="buyer_invoice_date">Buyer Invoice Qty <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_qty" name="buyer_invoice_qty" required>
                                            <p class="error buyer_invoice_date_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="box_qty">Box Qty <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="box_qty" name="box_qty" required>
                                            <p class="error box_qty"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="fax">Remark</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark"> </textarea><p class="error fax_error"></p>
                                        </div>

                                    </div>
                                </div>

                            </div>  
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                    <input type="submit" id="addpackinginstractiondetails" class="btn btn-primary" value="Submit" />
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>packinginstaruction'" class="btn btn-default" value="Back" />
                                </div>
                            </div>
                        </form>
                        <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Buyer Invoice Number</th>
                                                    <th scope="col">Buyer Invoice Date</th>
                                                    <th scope="col">Buyer Invoice Qty </th>
                                                    <th scope="col">Box Qty</th>
                                                    <th scope="col">Remark</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $i=1;
                                            foreach ($getpackingdetails_itemdetails as $key_details => $value_details) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$i;?></th>
                                                        <td><?=$value_details['part_number'];?></td>
                                                        <td><?=$value_details['name'];?></td>
                                                        <td><?=$value_details['buyer_invoice_number'];?></td>
                                                        <td><?=$value_details['buyer_invoice_date'];?></td>
                                                        <td><?=$value_details['buyer_invoice_qty'];?></td>
                                                        <td><?=$value_details['box_qty'];?></td>
                                                        <td><?=$value_details['remark'];?></td>
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
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
