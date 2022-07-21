                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel"><?=$invhdr[0]->order_type?> Invoice Details (<?=$invhdr[0]->order_no?>)</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-2"><b>Customer</b></div>
                                <div class="col-10"><?=$invhdr[0]->customer_cbb_code?>
                                    <?php
                                        foreach($cuslist as $rscuslist){
                                            if($invhdr[0]->customer_cbb_code==$rscuslist->cbb_code){
                                                echo " - ".$rscuslist->name;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row pt-1 pb-3">
                                <div class="col-2"><b>Delivery Date</b></div>
                                <div class="col-10"><?=$invhdr[0]->invoice_date?></div>
                            </div>
                                             
                            <div class="row">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">&nbsp;</th>
                                            <th class="text-center">Item Code</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">UOM</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnt = 0;
                                            foreach($invdtl as $rsinvdtl){
                                                $cnt++;
                                        ?>
                                        <tr>
                                            <td><?=$cnt?>. </td>
                                            <td><?=$rsinvdtl->cbb_code?></td>
                                            <td><?=$rsinvdtl->description?></td>
                                            <td><?=$rsinvdtl->uom?></td>
                                            <td align="center"><?=$rsinvdtl->quantity?></td>
                                            <td align="right"><?=number_format($rsinvdtl->price,4)?></td>
                                            <td align="right"><?=number_format($rsinvdtl->amount,4)?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>                                       

                                        <tr>
                                            <td colspan="5" align="right"><b>TOTAL: </b></td>
                                            <td align="right"><b><?=number_format($invhdr[0]->gross,4);?></td>

                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>


                           
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>