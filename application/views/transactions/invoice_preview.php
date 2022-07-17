<html>
<head>
<style type="text/css">
body {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 10px;
	margin:0px;
}

table{
border-color:#000000;
border-collapse:collapse;
}

td {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}
td.small {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;

}
td.smaller {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 10px;

}
th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
	font-weight: bold;
}
.footerFont{
	font-size:75%;
	padding-left:40px;
	padding-bottom:13px;
}
</style>
<title>SI Printing</title>
<script src="<?php echo base_url("assets/template/vendor/jquery/jquery351.js") ?>"></script>
<script language="javascript">
function Print(){
	$("#frmprint").submit();
}
</script>
</head>

<body>
	<div style="background-color: yellow; overflow:hidden; padding: 5px">
		<div style="float:left;">&nbsp;&nbsp;<strong><font size="-1">SALES INVOICE</font></strong></div>
		<div style="float:right;">
			<input type="button" value="CONTINUE PRINTING" onClick="Print();" class="noPrint"/>
			<input type="button" value="CLOSE" onClick="window.close();" />
		</div>
	</div>


<?php
	$cnt=0;
	$myseries = intval($seriesstar);
	foreach($invhdr as $rshdr){
		$cnt++;

		//getcustomer details
		foreach($custlist as $rscu){
			if($rscu->id==$rshdr->customer_id){
				@$custnme = $rscu->name;
				@$custerms = $rscu->payment_terms;
				@$custin = $rscu->tin;
				@$custadd = $rscu->address;
				@$custvatable = $rscu->cstatus;
			}
		}
?>

<table border="0" align="center" cellpadding="0" style="height:10.5in; width:100%; table-layout:fixed <?php if($cnt>1){ ?>;page-break-before:always;<?php } ?>">
<tr>
	<td align="right" style="height:5px; padding-right:15px">&nbsp;</td>
</tr>
<tr>
	<td align="right" style="height:0.93in; padding-right:15px;" valign="bottom"><b><?=$myseries?></b><br><b><?=$rshdr->transaction_no?></b></td>
</tr>
<tr>
	<td valign="top" style="height:7.5in;">
    	<table width="100%" border="0" cellpadding="1" style="height:1in; table-layout:fixed">
          <tr>
            <td style="width:1.4in" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="width:1in" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="width:1.75in" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="width:2in" valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" style="padding-left:1in">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" style="padding-left:1in; padding-top:10px"><div style="overflow:hidden;"><?=@$custnme?></div></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="middle">&nbsp;&nbsp;<?=date("m/d/Y", strtotime($rshdr->invoice_date)) ?></td>
          </tr>
          <tr>
            <td colspan="3" rowspan="2" style="padding-left:0.72in; padding-top:4px" valign="top"><div style="height:0.37in; overflow:hidden;"><?=@$custadd?></div></td>
            <td valign="bottom" align="right">TIN:&nbsp;</td>
            <td valign="bottom">&nbsp;&nbsp;<?=@$custin?></td>
          </tr>
          <tr>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" style="padding-left:1.65in; padding-top:10px"><?=$rshdr->customer_cbb_code?></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="middle">&nbsp;&nbsp;<?=@$custerms?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding-left:1.65in"><?=$rshdr->order_no?></td>
            <td style="padding-left:0.55in"><?=$rshdr->invoice_date?></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-left:1.65in; width:2.5in">&nbsp;</td>
            <td style="padding-left:0.55in">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" style="height: 0.21in">&nbsp;</td>
          </tr>
        </table>

        <table width="100%" border="0" cellpadding="0" style="table-layout:fixed">
			<?php
			@$varGross = 0;
			@$varNonVat = 0;
			@$varNonVatAmt = 0;
			
				foreach($invdtl as $rsinvdtl){
					if($rsinvdtl->transaction_no==$rshdr->transaction_no){

						foreach($itmlist as $rsitm){
							if($rsitm->id==$rsinvdtl->items_id){
								@$itmdesc = $rsitm->description;
								@$itmvat = $rsitm->lnonvat;
							}
						}
				
			?>
							<tr>
								<td style="width:0.87in" class="smaller" align="right"><?php echo $rsinvdtl->quantity;?>&nbsp;&nbsp;</td>
								<td style="width:0.5in" nowrap class="smaller">&nbsp;<?php echo $rsinvdtl->uom;?></td>
								<td style="width:3.1in" nowrap class="smaller">
									<div style="width:2.95in; overflow:hidden;">
										<div style="width:0.65in; float:left">
										&nbsp;&nbsp;<?php echo $rsinvdtl->cbb_code;?> 
										</div>
										<div>
											&nbsp; <?php echo $rsinvdtl->description;?>
										</div>
									</div>

								</td>
								<td style="width:0.8in" align="right" class="smaller"><?php echo number_format($rsinvdtl->price,4);?>&nbsp;&nbsp;</td>
								<td style="width:0.8in" align="right" class="smaller">&nbsp;</td>
								<td align="right" class="smaller"><?php echo number_format($rsinvdtl->amount,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							</tr>
		  <?php 
						
						

						//@$varGross = floatval(@$varGross) + floatval($rsinvdtl->amount);
						
						if(@$itmvat == "f") {
							@$varNonVat = floatval(@$varNonVat) + floatval($rsinvdtl->amount);
							@$varGross = floatval(@$varGross) + floatval($rsinvdtl->amount);
						}else{
							@$varNonVatAmt = floatval(@$varNonVatAmt) + floatval($rsinvdtl->amount);
						}
				

					}
				}


				@$varLessVat = (floatval(@$varNonVat)/1.12)*0.12;
				@$varNetVat = (floatval(@$varGross)+floatval(@$varNonVatAmt))-floatval(@$varLessVat);
				@$varVatSales = floatval(@$varNonVat)-floatval(@$varLessVat);
				
			
			?>

				

          <tr>
            <td colspan="6">
            <table width="100%" border="0" cellpadding="0" style="table-layout:fixed">
              <tr>
                <td rowspan="3" style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">&nbsp;</td>
                <td style="" class="smaller" align="right" valign="bottom">&nbsp;</td>
              </tr>
              <tr>
                <td style="width:1in;" class="smaller">Total Sales</td>
                <td class="smaller" align="right" valign="bottom">
					<?php
					if(@$custvatable==""){
                        echo number_format(floatval(@$varGross)+floatval(@$varNonVatAmt),2);
                        
					}else{
                        echo "";
					}
                    ?>&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:1in;" class="smaller">Vatable Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">&nbsp;&nbsp;
					<?php
						if(@$custvatable==""){
							echo number_format(@$varNetVat,2);
							
						}else{
							echo "";
						}
                    ?>
                  	&nbsp;&nbsp;&nbsp;&nbsp;
               </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">VAT-Exempt Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">
					<?php
						if(@$custvatable=="VAT EXEMPT"){
							echo number_format(@$varGross,2);
							
						}elseif(floatval(@$varNonVatAmt) <> 0){
							echo number_format(@$varNonVatAmt,2);
						}else{
							echo "";
						}
                    ?>
                 	&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">Zero rated Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">
					<?php
						if(@$custvatable=="ZERO RATED"){
							echo number_format(@$varGross,2);
							
						}else{
							echo "";
						}
                    ?>

                  &nbsp;&nbsp;&nbsp;&nbsp;
               </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">VAT-12%</td>
                <td style="" class="smaller" align="right" valign="bottom">
					<?php
						if(@$custvatable=="" && floatval(@$varGross) <> 0){
							if(floatval(@$varLessVat) <> 0) {
                            	echo number_format(@$varLessVat,2);
							}else{
								echo "";
							}								
						}else{
							echo "";
						}
                    ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">Gross Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">
					<?php
						echo number_format(floatval(@$varGross)+floatval(@$varNonVatAmt),2);
					?>&nbsp;&nbsp;&nbsp;&nbsp;
					
				</td>
              </tr>
            </table>
           </td>
          </tr>
          
       
      </table>

    </td>
</tr>

<tr>
	<td align="right" valign="bottom" style="height:0.21in;">
		<?php
			echo number_format(floatval(@$varGross)+floatval(@$varNonVatAmt),2);
		?>
	&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td align="right" valign="bottom" style="height:0.2in">&nbsp;</td>
</tr>
<tr>
	<td align="right" valign="bottom" style="height:0.31in">
		<?php
			echo number_format(floatval(@$varGross)+floatval(@$varNonVatAmt),2);
		?>
	&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td style="padding-left:2.5in; padding-bottom:0.22in" valign="bottom"><?=$rshdr->transaction_no?></td>
</tr>
</table>

<?php

	$myseries++;

	}

?>

<form action="<?=base_url("invoices/print")?>" name="frmprint" id="frmprint" method="POST">
	<?php
		foreach($chkTranNo as $rschkTranNo){
			echo "<input type='hidden' name='chkTranNo[]' value='".$rschkTranNo."'>";
		}
	?>
	<input type="hidden" name="hdnsseries" id="hdnsseries" value="<?=$seriesstar?>">
</form>

</body>
</html>





