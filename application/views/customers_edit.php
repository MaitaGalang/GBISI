            <form action="<?=base_url("customers/update/".$custdetails->id);?>" method='post' name="frmadditem" id="frmadditem">
                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Update Customer Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>CBB Code</b></div>
                                <div class="col-8"><input name="cbb_code" id="cbb_code" class="form-control" type="text" placeholder="Enter CBB Code..." required maxlength="50" value="<?=$custdetails->cbb_code?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>AX Code</b></div>
                                <div class="col-8"><input name="ax_code" id="ax_code" class="form-control"type="text" placeholder="Enter AX Code..." required maxlength="50" value="<?=$custdetails->ax_code?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Name</b></div>
                                <div class="col-8"><input name="name" id="name" class="form-control" type="text" placeholder="Enter Corporation Name..." required maxlength="255" value="<?=$custdetails->name?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Search Name</b></div>
                                <div class="col-8"><input name="search_name" id="search_name" class="form-control" type="text" placeholder="Enter Short Name..." required maxlength="255" value="<?=$custdetails->search_name?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Address</b></div>
                                <div class="col-8"><input name="address" id="address" class="form-control" type="text" placeholder="Enter Address..." required maxlength="255" value="<?=$custdetails->address?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>TIN No</b></div>
                                <div class="col-8"><input name="tin" id="address" class="form-control" type="text" placeholder="Enter Tin No..." maxlength="255" value="<?=$custdetails->tin?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Store Type</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="store_type" id="store_type">
                                        <?php
                                            foreach($strtyplist as $rsstrtyp){
                                                if($rsstrtyp->code==$custdetails->store_type){
                                                    @$itemdesc = "selected";
                                                }else{
                                                    @$itemdesc = "";
                                                }
                                        ?>
                                        <option value='<?=$rsstrtyp->code;?>' <?=@$itemdesc?>><?=$rsstrtyp->description;?></option>
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
                                                if($rspaytrmlist->code==$custdetails->payment_terms){
                                                    @$itemdesc = "selected";
                                                }else{
                                                    @$itemdesc = "";
                                                }
                                        ?>
                                        <option value='<?=$rspaytrmlist->code;?>' <?=@$itemdesc?>><?=$rspaytrmlist->description;?></option>
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
                                                if($rspms->code==$custdetails->price_code){
                                                    @$itemdesc = "selected";
                                                }else{
                                                    @$itemdesc = "";
                                                }
                                        ?>
                                        <option value='<?=$rspms->code;?>' <?=@$itemdesc?>><?=$rspms->code." - ".$rspms->description;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Business Type</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="cstatus" id="cstatus">
                                        <option value='NONE' <?php echo ($custdetails->cstatus=='NONE') ? "selected" : "" ?>>NONE</option>
                                        <option value='ZERO' <?php echo ($custdetails->cstatus=='ZERO') ? "selected" : "" ?>>ZERO RATED</option>
                                        <option value='VAT-EXEMPT' <?php echo ($custdetails->cstatus=='VAT-EXEMPT') ? "selected" : "" ?>>VAT-EXEMPT</option>                                       
                                    </select>
                                </div>
                            </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</a>

                </div>
            </form>