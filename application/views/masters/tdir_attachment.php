<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Inspection Report Attachment
            <small>
                <!-- <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Tracking of Dimenstional Inspection Report</a></li>
                </ul> -->
            </small>
        </h1>
    </section>

    <section class="content">

    <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Attachment</a></li>
                </ul>
                   <h4>
                                <p><b>Inspection Report Number :</b> <?=$getTdirdata[0]['report_number'] ?></p>
                                <p><b>Vendor Name :</b> <?=$getTdirdata[0]['vendor_name_label'] ?></p>
                                <p><b>Vendor PO Number :</b> <?=$getTdirdata[0]['po_number'] ?></p>
                                <p><b>Part Number :</b> <?=$getTdirdata[0]['part_number_label'] ?></p>
                                <p><b>Vendor Order Qty :</b> <?=$getTdirdata[0]['vendor_order_qty'] ?></p>
                            </h4>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                     <a href="<?php echo base_url().'/tdir';?>" class="btn btn-primary">
                          <i class="fa fa-arrow-left"></i> Back
                        </a>
                <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Purchase' || $this->session->userdata('roleText')=='QC'){ ?>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>addTDIRattachment">
                        <i class="fa fa-plus"></i> Add TDIR Attachment</a> -->
                        <a href="#fileModal" class="btn btn-primary" data-toggle="modal">
                          <i class="fa fa-plus"></i> Add Inspection Report Attachment
                        </a>
                <?php } ?>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary"> 
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_tdir_attachedment">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>Attachment Name</th>
                                            <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">

                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    </section>
</div>


<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-labelledby="fileModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="fileModalLabel">Upload Inspection Report Attachment</h4>
      </div>

      <div class="modal-body">
        <form id="fileUploadForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="fileInput">Choose File <span class="required">*</span></label>
            <input type="file" class="form-control" id="fileInput" name="file" required>
          </div>
          <input type="hidden" class="form-control" id="tdirid" name="tdirid" value="<?=$tdir_id;?>">
        </form>
        <div id="uploadResponse" class="alert" style="display:none;"></div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" id="uploadBtn" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

