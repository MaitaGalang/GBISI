
                    <!-- Page Heading -->
                    <div class="row mb-4">
                        <div class="col-6 pl-3">
                            <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        </div>
                        <div class="col-6 pr-3 d-flex justify-content-end">
                            <?php
                                if (in_array("add", $access)){
                            ?>
                            <a href="#" id="pmadd" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create New</a>
                            &nbsp;&nbsp;
                            <a href="#" id="pmaddcode" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Version </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>PM No.</th>
                                            <th>Effectivity Date</th>
                                            <th>Created Date</th>
                                            <th>Version</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>PM No.</th>
                                            <th>Effectivity Date</th>
                                            <th>Created Date</th>
                                            <th>Version</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach($pmlist as $rs_user){
                                        ?>
                                        <tr>
                                            <td><?=$rs_user->batch_no?></td>
                                            <td><?=$rs_user->effect_date?></td>
                                            <td><?=$rs_user->date_created?></td>
                                            <td><?=$rs_user->code_list?></td>
                                            <td align="center">

                                            
                                            <a href="<?=base_url("price_matrix/view/".$rs_user->batch_no);?>" class="btn btn-info btn-sm" alt="View Details" title="View Details">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                            

                                            <?php
                                                if (in_array("edit", $access)){
                                            ?>
                                            <a href="<?=base_url("price_matrix/edit/".$rs_user->batch_no);?>" class="btn btn-success btn-sm" alt="Edit Details" title="Edit Details">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <?php
                                                }
                                            ?>

                                            <?php
                                                if (in_array("delete", $access)){
                                            ?>
                                            <a href="Javascript:delete_data('<?php echo $rs_user->batch_no;?>');" class="btn btn-danger btn-sm deldata" alt="Delete" title="Delete">
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

    <form method="post" name="frmnew" id="frmnew" action="<?=base_url("price_matrix/add");?>">
	    <input type="hidden" name="hdnvers" id="hdnvers" value="">
    </form>

    <div class="modal fade" id="PMPickModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pick Price Matrix Codes</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="PicList">

                    <div class="col-xs-12 nopadding">
                        <div class="alert alert-danger nopadding" id="add_err"></div>        
                    </div>   

                        
                    <div class="row nopadwtop">  
                        
                                <div class="col-3 pl-2">
                                <b>Version Code</b> 
                                </div>
                                <div class="col-5 pl-1">
                                <b>Version Description</b>  
                                </div>
                                            
                    </div>   
                
                    <!-- BODY -->
                        <div style="height:15vh; display:inline" class="col-12 p-0 pre-scrollable" id="TblPickver">
                        </div> 

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="btnproceed">Proceed</a>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript"> 

    $("#add_err").hide();
    $("#pmadd").on("click", function(){

        $("#TblItemver").empty();

        $.ajax ({
				url: "<?=base_url();?>price_matrix/load",
				async: false,
				dataType: 'json',
				success: function( data ) {
                      console.log(data);
					  $.each(data,function(index,item){
						  
						  var divhead = "<div class=\"itmverdet row nopadwtop\">";
						  var divcode = "<div class=\"col-3 pl-2\">  <div class=\"form-check\"><input class=\"form-check-input\" name=\"chkpricever[]\" type=\"checkbox\" value=\""+item.code+ "\"><label class=\"form-check-label\" for=\"flexCheckDefault\">"+item.code+"</label></div> </div>";
						  var divdet = "<div class=\"col-5 pl-1\"> "+item.description+ "</div>";
						 
						  var divend = "</div>";
						  
						  $("#TblPickver").append(divhead + divcode + divdet + divend);
					  });
				}
			
			});

            $("#PMPickModal").modal('show');


    });

    $("#btnproceed").on("click", function() {
			var anyBoxesChecked = 0;
			var vlz = "";
						
			$("input[name='chkpricever[]']").each( function () {
				if ($(this).is(":checked")) {
					anyBoxesChecked = anyBoxesChecked + 1;
					
					if(anyBoxesChecked>1){
						vlz=vlz+";";
					}
					
					vlz=vlz+$(this).val();
				}			
			});
			
			if(anyBoxesChecked==0 || vlz==""){
				$("#add_err").html("<b>ERROR: </b> Please select atleast 1 before you proceed.");
				$("#add_err").show();
			}else{
				
				$("#hdnvers").val(vlz);
				$("#frmnew").submit();
			}

		});

function delete_data(id){
  sys_confirm('Delete','<?php echo $clang[$l='Delete Item?'] ?? $l;?>',id);
}

function action_callback(id){
 
      location.href = "<?php echo base_url();?>price_matrix/delete/"+id; 
      
}
</script>
