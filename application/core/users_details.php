                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                                <img class="mx-auto d-block img-account-profile rounded-circle mb-2" src="<?php echo ($userpic == '') ? base_url('assets/users_image/profile.png') : base_url('assets/users_image/'.$userpic); ?>" alt="">
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-6"><b>User ID</b></div>
                                <div class="col-6"><?=$userdetails->user_id?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-6"><b>Full Name</b></div>
                                <div class="col-6"><?=$userdetails->fullname?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-6"><b>Email Address</b></div>
                                <div class="col-6"><?=$userdetails->email?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-6"><b>Role</b></div>
                                <div class="col-6">
                                    <?php 
                                        $key = array_search($userdetails->role_id, array_column($roleslist, 'id'));
                                        print_r($roleslist[$key]->title);
                                    ?>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>