
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        <?php
                            if (in_array("add", $access)){
                        ?>
                        <a href="<?=base_url("upload_csv")?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Re-Upload File</a>
                        <?php
                            }
                        ?>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Order Type</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Order Type</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach($soh as $rs_inv){
                                        ?>
                                        <tr>
                                            <td>
                                                <a data-toggle="modal" data-target="#largeModal" class="dynamod" href="<?=base_url("invoices/view_order/".$rs_inv->order_no);?>" alt="View Details" title="View Details">
                                                    <?=$rs_inv->order_no?>
                                                </a>
                                            </td>
                                            <td><?=$rs_inv->order_type;?></td>
                                            <td><?=$rs_inv->cust_code?></td>
                                            <td><?=$rs_inv->cust_name?></td>  
                                            <td><?=$rs_inv->remarks?></td>                                          
                                        </tr>
                                        <?php
                                            }
                                        ?>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

