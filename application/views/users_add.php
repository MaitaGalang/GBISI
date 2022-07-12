            <form action="<?=base_url("users/save");?>" method='post' name="frmadduser" id="frmadduser">
                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Add New User <span class="text-success"><sup><i>*default password for new user is <b>Password</b></i></sup></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>User ID</b></div>
                                <div class="col-8"><input name="user_id" id="user_id" class="form-control" type="text" placeholder="Enter User ID..." required maxlength="50"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Full Name</b></div>
                                <div class="col-8"><input name="fullname" id="fullname" class="form-control" type="text" placeholder="Enter User Full Name..." required maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Email Address</b></div>
                                <div class="col-8"><input name="email" id="email" class="form-control" type="email" placeholder="Enter User Email Address..." required maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Role</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="role_id" id="role_id">
                                        <?php
                                            foreach($roleslist as $rs){
                                                echo "<option value='".$rs->id."'> ".$rs->title." </option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row pt-1">
                                <div class="col-4"><b>Password</b></div>
                                <div class="col-8"><input name="password" id="password" class="form-control" type="text" placeholder="Enter User Password..." required maxlength="255"></div>
                            </div>

                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</a>

                </div>
            </form>