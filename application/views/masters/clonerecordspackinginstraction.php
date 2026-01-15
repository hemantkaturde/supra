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
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_number']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_date']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['buyer_invoice_qty']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['box_qty']; ?></td>
                                                    <td style="border:1px solid red;"><?= $value_details['remark']; ?></td>
                                                    <td style="border:1px solid red;text-align:center;">
                                                      <i style='font-size: x-large;cursor: pointer'  main-id='<?=$main_id; ?>'   data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-pencil-square-o editpackinginstractionsubitem_clone'  aria-hidden='true'></i>
                                                      <i style='font-size: x-large;cursor: pointer;' main-id='<?=$main_id; ?>' fin_id='<?=$value_details['fin_id'];?>'  data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-trash-o deletepackinginstractionsubitem_clone' aria-hidden='true'></i>
                                
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
