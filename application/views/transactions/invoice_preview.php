<html>
<head>
<title>SI Printing</title>
</head>

<body>
<br />
<br />

<?php
	
?>
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" <% if not num = 1 then%>style="page-break-before:always;"<% end if %>>
<tr valign="top">
	<td width="45%">&nbsp;</td>
	<td width="51%">&nbsp;</td>
	<td width="4%" height="48" align="right">&nbsp;</td>
</tr>
<tr valign="top">
	<td height="36" align="right" colspan="3"><b><%=rs("cInvPrintNo")%><br /><%=rs("cInvNo")%></b><br /><br /><br /></td>
</tr>
<tr>
	<td height="104" colspan="3" valign="top">
    <table width="100%" cellpadding="14">
    <tr>
    	<td width="20%"><%=rs("cCode")%></td>
        <td width="20%"><%=rs("cTerm")%></td>
        <td width="21%">
        <%
				
		ObjConn.Source = "select cValue from dbo.PARAMETER_USER where cType = 'TERMS' and cCompanyID = '"&session("cCompanyID")&"' and cParamName = '" & rs("cTerm") & "'"
		ObjConn.Open()
			if ObjConn.eof then
				cVal = 0
			else
				cVal = ObjConn.Fields.Item("cValue").Value
			end if
		ObjConn.Close()
		
		dDate = DateAdd("d",cVal,rs("dDate"))
		response.Write(dDate)
		%>
        </td>
        <td width="19%"><%=rs("dDate")%></td>
        <td width="20%" align="right"><%=rs("dDate")%></td>
    </tr>
    <tr>
    	<td colspan="3"><%=rs("cName")%></td>
        <td colspan="2"><%=rs("cName")%></td>
    </tr>
    </table>
    </td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td valign="top" colspan="3">
    	<table cellpadding="2" cellspacing="2" width="100%">
        <%
		'set rsDRT = ObjConn.execute("select * from sales_t where cInvNo = '" & rs("cInvNo") & "' and cCompanyID = '" & session("cCompanyID") & "' and not nAmount = 0 order by nIdentity ASC")
		Set rsDRT = Server.CreateObject("ADODB.Recordset")
		rsDRT.ActiveConnection = MM_sqlconnect_STRING
		rsDRT.ActiveConnection.CommandTimeout = 0
		rsDRT.Source =  "select cItemNo,cDesc,cRefNo,nQty,cUnit,nPrice,nAmount from sales_t where cInvNo = '" & rs("cInvNo") & "' and cCompanyID = '" & session("cCompanyID") & "' and not nAmount = 0 order by nIdentity ASC"
		rsDRT.CursorType = 0
		rsDRT.CursorLocation = 2
		rsDRT.LockType = 1
		rsDRT.Open()
		
		dim ctr
		ctr = 0
		while not rsDRT.eof
		ctr = ctr + 1
		%>
        <tr valign="top">
        	<td width="10%"><%
			'set cPrintNo = ObjConn.execute("select cDRPrintNo from DR where cDRNo = '" & rsDRT("cRefNo") & "' and cCompanyID = '" & session("cCompanyID") & "'")
			
			ObjConn.Source = "select cDRPrintNo from DR where cDRNo = '" & rsDRT("cRefNo") & "' and cCompanyID = '" & session("cCompanyID") & "'"
			ObjConn.Open()
				if ObjConn.eof then
					response.Write("")
				else
					dim cPrintNo2
					cPrintNo2 = ObjConn.Fields.Item("cDRPrintNo").Value
					if ObjConn.Fields.Item("cDRPrintNo").Value = cPrintNo2 then
						response.Write(ObjConn.Fields.Item("cDRPrintNo").Value)
					else
					end if
				end if
			ObjConn.Close()
			
			'response.Write(rsDRT("cRefNo"))
			%></td>
        	<td width="9%"><%=rsDRT("cItemNo")%></td>
            <td width="36%">
            <%
			dim sample,k
			sample = rsDRT("cDesc")
			k = Left(sample, 30)
			if len(k) >=22 then
				response.Write(k)
			else
				response.Write(k)
			end if
			%>
            </td>
            <td width="9%" align="right"><%=formatnumber(rsDRT("nQty"),2)%>&nbsp;&nbsp;<%=rsDRT("cUnit")%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
         
             <td width="11%" align="right"><%=formatnumber(rsDRT("nPrice"),2)%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           
             <td width="13%" align="right"><%=formatnumber(rsDRT("nAmount"),2)%></td>
        </tr>
        <%
		
		rsDRT.movenext
		wend
		
		rsDRT.close()
		set rsDRT = nothing
		%>
        </table>
    </td>
</tr>
<tr>
      <td valign="bottom" colspan="3">&nbsp;</td>
</tr>
<tr>
      <td valign="bottom" colspan="3">
      <%
	  dim vat,sales
	  vat = 0
	  sales = 0
	 ' vat = formatnumber(rs("nGross"),0) - (formatnumber(rs("nGross"),0)/1.12)
	  vat = (formatnumber(rs("nGross"),2) / 1.12) * .12
	  sales = formatnumber(rs("nGross"),2) - vat
	  %>
      <table width="100%">
      <script>
      function toword(){
		  num = document.getElementById("gross").value;
		var words = toWords(num) + " / 100 ONLY";
		document.getElementById("txt2").value = words ;
		}
	  function getvalue(){
		  document.getElementById("txt3").focus();
	  }
      </script>
      <tr>
      	<td colspan="3">
        <input type="text" id="txt3" onFocus="toword()" style="border:none; width:0; height:0"/>
        <input type="text" id="gross" value="<%=formatnumber(rs("nGross"),2)%>" style="border:none; width:0; height:0"/>
        <input type="text" id="txt2" size="100" style="border:none;" /></td>
      </tr>
      <% if trim(rs("cDocType")) = "DOC 1" then%>
      <tr>
      		<td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><%=formatnumber(sales,2)%></b></td>
            <td width="33%"><b><%=formatnumber(vat,2)%></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="32%" align="right">
            <div style="float:left">
             <b></b>
            </div>
            <div style="float:right">
            <b><%=formatnumber(rs("nGross"),2)%></b>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <% else if trim(rs("cDocType")) = "DOC 2" then%>
      <tr>
      		<td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b></b></td>
            <td width="33%"><b></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="32%" align="right">
            <div style="float:left">
             <b><%=formatnumber(rs("nGross"),2)%></b>
            </div>
            <div style="float:right">
            <b><%=formatnumber(rs("nGross"),2)%></b>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <% else if trim(rs("cDocType")) = "DOC 3" then%>
      <tr>
      		<td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b></b></td>
            <td width="33%" align="right"><b><%=formatnumber(rs("nGross"),2)%></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="32%" align="right">
            <div style="float:left"></div>
            <div style="float:right">
            <b><%=formatnumber(rs("nGross"),2)%></b>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <% 
	  end if
	  end if
	  end if%>
      </table>
      </td>
</tr>
<tr>
	<td valign="bottom" align="center" colspan="6">
    <b>
   <%  response.Write("When Paying please specify state: SI No. ")%><u>&nbsp;&nbsp;&nbsp;<%=rs("cInvNo")%>&nbsp;&nbsp;&nbsp;</u>
    </b><br />
    <b><% response.Write("Print Date:")%></b> <%=date()%> <b><% response.Write("Print Time:")%></b> <%=time()%>
    </td>
</tr>
</table>
<%
rs.movenext
wend

rs.close()
set rs = nothing

end if

if len(citemno) = 0 then
	citemno = ""
else
	citemno = citemno
	intLength = Len(citemno)
	citemno = Left(citemno, intLength - 3)
end if
%>

<script language="javascript">
function Print(){
	location.href='confirmDRPrint.asp?f=si&vid='+document.getElementById("list").value;
}
</script>

<div align="center" id="menu" class="noPrint">
<div style="float:left;">&nbsp;&nbsp;<strong><font size="-1">SALES INVOICE</font></strong></div>
<div style="float:right;">
<input type="hidden" id="list" value="<%=citemno%>" />
<input type="button" value="PRINT REPORTS" onClick="Print();" class="noPrint"/>
<input type="button" value="CLOSE" onClick="window.close();" /></div>
</div>
<%
'response.Redirect("confirmDRPrint.asp?f=si&vid=" & citemno)
%>
</body>
</html>
