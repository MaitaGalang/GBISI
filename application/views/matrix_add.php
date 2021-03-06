
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        
                    </div>


                    <div class="card shadow mb-4">
                        <form action="<?=base_url("price_matrix/save")?>" method='post' name="frmaddpm" id="frmaddpm">
                            <div class="card-body">
                                <?php
                                    //rint_r($versions);

                                    $str = $versions;
                                    $result = explode(';',$str);

                                    $cnt = count($result);
                                ?>

                                <input type='hidden' id="hdnvers" name="hdnvers" value="<?php echo $str;?>" />
                                
                                <div class="row pb-1 pl-3">
                                    <div class="col-1 p-0">
                                        <b>Description: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <input type='text' class="form-control input-sm" id="txtcdescription" name="txtcdescription" value="" autocomplete="off" placeholder="Enter description or remarks..." />
                                    </div>
                                </div>
                                
                                <div class="row pb-1 pl-3">
                                
                                    <div class="col-1 p-0">
                                        <b>Effect Date: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <div class="col-8 p-0">
                                            <input type='text' class="form-control input-sm" id="date_delivery" name="date_delivery" placeholder="Pick Effect Date..." required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-3 pb-2 pl-3">
                                    <div class="col-8 p-0">
                                        
                                    

                                        <select data-placeholder="Choose Product" id="search_prod">
                                            <option></option>
                                            <?php
                                                foreach($itemslist as $rsitms){
                                            ?>
                                            <option value="<?=$rsitms->id?>" data-cbb="<?=$rsitms->cbb_code?>" data-ax="<?=$rsitms->ax_code?>" data-uom="<?=$rsitms->uom?>" data-desc="<?=$rsitms->description?>"><?=$rsitms->description?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>

                                    </div>

                                </div>

                                <table width="100%" border="0" class="table table-hover table-sm p-0" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50">&nbsp;</th>
                                            <th scope="col" width="120"><b>CBB Code</b></th>
                                            <th scope="col" width="120"><b>AX Code</b></th>
                                            <th scope="col"><b>Item Desc</b></th>
                                            <th scope="col" width="100"><b>UOM</b></th>
                                            
                                            <?php
                                                for($i=0; $i<=$cnt-1; $i++){
                                            ?>
                                            <th scope="col" width="95"><?php echo $result[$i]; ?></th>
                                            <?php
                                                }
                                            ?>
                                            <th scope="col" width="10">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="card-footer">
                                <button type="button" id="pmadd" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-save fa-sm text-white-50"></i> Save </a>
                            </div>

                        </form>
                    </div>

    <script src="<?php echo base_url("assets/template/vendor/select2/select2.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/template/vendor/moment/moment.min.js"); ?>"> </script>
	<script src="<?php echo base_url("assets/template/vendor/daterangepicker/daterangepicker.js"); ?>"> </script>
	<script src="<?php echo base_url("assets/template/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"> </script>
    <script src="<?php echo base_url("assets/template/js/jquery.numeric.js"); ?>"></script>

    <script type="text/javascript"> 

    $("#search_prod").select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: true,
      //closeOnSelect: !$(this).attr('multiple'),
     // tags: true,
    });

    var selid = "";
    $("#search_prod").on("change", function (e) { 
        var cnt = 0;
        selid = $(this).find(':selected').val();

       // alert(selid);
        //check if item already selected
        $("#myTable > tbody > tr").each(function(index) {	

            var varxitm = $(this).find("input[type='hidden'][name='txt_id']").val();
            if(varxitm==selid){
                cnt = cnt + 1;
            }

        });

        if((selid!="" && selid!=null) && cnt==0){

            var count = $('#myTable tr').length;
            var uomchk = "";
            

            var detz = "";
            var itmcbb = "<td><input type=\"hidden\" name=\"txt_id\" id=\"txt_id"+count+"\" value=\""+selid+"\" /> <input type=\"hidden\" name=\"txt_cbb\" id=\"txt_cbb"+count+"\" value=\""+$(this).find(':selected').data("cbb")+"\" />" + $(this).find(':selected').data("cbb") + "</td>";
            var itmax = "<td><input type=\"hidden\" name=\"txt_ax\" id=\"txt_ax"+count+"\" value=\""+$(this).find(':selected').data("ax")+"\" />" + $(this).find(':selected').data("ax") + "</td>";
            var cdesc = "<td><input type=\"hidden\" name=\"txt_desc\" id=\"txt_desc"+count+"\" value=\""+$(this).find(':selected').data("desc")+"\" />" + $(this).find(':selected').data("desc") + "</td>";
            var cunit = "<td><input type=\"hidden\" name=\"txt_uom\" id=\"txt_uom"+count+"\" value=\""+$(this).find(':selected').data("uom")+"\" />" + $(this).find(':selected').data("uom") + "</td>";
            var del = "<td><input type=\"button\" class=\"btn btn-xs btn-danger\" value=\"Delete\" id=\"btndel"+count+"\" name=\"btndel"+selid+"\" /></td>";
            
            var x = $('#hdnvers').val();
            var arrsplit =  x.split(";"); 
            
            var cnt = arrsplit.length;
            
            for(var i = 0; i < cnt; i++) {
                detz = detz + "<td> <input type=\"text\" class=\"numeric form-control input-xs\" name=\"" + arrsplit[i] + "\" id=\"" + arrsplit[i] + "\" required autocomplete=\"off\" /></td>";
            }
            
            $('#myTable > tbody:last-child').append('<tr>' + "<td>"+count+". </td>" + itmcbb + itmax + cdesc + cunit + detz + del + '</tr>');

            $("input.numeric").numeric({decimalPlaces: 4, negative: false});
				$("input.numeric").on("click", function () {
					$(this).select();
			});

            $("#btndel"+count).on('click', function() {
					$(this).closest('tr').remove();
				
					$('#myTable td:first-child').each(function(index){
					  //alert($(this).text() + " to " + index);
					  var indx = parseInt(index) + 1;
					  $(this).text(indx + ".");
					});

					$("#myTable > tbody > tr").each(function(index) {	
						var indx = parseInt(index) + 1;
						
						$(this).find("input[type='hidden'][name='txt_id']").attr("id", "txt_id"+indx);
						$(this).find("input[type='hidden'][name='txt_cbb']").attr("id", "txt_cbb"+indx);
                        $(this).find("input[type='hidden'][name='txt_ax']").attr("id", "txt_ax"+indx);
                        $(this).find("input[type='hidden'][name='txt_desc']").attr("id", "txt_desc"+indx);
                        $(this).find("input[type='hidden'][name='txt_uom']").attr("id", "txt_uom"+indx);
						$(this).find("button[name='btndel']").attr("id", "btndel"+indx);
						
					});
					
				});


           // $("#search_prod").val("").trigger("change");

        }

        $("#search_prod").val("");
        $('#search_prod').select2('destroy');
        $("#search_prod").select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
           // closeOnSelect: !$(this).attr('multiple'),
        });

        $('#search_prod').select2('open');

    });

    $('#search_prod').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
        });
    });


    $('#date_delivery').daterangepicker({
		autoApply: true,
		singleDatePicker: true,
        showDropdowns: true,
        minDate: new Date(),    
	});

    $("#pmadd").on("click", function (e) {
        var rowCount = $('#myTable tr').length

        if(rowCount==1){
            swal('Error', 'Transaction cannot be saved without details', 'error');
        }else{
            
            //check for numeric textboxes without value
            var valuenull = "";
            $("input.numeric").each(function() {
                if($(this).val()==""){
                    valuenull = "False";
                }
            });
            
            var valueduplicate = "";
            

            if(valuenull == "False"){
                swal('Error', 'Blank price is not allowed', 'error');
            }
            else{
                var x = $('#hdnvers').val();
                var arrsplit =  x.split(";");
                
                var cnt = arrsplit.length;
                var issaved = "";


                    var txtdeffect = $("#date_delivery").val();
                    var txtcdesc = $("#txtcdescription").val();
                    var transdz = "<?=date("YmdHis")?>";
                    var batchno = "PM<?=date("YmdHis")?>";
                    
                    for(var i = 0; i < cnt; i++) {				
                            //INSERTING HEADERS
                            $.ajax ({
                                url: "<?=base_url("price_matrix/savehdr")?>",
                                data: { deffect: txtdeffect, desc: txtcdesc, typ: arrsplit[i], batchno: batchno, tranno: arrsplit[i]+transdz },
                                async: false,
                                type: 'POST',
                                beforeSend: function(){

                                    swal({
                                        title: "SAVING PRICE MATRIX ("+arrsplit[i]+")",
                                        text: "Please don\'t Close this window",
                                        type: "warning",
                                        showConfirmButton : false,
                                    });

                                },
                                success: function( data ) {
                                    if(data.trim()!="False"){
                                        trancode = data.trim();
                            
                                        //INSERTING DETAILS
                                        var nident = 0;
                                        
                                        $("#myTable > tbody > tr").each(function() {	
                                        
                                            nident = nident + 1
                                        
                                            var valzid = $(this).find("input[type='hidden'][name='txt_id']").val();
                                            var valzcbb = $(this).find("input[type='hidden'][name='txt_cbb']").val();
                                            var valzax = $(this).find("input[type='hidden'][name='txt_ax']").val();
                                            var valzdsc = $(this).find("input[type='hidden'][name='txt_desc']").val();
                                            var valzuom = $(this).find("input[type='hidden'][name='txt_uom']").val();


                                            var valz = $(this).find("input[name='"+arrsplit[i]+"']").val();
                                            //alert("code:"+ txtcitm + "&uom:" + txtcuom);
                                            
                                                    $.ajax ({
                                                        url: "<?=base_url("price_matrix/savedtl")?>",
                                                        data: { refid: trancode, valzid: valzid, valzcbb: valzcbb, valzax: valzax, valzdsc: valzdsc, valzuom: valzuom, tranno: arrsplit[i]+transdz, price: valz },
                                                        async: false,
                                                        type: 'POST',
                                                        success: function( data ) {
                                                            //alert(data.trim());
                                                            if(data.trim()!="True"){
                                                                issaved = data.trim()+"\n";
                                                            }
                                                        }
                                                    });
                                            
                                        });


                                    }
                                }
                            });


                    }

            if(issaved==""){
                swal({
                    title: "Succesfully saved",
                    text: "Loading pm list...",
                    type: "success",
                    showConfirmButton : false,
                    });
                                                           
                setTimeout(function() {
                   
                    window.location.replace("<?=base_url()?>/price_matrix");

                }, 5000); // milliseconds = 5seconds
                

            }else{
                $("#AlertMsg").html(issaved);
            }
            
            }
                    
        }

    });

    </script>
