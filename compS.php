<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
require_once('menu.php');
if(isset($_SESSION['UserIC']))
{
	
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
            <div style="position:absolute; top:40px; left:80px;">
            Search Product : <input type="text" name="searchID" size="30" /><input type="button" name="submit" value="Search"/>
            </div>
        </div>
	<div id="backgroundMenuStaff">
        <?php setMenu();?>
         
	</div>
</div>  

<div id="content">
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
	



</div>
<div id="kaki" align="center">Copyright 2014. Elektronic Operation System KIOSK (EOCK)</div> 
</body>
</html>
<?php
}
else
{

header("Location:index.php");
}
?>