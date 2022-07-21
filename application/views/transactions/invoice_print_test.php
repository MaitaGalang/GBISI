<html>
<head>
<style type="text/css">
body {
	font-family: Arial, Geneva, sans-serif;
	font-size: 10px;
	margin:0px;
}

table{
border-color:#000000;
border-collapse:collapse;
}

td {
	font-family: Arial, Geneva, sans-serif;
	font-size: 11px;
}
td.small {
	font-family: Arial, Geneva, sans-serif;
	font-size: 11px;

}
td.smaller {
	font-family: Arial, Geneva, sans-serif;
	font-size: 10px;

}
th {
	font-family: Arial, Geneva, sans-serif;
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
</head>

<body>
<?php

//echo "Hello";

@$dtlscount = 30;
@$arrhdrcnt[] = 0;

//ILAN PAGE PER INVOICE
 foreach($invhdr as $rshdr){

    $cntdtl=0;

	@$arrhdrcnt[$rshdr->id] = 0;    
	foreach($invdtl as $rs){
	  if($rs->transaction_no==$rshdr->transaction_no){
		$cntdtl++;
		$cntdtlall++;

		if($cntdtl==@$dtlscount){
			@$arrhdrcnt[$rshdr->id]++;
			$cntdtl = 0;
		}
	  }
	}

	if($cntdtl > 0 && $cntdtl < @$dtlscount){
		@$arrhdrcnt[$rshdr->id]++;
	}

  }




	$cnt=0;
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

	}
?>




</body>
</html>





