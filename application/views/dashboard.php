<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Management panel
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-lg-3 col-xs-6">
       
         <div class="small-box bg-aqua">
            <div class="inner">
               <h3>
                  <?php if(isset($tasksCount)) { echo $tasksCount; } else { echo '0'; } ?>
               </h3>
               <p>Total Vendors</p>
            </div>
            <div class="icon">
               <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'etasks';} ?>"
               class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
      <div class="col-lg-3 col-xs-6">

         <div class="small-box bg-green">
            <div class="inner">
               <h3>
                  <?php if(isset($finishedTasksCount)) { echo $finishedTasksCount; } else { echo '0'; } ?>
               </h3>
               <p>Total Supplier</p>
            </div>
            <div class="icon">
               <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'etasks';} ?>"
               class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
    
      <div class="col-lg-3 col-xs-6">
        
         <div class="small-box bg-yellow">
            <div class="inner">
               <h3>
                  <?php if(isset($usersCount)) { echo $usersCount; } else { echo '0'; } ?>
               </h3>
               <p>Total Finishgood / Row Material</p>
            </div>
            <div class="icon">
               <i class="ion ion-person"></i>
            </div>
            <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
     
      <div class="col-lg-3 col-xs-6">
         
         <div class="small-box bg-red">
            <div class="inner">
               <h3>
                  <?php if(isset($logsCount)) { echo $logsCount; } else { echo '0'; } ?>
               </h3>
               <p>Log</p>
            </div>
            <div class="icon">
               <i class="fa fa-archive"></i>
            </div>
            <a href="<?php echo base_url(); ?>log-history" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
   </div>
    

   <div class="row" style="margin-right: 0px; margin-left: 0px;background:#fff">
      <div class="col-lg-12 col-xs-12">        
         <div class="col-md-4">
            <div class="form-group">
               <h4> Search By Part Number</h4>
               <select class="form-control" name="part_number" id="part_number">
                  <option st-id="" value="NA">Select Part Number</option>
                  <?php foreach ($finishgoodList as $key => $value) {?>
                  <option value="<?php echo $value['fin_id']; ?>"><?php echo $value['part_number']; ?>
                  </option>
                  <?php } ?>
               </select>
            </div>
         </div>

         <div class="col-md-4">

            <div class="form-group">
               <h4> Search By Form</h4>
               <select class="form-control" name="form_type" id="form_type">
                  <option st-id="" value="NA">Select Form</option>
                  <option st-id="" value="NA">Buyer PO</option>
                  <option st-id="" value="NA">Supplier PO</option>
                  <option st-id="" value="NA">Vendor PO</option>
                  <option st-id="" value="NA">Supplier PO Confirmation</option>
                  <option st-id="" value="NA">Vendor PO Confirmation</option>
                  <option st-id="" value="NA">Job Work Challan</option>
                  <option st-id="" value="NA">OMS Challan</option>
                  <option st-id="" value="NA">Challan</option>
                  <option st-id="" value="NA">Rework / Rejection Challan</option>
                  <option st-id="" value="NA">Bill Of Material</option>
                  <option st-id="" value="NA">Vendor Bill Of Material</option>
                  <option st-id="" value="NA">Incomig Details</option>
                  <option st-id="" value="NA">Stock</option>
                  <option st-id="" value="NA">Rejection</option>
                  <option st-id="" value="NA">Quality Record</option>
                  <option st-id="" value="NA">Packaging Instrasction</option>
                  <option st-id="" value="NA">Export Details</option>
                  <option st-id="" value="NA">Sales Tracking</option>
                  <option st-id="" value="NA">Coustomer Complaint</option>
                  <option st-id="" value="NA">Supplier / Vendor Complaint</option>
               </select>
            </div>
         </div>
      </div>

      <div class="col-lg-12 col-xs-12">
         <div class="">
              <table width="100%" class="table table-striped table-bordered table-hover"
                id="seachbypartnumberreport">
                <thead>
                    <tr style="background-color:#3c8dbc !important;color:#fff">
                      <th>Part Number</th>
                      <th>PO Number</th>
                      <th>Form Name</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div>
          </div>
      </div>
</section>
</div>