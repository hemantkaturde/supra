<style>
       
       
       .table-container {
        overflow-x: auto; /* Horizontal scroll if the table overflows */
        white-space: nowrap; /* Prevent text wrapping inside table cells */
       }
       
       table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }
    </style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Daily Production Summary
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body" style="font-size: initial !important;">                        
                            <div class="table-container">
                                <form id="dataForm">

                                    <input type="hidden" id="incoming_item_id" name="incoming_item_id" value="<?=$getteamdetailsforhrlyinsectionreport['0']['incoming_item_id'];?>">
                                    <input type="hidden" id="team_master_main_id" name="team_master_main_id" value="<?=$getteamdetailsforhrlyinsectionreport['0']['team_master_id'];?>">


                                    <table class="table-responsive" styl="max-width: 68%; display: block; overflow-x: auto; white-space: nowrap; width: 70%;">
                                        <tr>
                                            <td colspan="16">SUPRA QUALITY EXPORTS (I) PVT. LTD </td>
                                        </tr>
                                        <tr>
                                            <td colspan="16">VISUAL INSPECTION RECORD SHEET  </td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['description'];?></td>
                                            <td>Part No.</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['part_number'];?></td>
                                            <td>Lot No.</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['lot_no'];?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="16"></td>
                                        </tr>
                                        <tr>
                                            <td>Vendor Name</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['vendor_name'].' - '.$getteamdetailsforhrlyinsectionreport['0']['v_po_number'];?></td>
                                            <td>Order QTY</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['p_o_qty'];?></td>
                                            <td>Rec QTY</td>
                                            <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['invoice_qty'];?></td>
                                        </tr>
                                        <tr>
                                            <td>HOD</td>
                                            <td colspan="5" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['HOD'].'-'.$getteamdetailsforhrlyinsectionreport['0']['team_name_for_report'];?></td>
                                            <td colspan="5" style="text-align: left;">Target Qty</td>
                                            <td colspan="4"  style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['target_qty'];?></td>
                                        
                                        </tr>
                                        <tr>
                                            <td rowspan="2">NAME</td>
                                            <td colspan="12">HOURLY INSPECTION REPORT</td>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td>9 to 10</td>
                                            <td>10 to 11</td>
                                            <td>11 to 12</td>
                                            <td>12 to 1</td>
                                            <td>1:30 to 2:30</td>
                                            <td>2:30 to 3:30</td>
                                            <td>3:30 to 4:30</td>
                                            <td>4:30 to 5:30</td>
                                            <td>5:30 to 6:30</td>
                                            <td>6:30 to 7</td>
                                            <td colspan="2">TOTAL HOURS</td>
                                            <td colspan="2">Sign</td>
                                        </tr>


                                        <?php  
                                        $comman_remark = '';
                                        foreach($getallteamdetailsusingteamid as $key => $value) { 

                                                
                                        $incoming_item_id =   $getteamdetailsforhrlyinsectionreport['0']['incoming_item_id'];
                                        $team_master_id =   $getteamdetailsforhrlyinsectionreport['0']['team_master_id'];
                                        $team_id  =   $value['id'];
                                        $date = date('Y-m-d');

                                        $this->load->model('admin_model');

                                        // Fetch data directly in the view
                                        $report_data = $this->admin_model->get_hourly_report($incoming_item_id,$team_master_id,$team_id,$date);                                     
                                        
                                            ?>
                                        <tr>
                                            <td><?=$value['team_member_name']?></td>
                                            <td> <input type="hidden" name="team_id[]" value="<?=$value['id']?>">  
                                                <input type="hidden" name="created_date" value="<?=$report_data[0]->date?>">
                                                <textarea id="textarea_9_10" name="textarea_9_10[]" data-index='<?=$key?>' class="form-control textarea_9_10"  rows="3" cols="1000"><?=$report_data[0]->textarea_9_10; ?></textarea>
                                            </td>
                                            
                                            <td><textarea id="textarea_10_11" name="textarea_10_11[]" class="form-control textarea_10_11"  data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_10_11; ?></textarea></td>
                                            <td><textarea id="textarea_11_12" name="textarea_11_12[]" class="form-control textarea_11_12" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_11_12; ?></textarea></td>
                                            <td><textarea id="textarea_12_01" name="textarea_12_01[]" class="form-control textarea_12_01" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_12_01; ?></textarea></td>
                                            <td><textarea id="textarea_01_230" name="textarea_01_230[]" class="form-control textarea_01_230" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_01_230; ?></textarea></td>
                                            <td><textarea id="textarea_230_330" name="textarea_230_330[]" class="form-control textarea_230_330" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_230_330; ?></textarea></td>
                                            <td><textarea id="textarea_330_430" name="textarea_330_430[]" class="form-control textarea_330_430" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_330_430; ?></textarea></td>
                                            <td><textarea id="textarea_430_530" name="textarea_430_530[]" class="form-control textarea_430_530" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_430_530; ?></textarea></td>
                                            <td><textarea id="textarea_530_630" name="textarea_530_630[]" class="form-control textarea_530_630" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_530_630; ?></textarea></td>
                                            <td><textarea id="textarea_630_700" name="textarea_630_700[]" class="form-control textarea_630_700" data-index='<?=$key?>' rows="3" cols="1000"><?=$report_data[0]->textarea_630_700; ?></textarea></td>
                                            <td colspan="2"><textarea id="textarea_total_hrs" name="textarea_total_hrs[] textarea_630_700" data-index='<?=$key?>' class="form-control"  rows="3" cols="1000"><?=$report_data[0]->textarea_total_hrs; ?></textarea></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <?php  $comman_remark = $report_data[0]->remark_of_hrly_report; } ?>

                                        <tr>
                                            <td colspan="15" style="text-align: left;">Remark</td>
                                        </tr>
                                        <tr>
                                            <td colspan="15">  
                                                <input type="text" class="form-control" id="remark_of_hrly_report" name="remark_of_hrly_report" placeholder="Enter Remark" value="<?=$comman_remark; ?>">
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="btn-group" role="group" aria-label="Basic example" style="float: inline-end;margin-top:10px;">
                                        <button type="button" id="update_data_hrly_inspection" class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-save"></i> Update Data</button>
                                        <button type="button" id="download_report_hrly_inspection" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Download Report</button>
                                    </div>

                                </form>

                               
                                <form id="second_data_from" style="margin-top:60px;">
                                    <input type="hidden" id="incoming_item_id" name="incoming_item_id" value="<?=$getteamdetailsforhrlyinsectionreport['0']['incoming_item_id'];?>">

                                    <table class="table-responsive" styl="max-width: 68%; display: block; overflow-x: auto; white-space: nowrap; width: 70%;">
                                        <tr>
                                            <td colspan="16">SUPRA QUALITY EXPORTS (I) PVT. LTD </td>
                                        </tr>
                                        <tr>
                                            <td colspan="16">SAMPLE RECORD TEST  </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>Instrument Name</td>
                                            <td>Measurement Size</td>
                                            <td>Type</td>
                                            <td>Remark</td>
                                            <td>Notes</td>
                                        </tr>


                                        <?php  
                                        $comman_remark = '';
                                        foreach($getallitemsamplingmethods as $key => $value) { 

        
                                        $incoming_item_id =   $getteamdetailsforhrlyinsectionreport['0']['incoming_item_id'];
                                        $sampling_method_id =   $value['sampling_method_id'];
                                        $sampling_trans_method_id  =   $value['sampling_trans_method_id'];

                                        $date = date('Y-m-d');

                                        $this->load->model('admin_model');

                                        // Fetch data directly in the view
                                        $sampling_data = $this->admin_model->get_sampling_data($incoming_item_id,$sampling_method_id,$sampling_trans_method_id,$date);    
                                                                         
                                        
                                            ?>
                                        <tr>
                                            <td><?=$value['instrument_name']?></td>
                                            <td>
                                                
                                                 <input type="hidden" name="sampling_method_id" id="sampling_method_id" value="<?=$sampling_method_id?>">
                                                 <input type="hidden" name="sampling_trans_method_id[]"  value="<?=$value['sampling_trans_method_id']?>">  
                                                 <input type="hidden" name="created_date" value="<?=$sampling_data[0]->created_date?>">
                                                 <?=$value['measuring_size']?>
                                            </td>
                                            
                                            <td><?=$value['type']?></td>
                                            <td><?=$value['remark']?></td>
                                            <td><textarea id="textarea_notes" name="textarea_notes[]" class="form-control textarea_notes" data-index='<?=$key?>' rows="3" cols="20"><?=$sampling_data[0]->textarea_notes; ?></textarea></td>
                                        </tr>
                                        <?php  $comman_remark_samplimg = $sampling_data[0]->remark_of_sampling_report; } ?>

                                        <tr>
                                            <td colspan="15" style="text-align: left;"> Sampling Qty  &nbsp&nbsp<input type="text"  id="sampling_qty" value="<?=$sampling_data[0]->sampling_qty; ?>" name="sampling_qty"></td>
                                        </tr>

                                        <tr>
                                            <td colspan="15" style="text-align: left;">Remark</td>
                                        </tr>
                                        <tr>
                                            <td colspan="15">  
                                               <input type="text" class="form-control" id="remark_of_sampling_report" name="remark_of_sampling_report" placeholder="Enter Remark" value="<?=$comman_remark_samplimg; ?>">
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="btn-group" role="group" aria-label="Basic example" style="float: inline-end;margin-top:10px;">
                                        <button type="button" id="update_data_hrly_sampling_record" class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-save"></i> Update Data</button>
                                        <button type="button" id="download_report_hrly_sampling_record" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Download Report</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>