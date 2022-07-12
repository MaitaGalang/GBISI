<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
Response.Buffer = True
%>
<!--#include file="../Connections/sqlconnect.asp" -->
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

<script>
	  function getvalue(){
		 // window.print();
		  for(i=1; i<= eval(document.getElementById("ctr").value); i++){
		
		  	document.getElementById("txt3" + i).focus();
		  }
	  }
</script>
<title>Sales Invoice</title>
</head>
<body onLoad="getvalue();">
<% 
Server.Scripttimeout = 50000 

ss = "one,two,three,four,five,six,seven,eight,nine" 
ds = "ten,eleven,twelve,thirteen,fourteen,fifteen,sixteen," & _ 
    "seventeen,eighteen,nineteen" 
ts = "twenty,thirty,forty,fifty,sixty,seventy,eighty,ninety" 
qs = ",thousand,million,billion" 
 
Function nnn2words(iNum) 
    a = split(ss,",") 
    i = iNum mod 10 
    if i > 0 then s = a(i-1) 
    ii = int(iNum mod 100)\10 
    if ii = 1 then  
        s = split(ds,",")(i) 
    elseif ((ii>1) and (ii<10)) then 
        s = split(ts,",")(ii-2) & " " & s 
    end if 
    i = (iNum \ 100) mod 10 
    if i > 0 then s = a(i-1) & " hundred " & s 
    nnn2words = s 
End Function 
 
Function num2words(iNum) 
    i = iNum 
    if i < 0 then b = true: i = i*-1 
    if i = 0 then 
        s="zero" 
    elseif i <= 2147483647 then 
        a = split(qs,",") 
        for j = 0 to 3 
            iii = i mod 1000 
            i = i \ 1000 
            if iii > 0 then s = nnn2words(iii) & _ 
                " " & a(j) & " " & s 
        next 
    else 
        s = "out of range value" 
    end if 
    if b then s = "negative " & s 
    num2words = trim(s) 
End Function 
 
' let's kick the tires: 
 
If (Request("varitemno") <> "")Then 
varitemno = Request("varitemno")

Set ObjConn = Server.CreateObject("ADODB.Recordset")
ObjConn.ActiveConnection = MM_sqlconnect_STRING

dim num,varRated
num = 0
Set rs = Server.CreateObject("ADODB.Recordset")
rs.ActiveConnection = MM_sqlconnect_STRING
rs.ActiveConnection.CommandTimeout = 0
rs.Source =  "select cInvNo,dDate,cCode,cName,cInvPrintNo,cTerm,nGross,cDocType,cRemarks,isnull(cStatus,'') as cStatus from sales2014 where cInvNo in('" & trim(varitemno) & "') and cCompanyID = '" & session("cCompanyID") & "' order by cInvPrintNo ASC"
rs.CursorType = 0
rs.CursorLocation = 2
rs.LockType = 1
rs.Open()

while not rs.eof
num = num + 1
VarRemarks = rs("cRemarks")

if rs("cStatus") = "NONE" Then
	varRated = ""
Else
	varRated = rs("cStatus")
End if

Set rslogfile = Server.CreateObject("ADODB.Recordset")
rslogfile.ActiveConnection = MM_sqlconnect_STRING
rslogfile.ActiveConnection.CommandTimeout = 0
rslogfile.Source =  "Insert into LOGFILE (cCompanyID,dDate,cModule,cTranNo,cEvent,cUser,cMachine) values ('" & session("cCompanyID") & "','" & NOW() & "','Sales Invoice','" & rs("cInvNo") & "', 'PRINTED', '" & UCASE(Session("UserName")) & "', '" &  Session("PCName") & "')"
rslogfile.CursorType = 0
rslogfile.CursorLocation = 2
rslogfile.LockType = 1
rslogfile.Open()

Set rsprintposted = Server.CreateObject("ADODB.Recordset")
rsprintposted.ActiveConnection = MM_sqlconnect_STRING
rsprintposted.ActiveConnection.CommandTimeout = 0
rsprintposted.Source =  "update SALES set lPrintPosted = 1 where cInvNo = '" & trim(rs("cInvNo")) & "'"
rsprintposted.CursorType = 0
rsprintposted.CursorLocation = 2
rsprintposted.LockType = 1
rsprintposted.Open()


Set rsSupplier = Server.CreateObject("ADODB.Recordset")
rsSupplier.ActiveConnection = MM_sqlconnect_STRING
rsSupplier.ActiveConnection.CommandTimeout = 0
rsSupplier.Source =  "select cCode,cName,cAddress,cTIN,isnull(cDescription,'') as rated from CLIENT_CUSTOMER where cCode = '" & trim(rs("cCode")) & "' and cCompanyID = '" & session("cCompanyID") & "'"
rsSupplier.CursorType = 0
rsSupplier.CursorLocation = 2
rsSupplier.LockType = 1
rsSupplier.Open()
	cAddress = rsSupplier("cAddress")
	cTIN = rsSupplier("cTIN")
rsSupplier.close()
set rsSupplier = nothing

'GetRefDR
Set rsrefrefdr = Server.CreateObject("ADODB.Recordset")
rsrefrefdr.ActiveConnection = MM_sqlconnect_STRING
rsrefrefdr.ActiveConnection.CommandTimeout = 0
rsrefrefdr.Source =  "select Top 1 A.crefno, B.dDate, B.cDRPrintNo from sales_t2014 A left join DR2014 B on A.cRefNo=B.cDRNo where A.cInvNo = '" & trim(rs("cInvNo")) & "'"
rsrefrefdr.CursorType = 0
rsrefrefdr.CursorLocation = 2
rsrefrefdr.LockType = 1
rsrefrefdr.Open()
	refrefdr = rsrefrefdr("crefno")
	refrefdrP = rsrefrefdr("cDRPrintNo")
	refrefdrdte = rsrefrefdr("dDate")
rsrefrefdr.close()
set rsrefrefdr = nothing

'GetRefDO
Set rsrefrefso = Server.CreateObject("ADODB.Recordset")
rsrefrefso.ActiveConnection = MM_sqlconnect_STRING
rsrefrefso.ActiveConnection.CommandTimeout = 0
rsrefrefso.Source =  "select Top 1 A.crefno, B.dDelDate from dr_t2014 A left join so2014 B on A.cRefNo=B.cSONo where cDRNo = '" & refrefdr & "' and isnull(A.crefno,'') <> ''"
rsrefrefso.CursorType = 0
rsrefrefso.CursorLocation = 2
rsrefrefso.LockType = 1
rsrefrefso.Open()
if not rsrefrefso.BOF and not rsrefrefso.EOF Then
	refrefso = rsrefrefso("crefno")
	refrefsodte = rsrefrefso("dDelDate")
Else
	refrefso = ""
	refrefsodte = ""

End If
rsrefrefso.close()
set rsrefrefso = nothing


'barcode
Dim strBarNbr1,strBarNbr2
Dim BarData, BarWidth, BarHeight, strMode

strBarNbr1 = rs("cInvPrintNo")
strBarNbr2 = rs("cInvNo")

BarWidth= "2"
BarHeight= "15"
strMode = "code128a"
BarData = "&height=" & BarHeight & "&width=" & BarWidth & "&mode=" & strMode

%>
<table border="0" align="center" cellpadding="0" style="height:10.5in; width:100%; table-layout:fixed <%if num > 1 Then%>;page-break-before:always;<%End if%>">
<tr>
	<td align="right" style="height:5px; padding-right:15px"><IMG SRC="../includes/barcode/DRNoBarcode.asp?code=<%=strBarNbr1%><%=BarData %>"></td>
</tr>
<tr>
	<td align="right" style="height:0.93in; padding-right:15px;" valign="bottom"><b><%=rs("cInvPrintNo")%></b><br><b><%=rs("cInvNo")%></b></td>
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
            <td colspan="3" style="padding-left:1in; padding-top:10px"><div style="overflow:hidden;"><%=trim(rs("cName"))%></div></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="middle">&nbsp;&nbsp;<%=rs("dDate")%></td>
          </tr>
          <tr>
            <td colspan="3" rowspan="2" style="padding-left:0.72in; padding-top:4px" valign="top"><div style="height:0.37in; overflow:hidden;"><%=cAddress%></div></td>
            <td valign="bottom" align="right">TIN:&nbsp;</td>
            <td valign="bottom">&nbsp;&nbsp;<%=cTIN%></td>
          </tr>
          <tr>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" style="padding-left:1.65in; padding-top:10px"><%=trim(rs("cCode"))%></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="middle">&nbsp;&nbsp;<%=rs("cTerm")%></td>
          </tr>
          <tr>
            <td colspan="2" style="padding-left:1.65in"><%=refrefso%></td>
            <td style="padding-left:0.55in"><%=refrefsodte%></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-left:1.65in; width:2.5in"><%=refrefdrP%></td>
            <td style="padding-left:0.55in"><%=refrefdrdte%></td>
            <td valign="bottom">&nbsp;</td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" style="height: 0.21in">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" style="table-layout:fixed">
  <%
						Dim varGross,varLessVat,varNetVat
						Set v = Server.CreateObject("ADODB.Recordset")
						v.ActiveConnection = MM_sqlconnect_STRING
						v.ActiveConnection.CommandTimeout = 0
						v.Source =  "select distinct(cRefNo) as 'abc' from sales_t2014 where cInvNo = '" & rs("cInvNo") & "' and cCompanyID = '" & session("cCompanyID") & "' and not nAmount = 0"
						v.CursorType = 0
						v.CursorLocation = 2
						v.LockType = 1
						v.Open()	
							
							dim f
							f = 0
							while not v.eof
								f = f + 1
							v.movenext
							wend
							
							v.close()
							set v = nothing
							'response.Write(f)
						
						
						Set rsDRT = Server.CreateObject("ADODB.Recordset")
						rsDRT.ActiveConnection = MM_sqlconnect_STRING
						rsDRT.ActiveConnection.CommandTimeout = 0
						rsDRT.Source =  "select cItemNo,cDesc,cRefNo,nQty,cUnit,nPrice,nAmount,lNonVat from sales_t2014 where cInvNo = '" & rs("cInvNo") & "' and cCompanyID = '" & session("cCompanyID") & "' and not nAmount = 0 order by nIdentity ASC"
						rsDRT.CursorType = 0
						rsDRT.CursorLocation = 2
						rsDRT.LockType = 1
						rsDRT.Open()
						
						dim ctr
						ctr = 0
						varGross = 0
						varLessVat = 0
						varNetVat = 0
						varNonVat = 0
						varNonVatAmt = 0
						varVatSales = 0
						while not rsDRT.eof
						ctr = ctr + 1
						%>
          <tr>
            
    <%
									if f = 1 then
										'----------------
										if ctr = 1 then
											
											Set cPrintNo = Server.CreateObject("ADODB.Recordset")
											cPrintNo.ActiveConnection = MM_sqlconnect_STRING
											cPrintNo.ActiveConnection.CommandTimeout = 0
											cPrintNo.Source =  "select cDRPrintNo from DR2014 where cDRNo = '" & rsDRT("cRefNo") & "' and cCompanyID = '" & session("cCompanyID") & "'"
											cPrintNo.CursorType = 0
											cPrintNo.CursorLocation = 2
											cPrintNo.LockType = 1
											cPrintNo.Open()
											if cPrintNo.eof then
												'response.Write("")
											else
												dim cPrintNo2
												cPrintNo2 = cPrintNo("cDRPrintNo")
												if cPrintNo("cDRPrintNo") = cPrintNo2 then
													'response.Write(cPrintNo("cDRPrintNo"))
												else
												end if
											end if
											
											cPrintNo.close()
											set cPrintNo = nothing
										end if
										'---------------
									else
										'----------------
										
											
											Set cPrintNo = Server.CreateObject("ADODB.Recordset")
											cPrintNo.ActiveConnection = MM_sqlconnect_STRING
											cPrintNo.ActiveConnection.CommandTimeout = 0
											cPrintNo.Source =  "select cDRPrintNo from DR2014 where cDRNo = '" & rsDRT("cRefNo") & "' and cCompanyID = '" & session("cCompanyID") & "'"
											cPrintNo.CursorType = 0
											cPrintNo.CursorLocation = 2
											cPrintNo.LockType = 1
											cPrintNo.Open()
											
											if cPrintNo.eof then
												'response.Write("")
											else
												dim cPrintNo22
												cPrintNo22 = cPrintNo("cDRPrintNo")
												if cPrintNo("cDRPrintNo") = cPrintNo22 then
													'response.Write(cPrintNo("cDRPrintNo"))
												else
												end if
											end if
											
											cPrintNo.close()
											set cPrintNo = nothing
										'------------------
									end if
									
									
								
								'response.Write(rsDRT("cRefNo"))
								%>
            
            <td style="width:0.87in" class="smaller" align="right"><%=formatnumber(rsDRT("nQty"),2)%>&nbsp;&nbsp;</td>
            <td style="width:0.5in" nowrap class="smaller">&nbsp;<%=rsDRT("cUnit")%></td>
            <td style="width:3.1in" nowrap class="smaller">
            <div style="width:2.95in; overflow:hidden;">
            	<div style="width:0.65in; float:left">
            	&nbsp;&nbsp;<%=rsDRT("cItemNo")%> 
				</div>
              <div>
				<%=rsDRT("cDesc")%>
                </div>
            </div>
            </td>
            <td style="width:0.8in" align="right" class="smaller"><%=formatnumber(rsDRT("nPrice"),2)%>&nbsp;&nbsp;</td>
            <td style="width:0.8in" align="right" class="smaller">&nbsp;</td>
            <td align="right" class="smaller"><%=formatnumber(rsDRT("nAmount"),2)%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
  <%
  'varGross = cdbl(varGross) + cdbl(rsDRT("nAmount"))
 
  If rsDRT("lNonVat") = "False" Then
  	varNonVat = cdbl(varNonVat) + cdbl(rsDRT("nAmount"))
	varGross = cdbl(varGross) + cdbl(rsDRT("nAmount"))
  Else
	varNonVatAmt = cdbl(varNonVatAmt) + cdbl(rsDRT("nAmount"))
  End if
  

						rsDRT.movenext
						wend
						

		  varLessVat = (cdbl(varNonVat)/1.12)*0.12
		  varNetVat = (cdbl(varGross)+cdbl(varNonVatAmt))-cdbl(varLessVat)
		  varVatSales = cdbl(varNonVat)-cdbl(varLessVat)
						
						rsDRT.close()
						set rsDRT = nothing
						%>
          <%
		  If VarRemarks <> "" Then
		  %>
		  <%
		  End if
		  VarRemarks = ""
		  %>

          <tr>
            <td colspan="6">
            <table width="100%" border="0" cellpadding="0" style="table-layout:fixed">
              <tr>
                <td rowspan="3" style="width:5.25in;"><%=Response.Write("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" & VarRemarks)%></td>
                <td style="width:1in;" class="smaller">&nbsp;</td>
                <td style="" class="smaller" align="right" valign="bottom">&nbsp;</td>
              </tr>
              <tr>
                <td style="width:1in;" class="smaller">Total Sales</td>
                <td class="smaller" align="right" valign="bottom"><%
                    If varRated = "" Then
                    
                        'if (cdbl(varGross)+cdbl(varNonVatAmt)) <> varNetVat Then
                            Response.Write(formatnumber(cdbl(varGross)+cdbl(varNonVatAmt)))
                        'Response.Write(formatnumber(varGross))
                        'Response.Write("<br>" & formatnumber(varNonVat))
                        'End if
                    Else
                        Response.Write("")
                    End if
                    %>&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:1in;" class="smaller">Vatable Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">&nbsp;&nbsp;
                  <%
                    If varRated = "" Then
                        Response.Write(formatnumber(varNetVat))
                    Else
                        Response.Write("")
                    End if
                %>&nbsp;&nbsp;&nbsp;&nbsp;
               </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">VAT-Exempt Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">
                  <%
                    If varRated = "VAT EXEMPT" Then
                        Response.Write(formatnumber(varGross))
                    ElseIf cdbl(varNonVatAmt) <> 0 Then
                        Response.Write(formatnumber(varNonVatAmt))
                    Else
                        Response.Write("")
                    End if
                    %>&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">Zero rated Sales</td>
                <td style="" class="smaller" align="right" valign="bottom">
                  <%
                    If varRated = "ZERO RATED" Then
                        Response.Write(formatnumber(varGross))
                    Else
                        Response.Write("")
                    End if
                    %>&nbsp;&nbsp;&nbsp;&nbsp;
               </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">VAT-12%</td>
                <td style="" class="smaller" align="right" valign="bottom">
                  <%
                    If varRated = "" and cdbl(varGross) <> 0 Then
                        If cdbl(varLessVat) <> 0 Then
                            Response.Write(formatnumber(varLessVat))
                        Else
                            Response.Write("")
                        End if					
                    Else
                        Response.Write("")
                    End if
                %>&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              </tr>
              <tr>
                <td style="width:5.25in;">&nbsp;</td>
                <td style="width:1in;" class="smaller">Gross Sales</td>
                <td style="" class="smaller" align="right" valign="bottom"><%=formatnumber(cdbl(varGross)+cdbl(varNonVatAmt))%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table>
           </td>
          </tr>
          
       
      </table>

    </td>
</tr>

<tr>
	<td align="right" valign="bottom" style="height:0.21in;"><%=formatnumber(cdbl(varGross)+cdbl(varNonVatAmt))%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="right" valign="bottom" style="height:0.2in">&nbsp;</td>
</tr>
<tr>
	<td align="right" valign="bottom" style="height:0.31in"><%=formatnumber(cdbl(varGross)+cdbl(varNonVatAmt))%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td style="padding-left:2.5in; padding-bottom:0.22in" valign="bottom"><%=rs("cInvNo")%></td>
</tr>
</table>
<%
rs.movenext
wend 


rs.close()
set rs = nothing
%>
<input type="hidden" id="ctr" name="ctr" value="<%=num%>" />
<%end if%>
</body>
</html>
