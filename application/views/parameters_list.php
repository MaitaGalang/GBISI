
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        <?php
                            if (in_array("add", $access)){
                        ?>
                        <a data-toggle="modal" data-target="#largeModal" href="<?=base_url("parameters/add")?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dynamod"><i class="fas fa-cogs fa-sm text-white-50"></i> Create New</a>
                        <?php
                            }
                        ?>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach($paramlist as $rs_user){
                                        ?>
                                        <tr>
                                            <td><?=$rs_user->code?></td>
                                            <td><?=$rs_user->description?></td>
                                            <td><?=$rs_user->type?></td>
                                            <td align="center">
                                                <!--
                                            <a data-toggle="modal" data-target="#largeModal" href="<?//=base_url("parameters/view/".$rs_user->id);?>" class="btn btn-info btn-sm dynamod" alt="View Details" title="View Details">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                            -->

                                            <?php
                                                if (in_array("edit", $access)){
                                            ?>
                                            <a data-toggle="modal" data-target="#largeModal" href="<?=base_url("parameters/edit/".$rs_user->id);?>" class="btn btn-success btn-sm dynamod" alt="Edit Details" title="Edit Details">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <?php
                                                }
                                            ?>

                                            <?php
                                                if (in_array("delete", $access)){
                                            ?>
                                            <a href="Javascript:delete_data('<?php echo $rs_user->id;?>');" class="btn btn-danger btn-sm deldata" alt="Delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
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
  sys_confirm('Delete','<?php echo $clang[$l='Delete Parameter?'] ?? $l;?>',id);
}

function action_callback(id){
 
      location.href = "<?php echo base_url();?>parameters/delete/"+id; 
      
}
</script>
