
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Ref No.</th>
                                            <th>Order Type</th>
                                            <th>Series</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>Ref No.</th>
                                            <th>Order Type</th>
                                            <th>Series</th>
                                            <th>Customer CBB Code</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach($invlist as $rs_inv){
                                        ?>
                                        <tr>
                                            <td><?=$rs_inv->transaction_no?>
                                                <?php
                                                    if($rs_inv->is_active==2){
                                                        echo "<br><span class='text-danger'>Cancelled</span>";
                                                    }
                                                    if($rs_inv->lprinted=="t"){
                                                        echo "<br><span class='text-danger'>Printed</span>";
                                                    }
                                                ?>
                                            </td>
                                            <td><?=$rs_inv->order_type;?></td>
                                            <td><?=$rs_inv->invoice_series?></td>
                                            <td><?=$rs_inv->customer_cbb_code?></td>                                           
                                            <td>
                                                <?php 
                                                    foreach ($customers as $rscusto){
                                                        if($rscusto->id==$rs_inv->customer_id){
                                                            echo $rscusto->name;
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?=$rs_inv->invoice_date;?></td>
                                            <td align="center">

                                            
                                            <a data-toggle="modal" data-target="#largeModal" href="<?=base_url("invoices/view/".$rs_inv->transaction_no);?>" class="btn btn-info btn-sm dynamod" alt="View Details" title="View Details">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                            

                                            <?php
                                                if (in_array("edit", $access)){
                                            ?>
                                            <a href="<?=base_url("invoices/edit/".$rs_inv->id);?>" class="btn btn-success btn-sm <?=($rs_inv->is_active==2 || $rs_inv->lprinted=="t")? "disabled" : ""?>" alt="Edit Details" title="Edit Details">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <?php
                                                }
                                            ?>

                                            <?php
                                                if (in_array("cancel", $access)){
                                            ?>
                                            <a href="Javascript:delete_data('<?php echo $rs_inv->id;?>');" class="btn btn-danger btn-sm deldata <?=($rs_inv->is_active==2)? "disabled" : ""?>" alt="Cancel" title="Cancel">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            <?php
                                                }
                                            ?>
                                           

                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<script type="text/javascript"> 

function delete_data(id){
  sys_confirm('Cancel','<?php echo $clang[$l='Cancel Invoice?'] ?? $l;?>',id);
}

function action_callback(id){
 
      location.href = "<?php echo base_url();?>invoices/cancel/"+id; 
      
}
</script>
