<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Admin | Supra Qulity Export India Pvt Ltd</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"
  />
  <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<!-- <body class="login-page" style="background-image: url('<?=base_url()?>/assets/images/login_background.jpg');background-size: 1550px 700px;background-repeat: no-repeat;margin-top: -25px;!important"> -->

<body class="login-page" style="background-size: 1550px 700px;background-repeat: no-repeat;margin-top: -25px;!important">

  <!-- <div class="login-box">
    <div class="login-logo" style="font-size: 25px; !important">
      <a href="#"><img src="<?=base_url().'/assets/images/db_logo.png';?>" alt="" style="height:150px;width:150px"></img> </a>
        <p style="font-size: inherit;font-weight: bolder;">Supra Quality Export India Pvt Ltd</p>
        <b>ERP SYSTEM</b>
    </div> -->
  
    <!-- /.login-logo -->
    <!-- <div class="login-box-body">
      <p class="login-box-msg">Login</p>
      <?php $this->load->helper('form'); ?>
      <div class="row">
        <div class="col-md-12">
          <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
      </div>
      <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $error; ?>
        </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $success; ?>
        </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>loginMe" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8"> -->
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>  -->
            <!-- </div> -->
            <!-- /.col -->
            <!-- <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" value="Login" />
            </div> -->
            <!-- /.col -->
          <!-- </div>
        </form> -->

        <!-- <a href="<?php echo base_url() ?>forgotPassword">Forgot Password</a> -->
        <!-- <br>

    </div> -->
    <!-- /.login-box-body -->
  <!-- </div> -->
  <!-- /.login-box -->
<!-- 
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html> -->



<div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1 fixed-height">
                    <div class="login-logo" style="font-size: 25px; !important">
                      <a href="#"><img src="<?=base_url().'/assets/images/db_logo.png';?>" alt="" style="height:150px;width:150px;    font-size: 25px; margin-top: -52px;"></img> </a>
                        <p style="font-size: inherit;font-weight: bolder;">Supra Quality Exports India Pvt Ltd</p>
                          <p style="text-align: justify;"><small style="font-weight: 400 !important;font-size: 74%;">A-92, Road No.16, Wagle Industrial Estate, Thane (W) 400604</small> </p>
                          <p style="text-align: justify;"><small style="font-weight: 400 !important;font-size: 74%;"><i class="fa fa-phone" aria-hidden="true"></i> +9122 66959505 / 66600196 / 62390222</small></p>
                          <p style="text-align: justify;"><small style="font-weight: 400 !important;font-size: 74%;"><i class="fa fa-phone" aria-hidden="true"></i> +9122 46061497 / 35115396</small></p>
                          <p style="text-align: justify;"><small style="font-weight: 400 !important;font-size: 74%;"><i class="fa fa-phone" aria-hidden="true"></i> +91 9152095890</small></p>
                    </div>
                </div>
                <div class="col-md-6 login-form-2 fixed-height">
                   
                  <div class="login-box" style="width: 500px;">
                  
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                      <!-- <b>ERP SYSTEM</b> -->
                      <p class="login-box-msg" style="font-size: 25px;"><b>ERP SYSTEM</b></p>
                      <?php $this->load->helper('form'); ?>
                      <div class="row">
                        <div class="col-md-12">
                          <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                      </div>
                      <?php
                        $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if($error)
                        {
                            ?>
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $error; ?>
                        </div>
                        <?php }
                        $success = $this->session->flashdata('success');
                        if($success)
                        {
                            ?>
                        <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $success; ?>
                        </div>
                        <?php } ?>

                        <form action="<?php echo base_url(); ?>loginMe" method="post">
                          <div class="form-group has-feedback">
                            <input type="email" class="form-control" placeholder="Email" name="email" required />
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                          </div>
                          <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Password" name="password" required />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                          <div class="row">
                            <div class="col-xs-8">
                              <!-- <div class="checkbox icheck">
                                <label>
                                  <input type="checkbox"> Remember Me
                                </label>
                              </div>  -->
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                              <input type="submit" class="btn btn-primary btn-block btn-flat" value="Login" />
                            </div>
                            <!-- /.col -->
                          </div>
                        </form>

                        <!-- <a href="<?php echo base_url() ?>forgotPassword">Forgot Password</a> -->
                        <br>

                    </div>
                    <!-- /.login-box-body -->
                  </div>
                </div>
            </div>
        </div>

        
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>

        <style>

.login-container{
    margin-top: 5%;
    margin-bottom: 5%;
    margin-top: 150px;!important
    align-items: center;
}
.login-form-1{
    padding: 5%;
    background:#ffff;

    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-1 h3{
    text-align: center;
    color: #333;
}
.login-form-2{
    /* padding: 5%; */
    background: #3c8dbc;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-2 h3{
    text-align: center;
    color: #fff;
}
.login-container form{
    padding: 10%;
}
.btnSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
.login-form-1 .btnSubmit{
    font-weight: 600;
    color: #fff;
    background-color: #0062cc;
}
.login-form-2 .btnSubmit{
    font-weight: 600;
    color: #0062cc;
    background-color: #fff;
}
.login-form-2 .ForgetPwd{
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}
.login-form-1 .ForgetPwd{
    color: #0062cc;
    font-weight: 600;
    text-decoration: none;
}



.fixed-height {
            height: 450px; /* Fixed height for both columns */
        }

        .login-form-1, .login-form-2 {
            display: flex;
            justify-content: center;
            /* align-items: center;
            background-color: #f7f7f7;
            border-radius: 8px; */
            /* padding: 20px; */
        }

        @media (max-width: 768px) {
            .fixed-height {
                height: auto; /* Remove fixed height on smaller screens */
                margin-bottom: 15px;
            }
        }

        </style>