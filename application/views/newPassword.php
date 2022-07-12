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
							$attributes = array("name" => "createnewpassform");
							echo form_open("createPasswordUser", $attributes);
						?>

                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Reset Password!</h1>
                                    </div>

                                    <div class="form-group has-feedback">
                                      <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" readonly required />
                                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                      <input type="hidden" name="activation_code"  value="<?php echo $activation_code; ?>" required />
                                    </div>

                                    <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Enter New Password...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="cpassword" name="cpassword" placeholder="Confirm New Password...">
                                        </div>
                                       
                                        <button type='submit' class="btn btn-primary btn-user btn-block">
                                            Submit
                                        </button>
                                        


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