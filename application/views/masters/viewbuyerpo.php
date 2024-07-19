<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Buyer PO
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View PO Master</a></li>
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
                            <h3 class="box-title">View Buyer PO Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewbuyerform" action="<?php echo base_url() ?>addnewbuyerform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sales_order_number">Sales Order Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="sales_order_number" name="sales_order_number" value="<?=$getbuyerpodetails[0]['sales_order_number']?>" required readonly>
                                            <p class="error sales_order_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$getbuyerpodetails[0]['date']?>" id="date" name="date" required readonly>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>

                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="buyer_po_number">Buyer PO Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_po_number" value="<?=$getbuyerpodetails[0]['buyer_po_number']?>" name="buyer_po_number" readonly>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>

                                 

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?=$getbuyerpodetails[0]['buyer_po_date']?>" id="buyer_po_date" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name" readonly>
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$getbuyerpodetails[0]['buyer_name_id']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="currency">Currency <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="currency"  value="<?=$getbuyerpodetails[0]['currency']?>" name="currency" readonly readonly>
                                            <p class="error currency_error"></p>
                                        </div>
                                    </div>

                       
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="order_quantity">Delivery Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"   value="<?=$getbuyerpodetails[0]['delivery_date']?>" i id="delivery_date" name="delivery_date" readonly>
                                            <p class="error delivery_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="generate_po">Generate PO <span class="required">*</span></label>
                                                 <select class="form-control" name="generate_po" id="generate_po" readonly>
                                                    <option value="">Select Generate PO </option>
                                                    <option value="YES" <?php if($getbuyerpodetails[0]['generate_po']=='YES'){ echo 'selected';} ?>>YES</option>
                                                    <option value="NO"  <?php if($getbuyerpodetails[0]['generate_po']=='NO'){ echo 'selected';} ?>>NO</option>
                                                 </select>
                                            <p class="error generate_po_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_status">PO Status<span class="required">*</span></label>
                                                 <select class="form-control" name="po_status" id="po_status" readonly>
                                                    <option value="">Select PO Status </option>
                                                    <option value="Open" <?php if($getbuyerpodetails[0]['po_status']=='Open'){ echo 'selected';} ?>>Open</option>
                                                    <option value="Close"  <?php if($getbuyerpodetails[0]['po_status']=='Close'){ echo 'selected';} ?>>Close</option>
                                                 </select>
                                            <p class="error pre_po_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required readonly> <?=$getbuyerpodetails[0]['remark'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Order Qty</th>
                                                        <th>Unit</th>
                                                        <th>Rate</th>
                                                        <th>Value</th>
                                                        <th>Buyer PO Delivery Date</th>
                                                        <th>Packaging Instruction</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['order_oty'];?></td>
                                                        <td><?php echo $value['unit'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td><?php echo $value['buyer_po_part_delivery_date'];?></td>
                                                        <td><?php echo $value['packaging_instraction'];?></td>
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
                                    <!-- <input type="submit" id="savenewbuyerpo" class="btn btn-primary" value="Submit" /> -->
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>buyerpo'" class="btn btn-default" value="Back" />
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
