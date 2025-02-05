<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$team_id = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
        $password = $uf->password;
        $team_id = $uf->team_id;
    }
}


?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-users"></i> User
Management
                <small>Add/ 
Edit</small>
            </h1>
        </section>

        <section class="content">

            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->



                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Enter your user information</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->

                        <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Name surname</label>
                                            <input type="text" class="form-control" id="fname" placeholder="Full Name" name="fname" value="<?php echo $name; ?>" maxlength="128">
                                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>"
                                                maxlength="128">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <input id="show_password" type="checkbox" />Show password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cpassword">Password verify</label>
                                            <input type="password" class="form-control" id="cpassword" placeholder="Passwordniz
i verify
" name="cpassword" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Phone number</label>
                                            <input type="text" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" value="<?php echo $mobile; ?>"
                                                maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Authority</label>
                                            <select class="form-control" id="role" name="role">
                                                <option value="0">Please select Authority</option>
                                                <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>>
                                                        <?php echo $rl->role ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                
                            <div class="row" id="row_team" style="display:none">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Team</label>
                                    <div>
                                    <select class="form-control required"  style="color:black !important" id="team" name="team">
                                        <option value="0">Please select Team</option>
                                        <?php
                                        if(!empty($team))
                                        {
                                            foreach ($team as $key => $teammaster)
                                            {
                                                ?>
                                            <option value="<?php echo $teammaster['id']  ?>"  <?php if($teammaster['id'] == $team_id) {echo "selected=selected";} ?>>
                                                <?php echo $teammaster['team_name'] ?>
                                            </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Submit" />
                                <input type="reset" class="btn btn-default" value="Reset" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                        <?php } ?>
                        <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                            </div>
                        </div>
                </div>
            </div>
        </section>
    </div>

    <!-- <script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

$(document).ready(function(){

$('#show_password').change(function(){

  if($(this).is(':checked'))
    {
      
        $('#password').attr('type','text');
      
      }
  else
    {
        $('#password').attr('type','password');
      }
  

});

});
</script>