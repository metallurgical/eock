<?php 
require_once('Conn/dbconn.php');
if(isset($_POST['hantar']) && isset($_POST['oID']))
{
	$IDORDER = $_POST['oID'];
		mysql_query("update `order` set order_status='APPROVE',order_finishDate='CURDATE()' where order_id = $IDORDER") or die("MySQL Error 1: ".mysql_error());
		
		?><script>window.location.href='home.php';alert("Order Approve !");</script><?php
	}
else {?><script>window.location.href='home.php';alert("Error !");</script><?php }

?>