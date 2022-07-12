<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title." | ".$form_name;?></title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url("assets/template/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="<?php echo base_url("assets/template/vendor/bootstrap-file-input/css/bsicons.css?x=".time())?>" rel="stylesheet">

    <!--alerts CSS -->
    <link href="<?php echo base_url("assets/template/vendor/sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css">

    <!--Select2 CSS -->
    <link href="<?php echo base_url("assets/template/vendor/select2/select2.min.css?x=".time()) ?>" rel="stylesheet" type="text/css"> 
    <link href="<?php echo base_url("assets/template/vendor/select2/select2-bootstrap4.min.css") ?>" rel="stylesheet" type="text/css"> 

    <!--DateRange-->
    <link rel="stylesheet" href="<?php echo base_url("assets/template/vendor/daterangepicker/daterangepicker.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/template/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"); ?>">

    <link href="<?php echo base_url("assets/template/vendor/bootstrap-file-input/css/fileinput.css?x=".time()); ?>" rel="stylesheet">
	<link href="<?php echo base_url("assets/template/vendor/bootstrap-file-input/themes/explorer-fa5/theme.css?x=".time()); ?>" rel="stylesheet" media="all" type="text/css"/>

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url("assets/template/css/sb-admin-2.css?x=".time())?>" rel="stylesheet">

    <!-- DataTable -->
    <link href="<?php echo base_url("assets/template/vendor/datatables/dataTables.bootstrap4.min.css")?>" rel="stylesheet">

    <script src="<?php echo base_url("assets/template/vendor/jquery/jquery351.js") ?>"></script>

     

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">GBI Invoicing</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            
            <?php
                //print_r($nav_menu);
                $arr_main = array("","Admin Panel","Transactions","Reports");
                for ($x = 1; $x <= 3; $x++) {
            ?>

                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    <?=$arr_main[$x];?>
                </div>

                <?php
                    foreach($nav_menu as $rs){
                        if($rs->main==$x){
                            if($rs->sub_level=="f"){
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=base_url($rs->url);?>">
                                            <i class="<?=$rs->icon?>"></i>
                                            <span><?=$rs->title?></span>
                                        </a>
                                    </li>
                                <?php
                            }else{
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                                            aria-expanded="true" aria-controls="collapseTwo">
                                            <i class="<?=$rs->icon?>"></i>
                                            <span><?=$rs->title?></span>
                                        </a>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                            <div class="bg-white py-2 collapse-inner rounded">
                                                <?php
                                                    foreach($subnav_menu as $rssub){
                                                        if($rssub->main_id==$rs->id){
                                                ?>
                                                            <a class="collapse-item" href="<?=base_url($rssub->url);?>"><?=$rssub->title?></a>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </li>

                                <?php

                            }
                        }


                    }
                ?>
            <?php
                }
            ?> 
           
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    
                    <!-- Topbar Navbar -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <?=$mycompany;?>
                    </div>

                    <ul class="navbar-nav ml-auto">

                        

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$username?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#centerModal">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php include $loaded_page.'.php'; ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Goldilocks Bakeshop Inc. 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

     <!-- Container Modal-->
    <div class="modal fade" id="largeModal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content" id="load_modal_fields_large">
             
          </div>
          </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?=base_url("Logout")?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

   
<!-- Bootstrap core JavaScript-->
    
<script src="<?php echo base_url("assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url("assets/template/vendor/jquery-easing/jquery.easing.min.js") ?>"></script>

<!-- Sweet-Alert  -->
<script src="<?php echo base_url();?>assets/template/vendor/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url();?>assets/template/vendor/sweetalert/jquery.sweet-alert.custom.js"></script>

<script src="<?php echo base_url("assets/template/vendor/bootstrap-file-input/js/fileinput.js"); ?>"></script>
<script src="<?php echo base_url("assets/template/vendor/bootstrap-file-input/themes/fa5/theme.js"); ?>"></script>
<script src="<?php echo base_url("assets/template/vendor/bootstrap-file-input/themes/explorer-fa5/theme.js"); ?>"></script>

<!-- Accordion  -->
<script src="<?php echo base_url();?>assets/template/vendor/popper/popper.min.js"></script>



<script src="<?php echo base_url("assets/template/js/sb-admin-2.min.js") ?>"></script>

<!-- Page level plugins -->
<script src="<?php echo base_url("assets/template/vendor/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/template/vendor/datatables/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("assets/template/js/demo/datatables-demo.js") ?>"></script>
   

    <script>
        $(document).ready(function() {  

            $("body").on("click", ".dynamod", function(event){   
            //$(".load_modal_details").click(function(){    //before
                $("#load_modal_fields_large").html(" <span  class='text-nowrap'><img height='25' width='25' src='<?php echo base_url();?>assets/images/la.gif' /> LOADING... </span>");
                var href = $(this).attr('href');
                setTimeout(function() {
                $("#load_modal_fields_large").load(href, function(){
                //init_wysiwyg();
                //$('.textarea_editor').wysihtml5(); 
                }); 
                }, 1000);
            });

            <?php if(isset($_SESSION["error"])){?>swal('Error', '<?php echo $_SESSION["error"]?>', 'error');<?php }?>
            <?php if(isset($_SESSION["success"])){?>swal('Successful', '<?php echo $_SESSION["success"]?>', 'success');<?php }?>
           

            $("#upload_csv").fileinput();

        });


        function sys_confirm(t,d,id, tp = '',i = 'warning'){
         
         swal({   
             title: t,   
             text: d,   
             type: i,   
             showCancelButton: true,   
             confirmButtonColor: "#DD6B55",   
             confirmButtonText: "Continue",   
             closeOnConfirm: false 
         }, function(){   
             //swal("Done!", "", "success");  
                 action_callback(id, tp); 
                 swal.close();
             
         });
       } 
 
    </script>
</body>

</html>