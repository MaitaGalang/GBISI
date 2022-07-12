                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-4"><b>CBB Code</b></div>
                                <div class="col-8"><?=$custdetails->cbb_code?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>AX Code</b></div>
                                <div class="col-8"><?=$custdetails->ax_code?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Name</b></div>
                                <div class="col-8"><?=$custdetails->name?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Search Name</b></div>
                                <div class="col-8"><?=$custdetails->search_name?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Address</b></div>
                                <div class="col-8"><?=$custdetails->address?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>TIN No</b></div>
                                <div class="col-8"><?=$custdetails->tin?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Store Type</b></div>
                                <div class="col-8">
                                        <?php
                                            foreach($strtyplist as $rsstrtyp){
                                                if($rsstrtyp->code==$custdetails->store_type){
                                                    echo $rsstrtyp->description;
                                                }
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Payment Terms</b></div>
                                <div class="col-8">
                                        <?php
                                            foreach($paytrmlist as $rspaytrmlist){
                                                if($rspaytrmlist->code==$custdetails->payment_terms){
                                                    echo $rspaytrmlist->description;
                                                }
                                            }
                                        ?>

                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-4"><b>Price Code</b></div>
                                <div class="col-8">
                                        <?php
                                            foreach($pmlist as $rspms){
                                                if($rspms->code==$custdetails->price_code){
                                                    echo $rspms->code." - ".$rspms->description;
                                                }
                                            }
                                        ?>
                                </div>
                            </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>