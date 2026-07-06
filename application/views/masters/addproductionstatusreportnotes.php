<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Production Status Notes
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Production Status Notes</a></li>
                </ul>
            </small>
        </h1>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Production Status Notes</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewdebitnoteform" action="<?php echo base_url() ?>addnewdebitnoteform" method="post" role="form">
                            <div class="box-body">
                               <div class="col-md-12">
                                    <div class="form-group">

                                      <input type="hidden" class="form-control" id="notes_id" value="<?php echo $vendor_bill_item_id;?>" name="notes_id">
                                      <input type="hidden" class="form-control" id="flag"  value="<?php echo $flag;?>" name="flag">


                                        <label for="notes">Notes </label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo $getpreviousnotesdataproductionstatusreport[0]['notes'] ?></textarea>
                                        <p class="error notes_error"></p>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="button" onclick="location.href = '<?php echo base_url() ?>productionstatusreport'" class="btn btn-default" value="Back" />
                                        <button type="button" id="savebillofmaterialnotes" class="btn btn-primary">Save Notes</button>
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

