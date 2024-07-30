<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Supplier PO Confirmation
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View Supplier PO Confirmation</a></li>
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
                            <h3 class="box-title">View PO Confirmation Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewsupplierconfrimationpoform" action="<?php echo base_url() ?>addnnewsupplierconfrimationpoform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_number">PO Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="po_number" name="po_number" value="<?=$getSupplierpoconfirmationdetails['po_number']?>" required readonly>
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control"  value="<?=$getSupplierpoconfirmationdetails['date']?>" id="date" name="date" required readonly>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name <span class="required">*</span></label>
                                                <select class="form-control" name="supplier_name" id="supplier_name" readonly>
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>" <?php if($getSupplierpoconfirmationdetails['sup_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_supplier_name']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name" readonly>
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                       <option value="<?php echo $value['buyer_id']; ?>" <?php if($getSupplierpoconfirmationdetails['buyer_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12 buyer_po_number_div" style="display:<?=$display;?>">
                                            <div class="form-group">
                                                    <label for="buyer_po_number">Buyer PO Number <span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number" readonly>
                                                    <option st-id="" value="<?=$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_po_number']?>" selected ><?=$selected_value;?></option>
                                                        <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($getSupplierpoconfirmationdetails['buyer_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                    </select> 
                                                <p class="error buyer_po_number_error"></p>
                                            </div>
                                    </div>

                                
                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="po_confirmed">PO Confirmed<span class="required">*</span></label>
                                                <select class="form-control" name="po_confirmed" id="po_confirmed" readonly>
                                                    <option st-id="" value="">Select PO Confirmed</option>
                                                    <option st-id="" value="YES" <?php if($getSupplierpoconfirmationdetails['po_confirmed']=='YES'){ echo 'selected'; }  ?>>YES</option>
                                                    <option st-id="" value="NO" <?php if($getSupplierpoconfirmationdetails['po_confirmed']=='NO'){ echo 'selected'; }  ?>>NO</option>
                                                </select>
                                            <p class="error po_confirmed_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_date">Confirmed Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$getSupplierpoconfirmationdetails['confirmed_date'];?>" id="confirmed_date" name="confirmed_date" required readonly>
                                            <p class="error confirmed_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_with">Confirmed With <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="confirmed_with" value="<?=$getSupplierpoconfirmationdetails['confirmed_with'];?>" name="confirmed_with" readonly>
                                            <p class="error confirmed_with_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required readonly> <?=$getSupplierpoconfirmationdetails['remark'];?></textarea>
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
                                                        <th>Sent Qty</th>
                                                        <th>Short / Excess</th>
                                                        <th>Vendor  Qty</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLSupplierPOitemsforview as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['order_oty'];?></td>
                                                        <td><?php echo $value['sent_qty'];?></td>
                                                        <td><?php echo $value['short_excess'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <!-- <td><?php echo $value['unit'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td> -->
                                                      
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                </div>

                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                   
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>supplierpoconfirmation'" class="btn btn-default" value="Back" />
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

