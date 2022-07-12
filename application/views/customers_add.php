            <form action="<?=base_url("customers/save");?>" method='post' name="frmadditem" id="frmadditem">
                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>CBB Code</b></div>
                                <div class="col-8"><input name="cbb_code" id="cbb_code" class="form-control" type="text" placeholder="Enter CBB Code..." required maxlength="50"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>AX Code</b></div>
                                <div class="col-8"><input name="ax_code" id="ax_code" class="form-control" type="text" placeholder="Enter AX Code..." required maxlength="50"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Name</b></div>
                                <div class="col-8"><input name="name" id="name" class="form-control" type="text" placeholder="Enter Corporation Name..." required maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Search Name</b></div>
                                <div class="col-8"><input name="search_name" id="search_name" class="form-control" type="text" placeholder="Enter Short Name..." required maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Address</b></div>
                                <div class="col-8"><input name="address" id="address" class="form-control" type="text" placeholder="Enter Address..." required maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>TIN No</b></div>
                                <div class="col-8"><input name="tin" id="address" class="form-control" type="text" placeholder="Enter Tin No..." maxlength="255"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Store Type</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="store_type" id="store_type">
                                        <?php
                                            foreach($strtyplist as $rsstrtyp){
                                        ?>
                                        <option value='<?=$rsstrtyp->code;?>'><?=$rsstrtyp->description;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Payment Terms</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="payment_terms" id="payment_terms">
                                        <?php
                                            foreach($paytrmlist as $rspaytrmlist){
                                        ?>
                                        <option value='<?=$rspaytrmlist->code;?>'><?=$rspaytrmlist->description;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Price Code</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="price_code" id="price_code">
                                        <?php
                                            foreach($pmlist as $rspms){
                                        ?>
                                        <option value='<?=$rspms->code;?>'><?=$rspms->code." - ".$rspms->description;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</a>

                </div>
            </form>