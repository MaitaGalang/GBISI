            <form action="<?=base_url("parameters/update/".$paramdetails->id);?>" method='post' name="frmadduser" id="frmadduser">
                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Update Parameter Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>Code</b></div>
                                <div class="col-8"><input name="code" id="code" class="form-control" type="text" placeholder="Enter Code..." required maxlength="50" readonly value="<?=$paramdetails->code?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Description</b></div>
                                <div class="col-8"><input name="description" id="description" class="form-control" type="text" placeholder="Enter Description..." required maxlength="255" value="<?=$paramdetails->description?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Type</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="type" id="type">
                                        <option value='CUSCLASS' <?php echo ($paramdetails->type=="STRTYP") ? "selected" : "" ?>>STORE TYPE</option>
                                        <option value='PAYTERM' <?php echo ($paramdetails->type=="PAYTERM") ? "selected" : "" ?>>PAYMENT TERM</option>
                                        <option value='ITMCLASS' <?php echo ($paramdetails->type=="ITMCLASS") ? "selected" : "" ?>>ITEM CLASSIFICATION</option>
                                        <option value='ITMUOM' <?php echo ($paramdetails->type=="ITMUOM") ? "selected" : "" ?>>ITEM UNIT OF MEASURE</option>
                                    </select>
                                </div>
                            </div>

                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</a>

                </div>
            </form>