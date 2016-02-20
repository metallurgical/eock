<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');

if(isset($_POST['hantar']) )
	{
		
		$idd = $_POST['idProduct'];
		$nme = $_POST['name'];
		$cat = $_POST['category'];
		$pr = $_POST['pricePer'];
		$st = $_POST['stock'];
		$sta = $_POST['status'];
		
		
		
		$sql0 = "update product set product_name = '$nme',product_category = '$cat',product_priceUnit = '$pr',product_stock = '$st', product_status = '$sta' where product_id = $idd";	
		$query0 = mysql_query($sql0) or die ("Error: ".mysql_error());
		
		?><script>alert("Your product have been updated .. !");
		window.location="productStaff.php";</script><?php
		
		
		
	}