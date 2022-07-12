
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $form_name;?></h1>
                        
                    </div>

          
                    <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php
                                    //rint_r($versions);

                                    $str = $versions;
                                    $result = implode(';',$str);

                                    $cnt = count($str);
                                ?>
                                
                                <div class="row pb-1 pl-3">
                                    <div class="col-1 p-0">
                                        <b>Description: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <?=$pmhdr[0]->remarks?>
                                    </div>
                                </div>
                                
                                <div class="row pb-3 pl-3">
                                
                                    <div class="col-1 p-0">
                                        <b>Effect Date: </b>
                                    </div>
                                    <div class="col-5 p-0">
                                        <div class="col-8 p-0">
                                            <?=$pmhdr[0]->effect_date?>
                                            
                                        </div>
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
                                                foreach($str as $strvals){
                                            ?>
                                                <th scope="col" width="95"><?php echo $strvals; ?></th>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $itm = $pmdtl[0]->id;

                                            $dtl_id = "";
                                            $dtl_id = "";
                                            $dtl_id = "";
                                            $dtl_id = "";
                                            $dtl_id = "";
                                            $dtl_id = "";
                                            $cnt = 0;
                                            foreach($pmdtlitms as $sdtls){
                                                $cnt++;
                                        ?>
                                        <tr>
                                            <td><?=$cnt?>.</td>
                                            <td>
                                               <?=$sdtls->cbb_code?>
                                            </td>
                                            <td>
                                                <?=$sdtls->ax_code?>
                                            </td>
                                            <td>
                                                <?=$sdtls->description?>
                                            </td>
                                            <td>
                                                <?=$sdtls->uom?>
                                            </td>
                                            
                                            <?php
                                                
                                                foreach($pmdtl as $rsdtlsval){
                                                    if($rsdtlsval->items_id == $sdtls->items_id){

                                                        foreach($pmhdr as $searchcode){
                                                            if($searchcode->id == $rsdtlsval->hdr_id){
                                                                @$pm_codes = $searchcode->pm_code;
                                                            }
                                                            
                                                        }
                                            ?>
                                                        <td align="right"> <?=$rsdtlsval->price?>
                                                           
                                                        </td>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                               
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>

                    </div>

    