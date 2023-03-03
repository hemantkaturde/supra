<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Vendor Bill of Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View Vendor Bill of Material</a></li>
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
                            <h3 class="box-title">View Vendor Bill of Material Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewvendorbillofmaterialform" action="<?php echo base_url() ?>addnnewvendorbillofmaterialform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bom_number">BOM Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="bom_number" name="bom_number" value="<?=$getVendorbillofmaterialDetails['bom_number']?>" required readonly>
                                            <p class="error bom_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">BOM Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$getVendorbillofmaterialDetails['date']?>" id="date" name="date" required readonly>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control vendor_name" name="vendor_name" id="vendor_name" disabled>
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getVendorbillofmaterialDetails['vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <?php if($getVendorbillofmaterialitem[0]['pre_vendor_po_number']){
                                        $display='block';
                                        $selected_value = $getVendorbillofmaterialitem[0]['po_number'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select class="form-control vendor_po_for_item vendor_name_for_buyer_name" name="vendor_po_number" id="vendor_po_number" disabled>
                                                        <option st-id="" value="<?=$getVendorbillofmaterialitem[0]['pre_vendor_po_number']?>" selected><?=$selected_value;?></option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>



                                  <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name" disabled>
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$getVendorbillofmaterialDetails['buyer_name']){ echo 'selected';} ?>><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>


                                    <?php if($getVendorbillofmaterialitem[0]['pre_buyer_po_number']){
                                        $display_buyer='block';
                                        $selected_value_buyer = $getVendorbillofmaterialitem[0]['sales_order_number'];

                                    }else{
                                        $display_buyer='none';
                                        $selected_value_buyer = 'Select Buyer PO Number';
                                    } ?>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO <span class="required">*</span></label>
                                                    <select class="form-control buyer_po_number  buyer_po_number_for_itam_mapping" name="buyer_po_number" id="buyer_po_number" disabled>
                                                        <option st-id="" value="<?=$getVendorbillofmaterialitem[0]['pre_buyer_po_number']?>" selected><?=$selected_value_buyer?></option>
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_buyer_po_date']){
                                        $pre_buyer_po_date= $fetchALLpreVendorpoitemList[0]['pre_buyer_po_date'];
                                     }else{
                                        $pre_buyer_po_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_date">Buyer PO Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_po_date" value="<?=$pre_buyer_po_date?>" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>

                                    <?php if($fetchALLpreVendorpoitemList[0]['pre_buyer_delivery_date']){
                                        $pre_buyer_delivery_date= $fetchALLpreVendorpoitemList[0]['pre_buyer_delivery_date'];
                                     }else{
                                        $pre_buyer_delivery_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_delivery_date">Buyer Delivery Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_delivery_date" value="<?=$pre_buyer_delivery_date?>"  name="buyer_delivery_date" required readonly>
                                            <p class="error buyer_delivery_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="bom_status">Status <span class="required">*</span></label>
                                                <select class="form-control bom_status" name="bom_status" id="bom_status" disabled>
                                                    <option st-id="" value="">Select Status Name</option>
                                                    <option value="OPEN"  <?php if($getVendorbillofmaterialDetails['bom_status']=='OPEN'){ echo 'selected'; }  ?>>OPEN</option>
                                                    <option value="CLOSE" <?php if($getVendorbillofmaterialDetails['bom_status']=='CLOSE'){ echo 'selected'; }  ?>>CLOSE</option>
                                                </select>
                                            <p class="error bom_status_error"></p>
                                        </div>
                                    </div>

                                
        

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark"  value="<?=$getVendorbillofmaterialDetails['remark']?>" name="remark" readonly>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <!-- <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/> -->
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Buyer Order Qty</th>
                                                        <th>Vendor Order Qty</th>
                                                        <th>Balanced Qty</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($getVendorbillofmaterialitem as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['buyer_order_qty'];?></td>
                                                        <td><?php echo $value['vendor_order_qty'];?></td>
                                                        <td><?php echo $value['vendor_received_qty'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                       
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
                                    <?php if($fetchALLprejobworkitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <!-- <input type="submit" id="savenewvendorBillofmaterial" class="btn btn-primary" value="Submit"> -->
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>vendorbillofmaterial'" class="btn btn-default" value="Back" />
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

