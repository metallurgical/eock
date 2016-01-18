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
<img src="images/eock2.jpg" />
<font size="+5" style="position:absolute; top:40px; left:135px;">ELECTRONIC OPERATIONAL CENTER KIOSK</font>
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
			        <td align="">50 page keatas</td>
					<td align="center">0.08 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">100 page keatas</td>
					<td align="center">0.06 sen</td>   
				</tr>
				<tr style="overflow:scroll;">
			        <td align="">1000 page keatas</td>
					<td align="center">0.80 sen</td>   
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