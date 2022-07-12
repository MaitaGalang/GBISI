<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<!--#include file="../Connections/sqlconnect.asp" -->
<!--#include file="../includes/denied.inc" -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DR Batch Print</title>
<style>
body{
	font-size:10px;
	font-family:Verdana, Geneva, sans-serif;
}
#wrap{
color:#404040;
background-color:#FFF;
width:40%;
margin:0 auto;
padding:0px;

	border: 0px #000 solid;
	-moz-box-shadow: 0px 3px 15px #000;
	-webkit-box-shadow: 0px 3px 5px #000;
	padding: 0;
}
#led{
	background-image:url(../images/print.png);
	background-position:right;
	background-repeat:no-repeat;
	
}
</style>
<script language="javascript">
function backtoprev(){
msg = 'Are you sure you want to back?';
if(!confirm(msg)){
return false;
}else{
history.go(-1);return true;
}
}
</script>
</head>

<body bgcolor="#CCCCCC">
<br /><br /><br /><br />
<center>
<%
set ObjConn = Server.CreateObject("ADODB.Connection")
ObjConn.Open (MM_sqlconnect_STRING)

if request.QueryString("f") = "si" then
	module = "SI"
	path = "SIPrintNew.asp"
	set rs = ObjConn.execute("select cInvNo as seriesNo, cInvPrintNo as printno from sales where cInvNo in('" & request.QueryString("vid") & "') and cCompanyID = '" & session("cCompanyID") & "' order by cInvNo asc")
elseif request.QueryString("f") = "dr" then
	module = "DR"
	path = "DRPrint2.asp"
	dr2 = request("dr2")
	set rs = ObjConn.execute("select cDRNo as seriesNo, cDRPrintNo as printno from dr where cDRNo in('" & request.QueryString("vid") & "') and cCompanyID = '" & session("cCompanyID") & "' order by cDRPrintNo")
elseif request.QueryString("f") = "po" then
	module = "PO"
	if request("r") = "new" then
		path = "POPrint_.asp"
	elseif request("r") = "old" then
		path = "rptPOPrint_.asp"
	end if
	set rs = ObjConn.execute("select cPONo as seriesNo, cPOPrintNo as printno from PO where cPONo in('" & request.QueryString("vid") & "') and cCompanyID = '" & session("cCompanyID") & "'")
elseif request.QueryString("f") = "tt" then
	module = "TT"
	path = "rptTripTicket_Mannual.asp"
	set rs = ObjConn.execute("select cTranNo as seriesNo, '' as printno from tripticket where cTranNo in('" & request.QueryString("vid") & "') and cCompanyID = '" & session("cCompanyID") & "'")
elseif request.QueryString("f") = "wrr" then
	module = "WRR"
	path = "rptWRRPrintv2.asp"
	set rs = ObjConn.execute("select cWRRNo as seriesNo, '' as printno from WRR where cWRRNo in('" & request.QueryString("vid") & "') and cCompanyID = '" & session("cCompanyID") & "'")
end if

dim num
num = 0
while not rs.eof 
	num = num + 1
	drno = drno + "&bull;&nbsp;" + rs("seriesNo") + "<br>"
	printno = printno + "&bull;&nbsp;" + rs("printno") + "<br>"
rs.movenext
wend

%>

<form method="post" action="<%=path%>?varitemno=<%=request.QueryString("vid")%>&dr2=<%=dr2%>">
<div id="wrap">
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="1" style="border-width:1px; border-color:#999999; border-style:solid; border-collapse:collapse" bgcolor="#FFFFFF">
<tr>
	<td bgcolor="#999999"><font color="#000000"><b>CONFIRM <%=module%> PRINT</b></font></td>
</tr>
<tr>
	<td>
    <table cellpadding="2">
    <tr>
    	<td><img src="../images/exclamation.png" /></td>
    	<td>
        	 <b>Notes:</b>
    		Transaction Number marked as "Print" upon clicking the Print button.<br />
Click "OK" in Print Dialog box when it appears for continuous processing.
        </td>
    </tr>
    </table>

    
    </td>
</tr>
<tr>
	<td>
    <div id="led">
    <table width="337" cellpadding="5" align="center">
    <tr>
    	<td align="left">
         <button type="button" style="font-family:Verdana, Geneva, sans-serif; font-size:9px; width:auto; margin:0px; padding:0px; border-width:thin; background-color:#f8f8f8; cursor:pointer" onClick="backtoprev();">
  <table>
    <tr>
      <td><img src="../images/arrow180.png" width="15" height="16" border="0"/></td>
      <td>&nbsp;&nbsp;Back&nbsp;&nbsp;</td>
    </tr>
  </table>
  </button>
        <button type="submit" style="font-family:Verdana, Geneva, sans-serif; font-size:9px; width:auto; margin:0px; padding:0px; border-width:thin; background-color:#f8f8f8; cursor:pointer">
  <table>
    <tr>
      <td><img src="../images/printerarrow.png" border="0"/></td>
      <td>&nbsp;&nbsp;Print&nbsp;&nbsp;</td>
    </tr>
  </table>
  </button>
       </td>
    	<td align="right">Result: <%=num%> Transaction found.</td>
    </tr>
    <tr style="border-bottom:dotted; border-width:1px; border-top:dotted; border-width:1px;">
    	<td width="206"><b><%=module%> Transaction No</b> </td>
        <td width="190"><b><%=module%> Series No.</b></td>
    </tr>
    <tr style="border-bottom:dotted; border-width:1px; border-top:dotted; border-width:1px;">
    	
        <td>
        <%=drno%>
        </td>
         <td>
         <%=printno%>
         </td>
    </tr>
    <tr>
    	<td align="left">
                 <button type="button" style="font-family:Verdana, Geneva, sans-serif; font-size:9px; width:auto; margin:0px; padding:0px; border-width:thin; background-color:#f8f8f8; cursor:pointer" onClick="backtoprev();">
  <table>
    <tr>
      <td><img src="../images/arrow180.png" width="15" height="16" border="0"/></td>
      <td>&nbsp;&nbsp;Back&nbsp;&nbsp;</td>
    </tr>
  </table>
  </button>
        <button type="submit" style="font-family:Verdana, Geneva, sans-serif; font-size:9px; width:auto; margin:0px; padding:0px; border-width:thin; background-color:#f8f8f8; cursor:pointer">
  <table>
    <tr>
      <td><img src="../images/printerarrow.png" border="0"/></td>
      <td>&nbsp;&nbsp;Print&nbsp;&nbsp;</td>
    </tr>
  </table>
  </button>
        </td>
    	<td align="right">Result: <%=num%> Transaction found.</td>
    </tr>
    </table>
    </div>
    </td>
</tr>
<tr>
	<td>
    <b>Notes:</b>
    		Transaction Number marked as "Print" upon clicking the Print button.<br />
Click "OK" in Print Dialog box when it appears for continuous processing.
    </td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>
