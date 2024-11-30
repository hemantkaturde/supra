<style>
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


<?php

// print_r($getteamdetailsforhrlyinsectionreport['0']['part_number']);
// exit;

?>


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
                        <div class="panel-body">                        
                            <body>
                                <table>
                                    <tr>
                                        <td colspan="16">SUPRA QUALITY EXPORTS (I) PVT. LTD</td>
                                    </tr>
                                    <tr>
                                        <td colspan="16">VISUAL INSPECTION RECORD SHEET</td>
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
                                        <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['vendor_name'];?></td>
                                        <td>Order QTY</td>
                                        <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['invoice_qty'];?></td>
                                        <td>Rec QTY</td>
                                        <td colspan="4" style="text-align: left;"><?=$getteamdetailsforhrlyinsectionreport['0']['received_date'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td colspan="5" style="text-align: left;"></td>
                                        <td colspan="5">Target Qty</td>
                                        <td colspan="4"></td>
                                     
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
                                        <td>1 to 2:30</td>
                                        <td>2:30 to 3:30</td>
                                        <td>3:30 to 4:30</td>
                                        <td>4:30 to 5:30</td>
                                        <td>5:30 to 6:30</td>
                                        <td>6:30 to 7</td>
                                        <td colspan="2">TOTAL HOURS</td>
                                        <td colspan="2">Sign</td>
                                    </tr>
<!--                                   
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                    </tr> -->

                                    <?php  
                                    foreach($getallteamdetailsusingteamid as $key => $value) { ?>
                                     <tr>
                                        <td><?=$value['team_member_name']?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                     </tr>
                                    <?php  } ?>

                                    <tr>
                                        <td colspan="15" style="background:pink"></td>
                                    </tr>



                                    <tr>
                                        <td>Name</td>
                                        <td colspan="5">Method of Testing</td>
                                        <td colspan="3">Total Check QTY</td>
                                        <td colspan="3">Accepted QTY</td>
                                        <td colspan="2">Rej QTY</td>
                                        <td>Remarks</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">THREAD RING GUAGE WITH PIN</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">THREAD RING GUAGE WITH PIN</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">THREAD RING GUAGE</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">THREAD PLUG GUAGE WITH PIN</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">THREAD PLUG GUAGE </td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">PIN GUAGE</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">VERNER CALIPER</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">PROFILE GUAGE </td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">Slip Guage</td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="16" style="text-align: left;" >HOD ;-</td>
                                    </tr>
                                </table>
                            </body>
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