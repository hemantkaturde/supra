<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Print Packing Instructions Item Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Print Packing Instructions Item Details</a></li>
                </ul>
            </small>
        </h1>
    </section>
    <input type="text" class="form-control" id="packing_instract_main_item_id" value="<?=$getpackingdetails_itemdetails_by_packing_id[0]['id']; ?>" name="packing_instract_main_item_id" class="packing_instract_main_item_id">


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Print Packing Instructions Item Details</h3>
                            <p> </p>
                            <p><b>Part Number : </b> <?=$getpackingdetails_itemdetails_by_packing_id[0]['part_number']; ?></p>
                            <!-- <p><b>Buyer Name : </b> <?=$getpackingdetails_itemdetails_by_packing_id[0]['buyer_name_master']; ?></p>
                            <p><b>Buyer PO : </b> <?=$getpackingdetails_itemdetails_by_packing_id[0]['sales_order_number'].' - '.$packinginstarctiondetailsfordispaly[0]['buyer_po_number']?></p> -->
                           
                        </div>
                            
                                 <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Buyer Delivery Date </th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Buyer Invoice Number</th>
                                                    <th scope="col">Buyer Invoice Date</th>
                                                    <th scope="col">Buyer Invoice Qty </th>
                                                    <th scope="col">Box Qty</th>
                                                    <th scope="col">Remark</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $i=1;
                                            foreach ($getpackingdetails_itemdetails_by_packing_id as $key_details => $value_details) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$i++;?></th>
                                                        <td><?=$value_details['part_number'];?></td>
                                                        <td><?=$value_details['buyer_item_delivery_date'];?></td>
                                                        <td><?=$value_details['name'];?></td>
                                                        <td><?=$value_details['buyer_invoice_number'];?></td>
                                                        <td><?=$value_details['buyer_invoice_date'];?></td>
                                                        <td><?=$value_details['buyer_invoice_qty'];?></td>
                                                      
                                                        <td><?=$value_details['box_qty'];?></td>
                                                        <td><?=$value_details['remark'];?>
                                                    </td>
                                                        <td>
                                                            <i style='font-size: x-large;cursor: pointer;' main-id='<?=$main_id; ?>' fin_id='<?=$value_details['fin_id'];?>'  data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-files-o clonepackgingitemdetails' aria-hidden='true'></i>
                                                            <!-- <a href='<?=ADMIN_PATH.'admin/clonerecordspackinginstraction/'.$value_details['packing_instaction_details'];?>' ><i style='font-size: x-large;cursor: pointer;' class='fa fa-files-o' aria-hidden='true'></i></a> -->

                                                        </td>
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
                                </div>
                            
                    </div>
                </div>


                   <div class="col-md-12">
                                        <h2 style="color:red;font-weight:bold;">Print Records</h2>
                                        <table style="width:100%;border-collapse:collapse;border:2px solid red;" class="table">
                                            <thead>
                                                <tr style="background-color:red;color:white;text-align:center;">
                                                    <th style="border:1px solid red;">#</th>
                                                    <th style="border:1px solid red;">Part Number</th>
                                                    <th style="border:1px solid red;">Buyer Delivery Date</th>
                                                    <th style="border:1px solid red;">Description</th>
                                                    <th style="border:1px solid red;">Updated Description</th>
                                                    <th style="border:1px solid red;">Buyer Invoice Number</th>
                                                    <th style="border:1px solid red;">Buyer Invoice Date</th>
                                                    <th style="border:1px solid red;">Buyer Invoice Qty</th>
                                                    <th style="border:1px solid red;">Box Qty</th>
                                                    <th style="border:1px solid red;">Remark</th>
                                                    <th style="border:1px solid red;">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($getpackingdetails_itemdetails_clone as $value_details) {
                                            ?>
                                                <tr>
                                                    <td style="border:1px solid red;text-align:center;"><?= $i++; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['part_number']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_item_delivery_date']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['name']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['clone_desc']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_number']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_date']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_qty']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['box_qty']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['remark']; ?></td>
                                                    <td style="border:1px solid red;text-align:center;">
                                                      <!-- <i style='font-size: x-large;cursor: pointer'  main-id='<?=$main_id; ?>'   data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-pencil-square-o editpackinginstractionsubitem_clone'  aria-hidden='true'></i> -->
                                                      <i style='font-size: x-large;cursor: pointer;' main-id='<?=$main_id; ?>' fin_id='<?=$value_details['fin_id'];?>'  data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-trash-o deletepackinginstractionsubitem_clone' aria-hidden='true'></i>
                                

                                                      <i 
                                                        class="fa fa-edit editPackingcopyItem"
                                                        style="font-size:x-large; cursor:pointer;"
                                                        data-packing_clone_id="<?=$value_details['packing_instaction_details'];?>"
                                                        data-fin_id="<?=$value_details['fin_id'];?>"
                                                        data-part_number="<?=$value_details['part_number'];?>"
                                                        data-delivery_date="<?=$value_details['buyer_item_delivery_date'];?>"
                                                        data-description="<?=$value_details['name'];?>"
                                                        data-invoice_no="<?=$value_details['buyer_invoice_number'];?>"
                                                        data-invoice_date="<?=$value_details['buyer_invoice_date'];?>"
                                                        data-invoice_qty="<?=$value_details['buyer_invoice_qty'];?>"
                                                        data-box_qty="<?=$value_details['box_qty'];?>"
                                                        data-remark="<?=$value_details['remark'];?>"
                                                        data-clone_desc="<?=$value_details['clone_desc'];?>"
                                                        ></i>


                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>


                <!-- /.box -->
            </div>
        </div>
    </section>
</div>



<div class="modal fade"
     id="editPackingModal"
     tabindex="-1"
     data-backdrop="static"
     data-keyboard="false">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="editPackingForm" method="post" role="form">
        <div class="modal-header">
          <h5 class="modal-title">Edit Packing Item</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="fin_id" id="fin_id">
          <input type="hidden" name="packing_clone_id" id="packing_clone_id">

          <div class="row">
            <div class="col-md-6">
              <label>Part Number</label>
              <input type="text" class="form-control" id="part_number" name="part_number" readonly>
            </div>

            <div class="col-md-6">
              <label>Old Description</label>
              <input type="text" class="form-control" id="old_description" name="old_description" readonly>
            </div>

            <div class="col-md-6">
              <label>Description</label>
              <input type="text" class="form-control" id="description" name="description">
            </div>

            <div class="col-md-6 mt-2">
              <label>Delivery Date</label>
              <input type="date" class="form-control" id="delivery_date" name="delivery_date">
            </div>

            <div class="col-md-6 mt-2">
              <label>Buyer Invoice No</label>
              <input type="text" class="form-control" id="invoice_no" name="invoice_no">
            </div>

            <div class="col-md-6 mt-2">
              <label>Invoice Date</label>
              <input type="date" class="form-control" id="invoice_date" name="invoice_date">
            </div>

            <div class="col-md-6 mt-2">
              <label>Invoice Qty</label>
              <input type="text" class="form-control" id="invoice_qty" name="invoice_qty">
            </div>

            <div class="col-md-6 mt-2">
              <label>Box Qty</label>
              <input type="text" class="form-control" id="box_qty" name="box_qty">
            </div>

            <div class="col-md-12 mt-2">
              <label>Remark</label>
              <textarea class="form-control" id="remark" name="remark"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancel
          </button>
          <button type="submit" id="update_packing_instruction_clone_ids" class="btn btn-success update_packing_instruction_clone_ids">
            Update
          </button>
        </div>
      </form>

    </div>
  </div>
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
