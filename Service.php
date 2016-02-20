<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />


</head>

<body>
<div id="header">
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
<br />
<form action="order.php" method="post" name="orderBoh">
<table width="720" align="center" bordercolor="#FF9900">
	<tr>
		<td width="566">
			<table width="698" align="center"  cellpadding="2" cellspacing="2">
				<tr bgcolor="#FF9900">
					<th width="25" colspan="2">Harga Yang ditawarkan untuk print</th>
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">Print colour  1-150 page</td>
					<td align="center">25 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">Print black and white 1-150 page</td>
					<td align="center">20 sen</td>   
				</tr>
				<tr bgcolor="#FF9900">
					<th width="25" colspan="2">Harga Yang ditawarkan untuk potostat</th>
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">15 page and above</td>
					<td align="center">0.09 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">50 page and above</td>
					<td align="center">0.07 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">100 page and above</td>
					<td align="center">0.05 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">1000 page and above</td>
					<td align="center">0.04 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="" colspan="2"><i>Attentions!!! If booked items did't claimed in such a period of 1 - 2 weeks, compound will be charged!!</i> </td>   
				</tr>
			</table>
		</td>
	</tr>
<tr><td  align="center"></td></tr></table>
	</form>



</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>