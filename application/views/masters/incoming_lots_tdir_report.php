<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Tracking of Dimenstional Inspection Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Tracking of Dimenstional Inspection Report</a></li>
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
                            <h3 class="box-title">Add Tracking of Dimenstional Inspection Report</h3>

                              <h4>
                                  <p><b>Report Number :</b> <?=$getTdirdata[0]['report_number'] ?></p>
                                  <p><b>Vendor Name :</b> <?=$getTdirdata[0]['vendor_name_label'] ?></p>
                                  <p><b>Vendor PO Number :</b> <?=$getTdirdata[0]['po_number'] ?></p>
                                  <p><b>Part Number :</b> <?=$getTdirdata[0]['part_number_label'] ?></p>
                                  <p><b>Vendor Order Qty :</b> <?=$getTdirdata[0]['vendor_order_qty'] ?></p>
                              </h4>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addTDIRform" action="#" method="post" role="form">
                            <div class="box-body">


                                <div class="row">
                                 <div class="col-md-12">
                                   <h2>Incoming Lots</h2>

                                    <div class="lots-container">

                                    <?php  
                                    
                          
                                    foreach ($getincoinglotdetailsfortdir as $key => $value) { ?>
                                      
                                  
                                    
                                    <div class="lot-box">
                                        <h3>Lot 1</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> <?=$value['invoice_qty']  ?></p>
                                        <p><strong>Invoice Date:</strong> <?=$value['invoice_date']  ?></p>
                                        <p><strong>Material Grade:</strong> <?=$value['material_grade']  ?></p>
                                        <p><strong>Additional Process:</strong> <?=$value['additional_process']  ?></p>
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
                                    </div>

                                     <?php }  ?>


<!--                                    
                                    <div class="lot-box">
                                        <h3>Lot 2</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> --</p>
                                        <p><strong>Invoice Date:</strong> --</p>
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

                                   
                                    <!-- <div class="lot-box">
                                        <h3>Lot 3</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> --</p>
                                        <p><strong>Invoice Date:</strong> --</p>
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

                                    </div>

                                    </div>
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



 <style>


  h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .lots-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
  }

  .lot-box {
    flex: 1 1 300px;
    background: #fff;
    border: 2px solid #333;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
  }

  .lot-box h3 {
    margin-top: 0;
    font-size: 18px;
    text-align: center;
    background: #eee;
    padding: 8px;
    border-radius: 6px;
  }

  .lot-details p {
    margin: 6px 0;
    font-size: 14px;
  }

  .form-section {
    margin-top: 15px;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 6px;
  }

  .form-section label {
    display: block;
    font-size: 13px;
    margin: 5px 0 3px;
  }

  .form-section input[type="text"], 
  .form-section input[type="number"] {
    width: 100%;
    padding: 6px;
    border: 1px solid #aaa;
    border-radius: 4px;
  }

  .form-section input[type="checkbox"] {
    margin-right: 6px;
  }

  .btn {
    margin-top: 10px;
    padding: 8px 14px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn:hover {
    background: #0056b3;
  }
</style>