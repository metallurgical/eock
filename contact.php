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
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
<table align="center" style="position:relative; left:20px;">
<tr>
	<td colspan="3"><img src="images/contact/IMG-20150211-WA0000.jpg" width="232" height="258"  /></td>
    
</tr>
<tr>
	<td>Name</td>
    <td>:</td>
    <td>Noorshahida Binti Mohd Zulkifli</td>
</tr>
<tr>
	<td>Phone No.</td>
    <td>:</td>
    <td>014-8088504</td>
</tr>
<tr>
	<td>Email</td>
    <td>:</td>
    <td>syidaeda@gmail.com</td>
</tr>

<tr><td colspan="3">&nbsp;</td></tr>
<tr>
	<td colspan="3"><img src="images/contact/IMG_20140109_083007.jpg" height="17%" width="25%"/></td>    
</tr>
<tr>
	<td>Name</td>
    <td>:</td>
    <td>Nor Erliana Bin Mod Zaib</td>
</tr>
<tr>
	<td>Matrix No.</td>
    <td>:</td>
    <td>13DIP13F1128</td>
</tr>
<tr>
	<td>Phone No.</td>
    <td>:</td>
    <td>013-9105453</td>
</tr>
<tr>
	<td>Email</td>
    <td>:</td>
    <td>yana.zaib@yahoo.com</td>
</tr>
</table>

</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>