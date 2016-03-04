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

		if ( $_FILES['myFile']['name'] != "" ) {

			$nameF     = $_FILES['myFile']['name'];
			$sizeF     = $_FILES['myFile']['size'];
			$typeF     = $_FILES['myFile']['type'];
			$tmp_nameF = $_FILES['myFile']['tmp_name'];

			$h        = @fopen($tmp_nameF, 'r');
			$content  = @fread($h, filesize($tmp_nameF));
			$content1 = @addslashes($content);
			@fclose($h);

			$target_dir = "uploads/";
			$target_file = $target_dir . $nameF;
			move_uploaded_file($tmp_nameF, $target_file);

			$sql0 = "update product set product_name = '$nme',product_category = '$cat',product_priceUnit = '$pr',product_stock = '$st', product_status = '$sta', product_pic = '$nameF' where product_id = $idd";

		}
		else {
			$sql0 = "update product set product_name = '$nme',product_category = '$cat',product_priceUnit = '$pr',product_stock = '$st', product_status = '$sta' where product_id = $idd";	
		}
		
		
		
		$query0 = mysql_query($sql0) or die ("Error: ".mysql_error());
		
		?><script>alert("Your product have been updated .. !");
		window.location="productStaff.php";</script><?php
		
		
		
	}