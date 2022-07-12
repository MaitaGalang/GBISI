
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        
                    </div>


                    <div class="card shadow mb-4">
                        <form action="<?=base_url("invoices/save")?>" method='post' name="frmaddpm" id="frmaddpm">
                            <div class="card-body">

                                <div class="row pb-1 pl-3">
                                    <div class="col-1 p-0">
                                        <b>Customer: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <select data-placeholder="Choose Customer" name="selcust" id="selcust">
                                            <option></option>
                                            <?php
                                                foreach($cust as $rsitms){
                                            ?>
                                            <option value="<?=$rsitms->id?>" data-id="<?=$rsitms->id?>" data-cbb="<?=$rsitms->cbb_code?>" data-ax="<?=$rsitms->ax_code?>" data-pm="<?=$rsitms->price_code?>" ><?=$rsitms->name?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
                                    <div class="col-1 pl-2">
                                        <b>Invoice Date: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <div class="col-8 p-0">
                                            <input type='text' class="form-control input-sm" id="date_delivery" name="date_delivery" placeholder="Pick Effect Date..." required />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row pb-1 pl-3">
                                    <div class="col-1 p-0">
                                        <b>Remarks: </b>
                                    </div>
                                    <div class="col-11 p-0">
                                        <input type='text' class="form-control input-sm" id="txtcdescription" name="txtcdescription" value="" autocomplete="off" placeholder="Enter description or remarks..." />
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
                                            <th scope="col"><b>Item Desc</b></th>
                                            <th scope="col" width="100"><b>UOM</b></th>
                                            <th scope="col" width="100"><b>Qty</b></th>
                                            <th scope="col" width="150"><b>Price</b></th>
                                            <th scope="col" width="150"><b>Amount</b></th>
                                            <th scope="col" width="10">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="card-footer">
                                

                                <div class="row">
                                    <div class="col-2"> 

                                        <button type="button" id="pmadd" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-save fa-sm text-white-50"></i> Save </a> </button>
                                    
                                    </div>

                                    <div class="col-8 text-right">
                                        <b>Total Gross: </b> 
                                    </div>

                                    <div class="col-2"> 
                                        <input type='text' class="form-control form-control-sm text-right" id="txtgross" name="txtgross" value="0" readonly />
                                    </div>
                                    
                                </div>



                            </div>

                        </form>
                    </div>

    <script src="<?php echo base_url("assets/template/vendor/select2/select2.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/template/vendor/moment/moment.min.js"); ?>"> </script>
	<script src="<?php echo base_url("assets/template/vendor/daterangepicker/daterangepicker.js"); ?>"> </script>
	<script src="<?php echo base_url("assets/template/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"> </script>
    <script src="<?php echo base_url("assets/template/js/jquery.numeric.js"); ?>"></script>

    <script type="text/javascript">  
    $("#selcust").select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: true,
      //closeOnSelect: !$(this).attr('multiple'),
     // tags: true,
    });

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
        if($("#selcust").val()==""){
            swal('Error', 'Please pick your customer!', 'error');

            $("#search_prod").val("");
            $('#search_prod').select2('destroy');
            $("#search_prod").select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: true,
            // closeOnSelect: !$(this).attr('multiple'),
            });

        }else{
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
                var itmcbb = "<td><input type=\"hidden\" name=\"txt_id\" id=\"txt_id"+count+"\" value=\""+selid+"\" /> <input type=\"hidden\" name=\"txt_ax\" id=\"txt_ax"+count+"\" value=\""+$(this).find(':selected').data("ax")+"\" /> <input type=\"hidden\" name=\"txt_cbb\" id=\"txt_cbb"+count+"\" value=\""+$(this).find(':selected').data("cbb")+"\" />" + $(this).find(':selected').data("cbb") + "</td>";
                var cdesc = "<td><input type=\"hidden\" name=\"txt_desc\" id=\"txt_desc"+count+"\" value=\""+$(this).find(':selected').data("desc")+"\" />" + $(this).find(':selected').data("desc") + "</td>";
                var cunit = "<td><input type=\"hidden\" name=\"txt_uom\" id=\"txt_uom"+count+"\" value=\""+$(this).find(':selected').data("uom")+"\" />" + $(this).find(':selected').data("uom") + "</td>";
                var qty = "<td> <input type=\"text\" class=\"numeric form-control form-control-sm text-right\" name=\"txt_qty\" id=\"txt_qty"+count+"\" data-id=\""+selid+"\" required autocomplete=\"off\" min=\"1\" /></td>";
                var price = "<td> <input type=\"text\" class=\"price form-control form-control-sm text-right\" name=\"txt_price\" id=\"txt_price"+count+"\" readonly value=\"0\" /></td>";
                var amt = "<td> <input type=\"text\" class=\"amt form-control form-control-sm text-right\" name=\"txt_amount\" id=\"txt_amount"+count+"\" readonly value=\"0\"  /></td>";
                var del = "<td><input type=\"button\" class=\"btn btn-sm btn-danger\" value=\"Delete\" id=\"btndel"+count+"\" name=\"btndel"+selid+"\" /></td>";
                
                $('#myTable > tbody:last-child').append('<tr>' + "<td>"+count+". </td>" + itmcbb + cdesc + cunit + qty + price + amt + del + '</tr>');

                $("input.numeric").numeric({decimalPlaces: 4, negative: false});
                $("input.numeric").on("click", function () {
                    $(this).select();
                });

                $("input.numeric").on("keyup", function () {
                    prce = get_price($(this).data("id"), $(this).val());
                    amt = parseFloat(prce)*parseFloat($(this).val());
                    
                    $(this).closest('tr').find('input.price').val(parseFloat(prce).toFixed(4));
                    $(this).closest('tr').find('input.amt').val(parseFloat(amt).toFixed(2));

                    getGross();
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
                            $(this).find("input[name='txt_qty']").attr("id", "txt_qty"+indx);
                            $(this).find("input[name='txt_price']").attr("id", "txt_price"+indx);
                            $(this).find("input[name='txt_amount']").attr("id", "txt_amount"+indx);
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

        }

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

    $('#date_delivery, #selcust').on("change", function(){

        //recompute price
        $("#myTable > tbody > tr").each(function() {	
                                                                           
            var valzid = $(this).find("input[name='txt_qty']");

            prce = get_price(valzid.data("id"), valzid.val());
            amt = parseFloat(prce)*parseFloat(valzid.val());

                
            $(this).find("input[name='txt_price']").val(parseFloat(prce).toFixed(4)); 
            $(this).find("input[name='txt_amount']").val(parseFloat(amt).toFixed(2)); 
        });
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
                swal('Error', 'Blank Qty is not allowed', 'error');
            }
            else{
                var issaved = "";
                var trancode = "";
                            //INSERTING HEADER
                            $.ajax ({
                                url: "<?=base_url("invoices/savehdr")?>",
                                data: { custid: $("#selcust").find(':selected').data('id'), cbbcode: $("#selcust").find(':selected').data('cbb'), axcode: $("#selcust").find(':selected').data('ax'), date: $("#date_delivery").val(), remarks: $("#txtcdescription").val(), gross: $("#txtgross").val() },
                                async: false,
                                type: 'POST',
                                beforeSend: function(){

                                    swal({
                                        title: "SAVING INVOICE",
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
                                            var valzqty = $(this).find("input[name='txt_qty']").val();
                                            var valzprice = $(this).find("input[name='txt_price']").val();
                                            var valzamt = $(this).find("input[name='txt_amount']").val();
                                            
                                            $.ajax ({
                                                url: "<?=base_url("invoices/savedtl")?>",
                                                data: { refid: trancode, valzid: valzid, valzcbb: valzcbb, valzax: valzax, valzdsc: valzdsc, valzuom: valzuom, valzprice: valzprice, valzamt: valzamt, valzqty: valzqty },
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

            if(issaved==""){
                swal({
                    title: "Succesfully saved",
                    text: "Loading invoice list...",
                    type: "success",
                    showConfirmButton : false,
                    });
                                                           
                setTimeout(function() {
                   
                    window.location.replace("<?=base_url()?>/invoices");

                }, 5000); // milliseconds = 5seconds
                

            }else{
                $("#AlertMsg").html(issaved);
            }
            
            }
                    
        }

    });

    function get_price(itm, val){
        var xcz = "";
        $.ajax({    //create an ajax request to display.php
            url: "<?=base_url("check_price")?>",
            type: "POST",
            async: false,
            data: { itmcode: itm, deldate: $("#date_delivery").val(), pmcode: $("#selcust").find(':selected').data('pm') },             
            dataType: "text",   //expect html to be returned                
            success: function(data){    
                
                //alert(data);
                xcz = data; 
            }
        });

        return xcz;
    }

    function getGross(){
        var ngross = 0;
        $("#myTable > tbody > tr").each(function() {	
            var amtz = $(this).find("input[name='txt_amount']").val();

            ngross = parseFloat(ngross) + parseFloat(amtz);
        }); 

        $("#txtgross").val(ngross);
    }

    </script>
