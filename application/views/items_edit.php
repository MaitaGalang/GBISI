            <form action="<?=base_url("items/update/".$itemdetails->id);?>" method='post' name="frmadditem" id="frmadditem">
                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Update Item Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>CBB Code</b></div>
                                <div class="col-8"><input name="cbb_code" id="cbb_code" class="form-control" type="text" placeholder="Enter CBB Code..." required maxlength="50"  value="<?=$itemdetails->cbb_code?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>AX Code</b></div>
                                <div class="col-8"><input name="ax_code" id="ax_code" class="form-control" type="text" placeholder="Enter AX Code..." required maxlength="50"  value="<?=$itemdetails->ax_code?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Description</b></div>
                                <div class="col-8"><input name="description" id="description" class="form-control" type="text" placeholder="Enter Description..." required maxlength="255"  value="<?=$itemdetails->description?>"></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>UOM</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="uom" id="uom">
                                        <?php
                                            foreach($uomlist as $rsuom){
                                                if($itemdetails->uom==$rsuom->code){
                                                    @$itemdesc = "selected";
                                                }else{
                                                    @$itemdesc = "";
                                                }
                                                echo "<option value='".$rsuom->code."' ".@$itemdesc."> ".$rsuom->description." </option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Classification</b></div>
                                <div class="col-8">
                                    <select class="form-control" name="classification" id="classification">
                                        <?php
                                            foreach($classlist as $rsuom){
                                                if($itemdetails->classification==$rsuom->code){
                                                    @$itemdesc = "selected";
                                                }else{
                                                    @$itemdesc = "";
                                                }
                                                echo "<option value='".$rsuom->code."' ".@$itemdesc."> ".$rsuom->description." </option>";
                                            }
                                        ?>

                                        <?php
                                            foreach($classlist as $rsclass){
                                        ?>
                                        <option value='<?=$rsclass->code;?>'><?=$rsclass->description;?></option>
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