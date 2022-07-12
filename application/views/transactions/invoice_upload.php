            <form action="<?=base_url("invoice_uploadcheck");?>" method="post" enctype="multipart/form-data" name="frmadditem" id="frmadditem">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">

                                <div class="row" style="padding-top: 5px">
                                    <div class="col-2">
                                        Attach File
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="file-loading">
                                                <input id="upload_csv" name="invfile" class="file" type="file"  data-browse-on-zone-click="true" data-allowed-file-extensions='["csv"]' required>
                                            </div>	
                                        </div>	

                                    </div>
                                </div>

                        </div>
                    </div>
                
            </form>
            
            