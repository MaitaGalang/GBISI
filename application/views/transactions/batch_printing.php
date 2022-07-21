					<?php
						foreach($users as $rs){
							$arrusrs[$rs->user_id] = $rs->fullname;
						}
					?>
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
								<table width="100%">
									<tr>
										<td width="15%" valign="top" class="pr-5">

											<fieldset>
												<legend> <strong>DATE RANGE</strong> </legend>
													<table width="100%" cellpadding="2" cellspacing="2">
													
														<tr>
															<td width="87%" align="left">
																<input class="form-control form-control-sm" name="ADate" type="text" id="ADate" value="<?=date("Y-m-d")?>"/>
															</td>
														</tr>

														<tr>
															<td width="87%" align="left">
																<select class="form-control form-control-sm" name="createdby" id="createdby">
																	<option value="">CREATED BY ALL USERS</option>
																	<?php
																		foreach($created as $rs){
																			echo "<option value='".$rs->created_by."'>".$arrusrs[$rs->created_by]."</option>";
																		}
																	?>
																</select>
															</td>
														</tr>
														
														<tr>
															<td height="10">&nbsp;</td>
														</tr>
														<tr>
															<td><input type="button" id="btnloadbatch" value="LOAD TRANSACTION" class="btn btn-sm btn-primary btn-block" /></td>
														</tr>
														<tr>
															<td>
																<input type="button" name="print" id="btnpreview" value="   PRINT PREVIEW  " class="btn btn-sm btn-success btn-block" />
															</td>
														</tr>
											
													</table>
											</fieldset>

											
										</td>
										<td width="77%" valign="top">
											<form action="<?=base_url("invoices/print_preview")?>" method="POST" name="frmPreview" id="frmPreview" target="_blank">
												<!--<input type="hidden" name="hdnsseries" id="hdnsseries" value="">-->
											<fieldset>
												<legend> <strong>TRANSACTIONS LIST</strong> </legend>
												
													<table class="table table-hover table-sm" id="TblList">
														<thead class="thead-light">
															<tr>
																<th width="4%"><input name="allbox" type="checkbox" value="Check All" onClick="checkAll(this.checked)"></th>
																<th width="11%" align="left">&nbsp;Ref No.</th>
																<!--<th width="8%" align="left">&nbsp;Series.</th>-->
																<th width="7%" align="left">&nbsp;Cust ID</th>
																<th width="50%" align="left">&nbsp;Customer Name</th>
																<th width="9%" align="left">&nbsp;Date</th>
																<th width="11%" align="left">&nbsp;Gross</th>
															</tr>
														</thead>
														<tbody>
															
														</tbody>									
													</table>
											</fieldset>
										</td>
									</tr>

								</table>
						</div>
					</div>

					<div class="modal fade" id="seriesModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">

								<div class="modal-header">
									<h5>Invoice Series</h5>
									<button class="close" type="button" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>

								<div class="modal-body">
									<input type="text" class="form-control form-control-sm" name="picseries" id="picseries" value="">
								</div>

								<div class="modal-footer">
									<h5><input type="button" id="btnproceed" value="PROCEED" class="btn btn-sm btn-primary btn-block" /></h5>
								</div>
							
							</div>
						</div>
					</div>

					<script src="<?php echo base_url("assets/template/vendor/moment/moment.min.js"); ?>"> </script>
					<script src="<?php echo base_url("assets/template/vendor/daterangepicker/daterangepicker.js"); ?>"> </script>
					<script src="<?php echo base_url("assets/template/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"> </script>

					<script>

						$('#ADate').daterangepicker({
							autoApply: true,
							showDropdowns: true   
						});

						$("#btnloadbatch").on("click", function(){
							$("#TblList tbody").empty();


							var $stdte = $('#ADate').data('daterangepicker').startDate.format('YYYY-MM-DD');
							var $endte = $('#ADate').data('daterangepicker').endDate.format('YYYY-MM-DD');

							$.ajax ({
                                url: "<?=base_url("invoices/load_batch_trans")?>",
                                data: { dfrom: $stdte, dteto: $endte, created: $("#createdby").val() },
                                async: false,
								dataType: 'json',
                                beforeSend: function(){

                                    swal({
                                        title: "Loading Transactions...",
                                        text: "Please don\'t Close this window",
                                        type: "warning",
                                        showConfirmButton : false,
                                    });

                                },
                                success: function( data ) {
									
									$.each(data,function(index,item){
										var nmgross = parseFloat(item.gross);
										
										var chkbox = "<td><input type=\"checkbox\" name=\"chkTranNo[]\" id=\"chkTranNo"+item.id+"\" value=\""+item.id+"\" /></td>";
										var ordno = "<td><a data-toggle=\"modal\" data-target=\"#largeModal\" class=\"dynamod\" href=\"<?=base_url("invoices/view/");?>"+item.transaction_no+"\" >"+item.transaction_no+"</a></td>";
										//var printno = "<td>" + item.invoice_series + "</td>";
										var custid = "<td>"+item.customer_cbb_code+"</td>";
										var custnme = "<td>"+item.name+"</td>";
										var ddate = "<td>"+item.invoice_date+"</td>";
										var gross = "<td align=\"right\">"+nmgross.toFixed(4).replace(/(\d)(?=(\d{3})+\.)/g, "1,").toString()+"</td>";

										$("#TblList tbody").append("<tr>" + chkbox + ordno + custid + custnme + ddate + gross + "</tr>");
									});
								},
								complete: function(data) {
									swal.close();
								}
								

							});
						});

						$("#btnpreview").on("click", function(){

							/*$.ajax ({
                                url: "<?//=base_url("get_last_series")?>",
                                data: { created: $("#createdby").val() },
                                async: false,
								dataType: 'text',
								success: function( data ) {

									$("#picseries").val(data);
									$("#seriesModal").modal("show");
								}
							});*/


							
							$("#frmPreview").submit();
						});

						$("#btnproceed").on("click", function(){
							
							var dser = $("#picseries").val();
							if( $('input[name="chkTranNo[]"]:checked').length > 0){

								$("#hdnsseries").val(dser);
								$("#frmPreview").submit();

							}else{
								swal({
                                        title: "Select Invoice to print...",
                                        text: "No Invoice is selected!",
                                        type: "warning",
                                        showConfirmButton : true,
                                    });
							}

						});
						

						function checkAll(isChecked) {
							if(isChecked) {
								$('input[name="chkTranNo[]"]').each(function() { 
									this.checked = true; 
								});
							} else {
								$('input[name="chkTranNo[]"]').each(function() {
									this.checked = false;
								});
							}
						}

					</script>


