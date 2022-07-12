                <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">User Role Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                            <div class="row">
                                <div class="col-3"><b>Title</b></div>
                                <div class="col-8"><?=$roledetails->title?></div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-3"><b>Description</b></div>
                                <div class="col-8"><?=$roledetails->description?></div>
                            </div>

                            <hr>
                            <h6>Role Access</h6>
                            
                            <div id="role_access_acc">

                                <?php
                                    //print_r($nav_menu);
                                    $arr_main = array("","Admin Panel","Transactions","Reports");
                                    for ($x = 1; $x <= 3; $x++) {
                                ?>

                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse<?=$x?>">
                                                <?=$arr_main[$x]?>
                                            </a>
                                        </div>
                                        <div id="collapse<?=$x?>" class="collapse <?php echo ($x==1) ? 'show' : '' ?>" data-parent="#role_access_acc">
                                            <div class="card-body">
                                            <?php
                                                $checkstat = "";
                                                foreach($nav_menu_all as $rs){
                                                    if($rs->main==$x){
                                                        if($rs->sub_level=="f"){
                                                            echo $rs->title.'<br>';


                                                            $myarray=explode(",", $rs->roles);
                                                            foreach($myarray as $rs_access){

                                                                $json = json_decode($roledetails->roles);
                                                                foreach ($json as $item) {
                                                                   // echo $item->id." == ".$rs->id." : ".in_array($rs_access, $item->access);
                                                                    if ($item->id == $rs->id && in_array($rs_access, $item->access)) {
                                                                        $checkstat = "checked";
                                                                    }

                                                                    //echo " :".$checkstat."<br>";
                                                                }

                                                            ?>
                                                                <div class="form-check-inline pl-5">  
                                                                    <div class="custom-control custom-checkbox">  
                                                                        <input name="chk_access[]" type="checkbox" class="custom-control-input" id="<?="0:".$rs->id."_".$rs_access?>" value="<?="0:".$rs->id."_".$rs_access?>" <?=$checkstat?> disabled>  
                                                                        <label class="custom-control-label" for="<?="0:".$rs->id."_".$rs_access?>"><?=$rs_access?></label>  
                                                                    </div>  
                                                                </div>  
                                                            <?php
                                                                $checkstat = "";
                                                            }
                                                            echo "<br>";
                                                        }else{
                                                            echo "<br><b><u>".$rs->title.'</u></b><br>';

                                                            foreach($subnav_menu_all as $rssub){
                                                                if($rssub->main_id==$rs->id){
                                                                    echo $rssub->title.'<br>';

                                                                    $my_sub_array=explode(",", $rssub->roles);
                                                                    foreach($my_sub_array as $rs_sub_access){

                                                                        $json = json_decode($roledetails->roles);
                                                                        foreach ($json as $item) {
                                                                        // echo $item->id." == ".$rs->id." : ".in_array($rs_access, $item->access);
                                                                            if ($item->id == $rssub->id && in_array($rs_sub_access, $item->access)) {
                                                                                $checkstat = "checked";
                                                                            }
                                                                         }

                                                                    ?>
                                                                        <div class="form-check-inline pl-5">  
                                                                            <div class="custom-control custom-checkbox">  
                                                                                <input name="chk_access[]"  type="checkbox" class="custom-control-input" id="<?=$rs->id.":".$rssub->id."_".$rs_sub_access?>" value="<?=$rs->id.":".$rssub->id."_".$rs_sub_access?>" <?=$checkstat?> disabled>  
                                                                                <label class="custom-control-label" for="<?=$rs->id.":".$rssub->id."_".$rs_sub_access?>"><?=$rs_sub_access?></label>  
                                                                            </div>  
                                                                        </div> 
                                                                    <?php
                                                                        $checkstat = "";
                                                                    }
                                                                    echo "<br>";
                                                                }
                                                            }

                                                        }
                                                    }
                                                }
                                             ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                    }
                                ?>

                                
                            </div>

                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>