<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Balance Stock Details
            <small>Add,Delete</small>
        </h1>
    </section>

    <?php //print_r($getpreviousbalancestock);exit; ?>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Stock</a></li>
                    <li class="active"><a href="javascript:void(0);">Balance Stock Details</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Purchase' || $this->session->userdata('roleText')=='Sales' ){ ?>
                       <button class="btn btn-primary" id="addBalanceBtn">
                            <i class="fa fa-plus"></i> Add Balance Stock Details
                       </button>
                    <?php } ?>
                </div>
            </div>
        </div>
             <div class="row">
            <div class="col-xs-6 text-left">
              <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                <h4><b>Vendor Name :</b> <?=$getpreviousbalancestock[0]['vendor_name_actual'] ?></h4>
                <h4><b>Vendor PO NUmber :</b> <?=$getpreviousbalancestock[0]['po_number_actual'] ?></h4>
                <h4><b>F.G Part Number :</b> <?=$getpreviousbalancestock[0]['part_number_actual'] ?></h4>
                <h4><b>F.G Part Description :</b> <?=$getpreviousbalancestock[0]['part_description'] ?></h4>
                <h4><b>Balance Qty :</b> <?=$getpreviousbalancestock[0]['balance_stock'] ?></h4>
                <h4><b>Created Date :</b> <?=$getpreviousbalancestock[0]['date_actual'] ?></h4>

                   <input type="hidden" name="balance_stock_id" id="balance_stock_id" Value="<?=$getpreviousbalancestock[0]['balance_stock_id'] ?>">
              </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_balance_stock_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>No of Boxes (in pcs)</th>
                                        <th>Qty Per Box (in pcs)</th>
                                        <th>Gross Weight Per Box (in kgs)</th>
                                        <th>Total Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>



<!-- BALANCE STOCK POPUP MODAL -->
<div class="modal fade" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="balanceModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form id="balanceForm">

        <div class="modal-header" style="background:#3c8dbc;color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
          <h4 class="modal-title" id="balanceModalLabel">Add / Edit Balance Stock Details</h4>
        </div>

        <div class="modal-body">

          <!-- Hidden IDs -->
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="main_balance_stock_id" id="main_balance_stock_id2">

          <div class="row">
            
            <div class="col-md-6">
              <div class="form-group">
                <label>No. of Boxes (pcs)</label>
                <input type="number" min="1" class="form-control" name="no_of_boxes_in_pcs" id="no_of_boxes_in_pcs" placeholder="Enter number of boxes">
                <small class="text-danger no_of_boxes_in_pcs_error"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Qty Per Box (pcs)</label>
                <input type="number" min="1" class="form-control" name="qty_per_box_in_pcs" id="qty_per_box_in_pcs" placeholder="Enter qty per box">
                <small class="text-danger qty_per_box_in_pcs_error"></small>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label>Gross Weight Per Box (kgs)</label>
                <input type="text" class="form-control" name="gross_weight_per_box_in_kgs" id="gross_weight_per_box_in_kgs" placeholder="Ex: 15.600">
                <small class="text-danger gross_weight_per_box_in_kgs_error"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Remark</label>
                <textarea class="form-control" name="remark" id="remark" placeholder="Remark"></textarea>
                <small class="text-danger remark_error"></small>
              </div>
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" id="saveBalanceBtn" class="btn btn-success">
            <i class="fa fa-check"></i> Save
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
          </button>
        </div>

      </form>

    </div>
  </div>
</div>




<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>