                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel"><?=$invhdr[0]->order_type?> Order Details (<?=$invhdr[0]->order_no?>)</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-2"><b>Customer</b></div>
                                <div class="col-10"><?=$invhdr[0]->cust_code." - ".$invhdr[0]->cust_name?></div>
                            </div>
                            <div class="row pt-1 pb-3">
                                <div class="col-2"><b>Delivery Date</b></div>
                                <div class="col-10"><?=$invhdr[0]->delivery_date?></div>
                            </div>
                                             
                            <div class="row">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">&nbsp; </th>
                                            <th class="text-center">Item Code</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">UOM</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnt = 0;
                                            foreach($invdtl as $rsinvdtl){
                                                $cnt++;
                                        ?>
                                        <tr>
                                            <td><?=$cnt?></td>
                                            <td><?=$rsinvdtl->item_code?></td>
                                            <td>
                                            <?php
                                                foreach($itmlist as $rsitm){
                                                    if($rsitm->cbb_code==$rsinvdtl->item_code){
                                                        echo $rsitm->description;
                                                    }
                                                }
                                            ?></td>
                                            <td><?=$rsinvdtl->uom?></td>
                                            <td align="center"><?=$rsinvdtl->qty?></td>
                                            <td><?=$rsinvdtl->remarks?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>                                      
                                    </tbody>
                                </table>
                            </div>


                           
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>