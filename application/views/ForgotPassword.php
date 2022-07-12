<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url("assets/template/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url("assets/template/css/sb-admin-2.css")?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <?php 
					$attributes = array("name" => "resetform");
					echo form_open("resetPassword", $attributes);
				?>

                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                    and we'll send you a link to reset your password!</p>
                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="login_email" name="login_email" placeholder="Enter Email Address..." required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Reset Password
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url("login"); ?>">Already have an account? Login!</a>
                            </div>

                            <?php
                                $this->load->helper('form');
                                $error = $this->session->flashdata('error');
                                $send = $this->session->flashdata('send');
                                $notsend = $this->session->flashdata('notsend');
                                $unable = $this->session->flashdata('unable');
                                $invalid = $this->session->flashdata('invalid');
                                
                                if($error)
                                {
                            ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $this->session->flashdata('error'); ?>                    
                                    </div>
                            <?php 
                                }

                                if($send)
                                {
                            ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $send; ?>                    
                                    </div>
                            <?php 
                                }

                                if($notsend)
                                {
                            ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $notsend; ?>                    
                                    </div>
                            <?php
                                }
                            
                                if($unable)
                                {
                            ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $unable; ?>                    
                                    </div>
                            <?php 
                                }

                                if($invalid)
                                {
                            ?>
                                    <div class="alert alert-warning alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $invalid; ?>                    
                                    </div>
                            <?php 
                                } 
                            ?>



                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>


                
            </div>
        </div>

    </div>

</div>

</div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url("assets/template/vendor/jquery/jquery.min.js") ?>"></script>
    <script src="<?php echo base_url("assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url("assets/template/vendor/jquery-easing/jquery.easing.min.js") ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url("assets/template/js/sb-admin-2.min.js") ?>"></script>

</body>

</html>